<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

/**
 * Reads recent posts via the Instagram API (Instagram Login).
 *
 * Requires a long-lived access token for a Business or Creator account.
 * Tokens last 60 days; `php artisan instagram:refresh-token` renews it and
 * the renewed token is kept in storage so it survives cache clears.
 */
class InstagramFeed
{
    private const API = 'https://graph.instagram.com';

    private const TOKEN_FILE = 'instagram-token';

    public function posts(int $limit = 9): Collection
    {
        if (! $this->token()) {
            return collect();
        }

        $posts = Cache::get('instagram.posts');

        if ($posts === null || Cache::missing('instagram.posts.fresh')) {
            try {
                $posts = $this->fetch();

                // Media URLs are signed and expire, so stale posts are only kept for a day
                Cache::put('instagram.posts', $posts, now()->addDay());
                Cache::put('instagram.posts.fresh', true, now()->addHour());
            } catch (Throwable $e) {
                report($e);

                // Back off briefly rather than hitting the API on every page load
                Cache::put('instagram.posts.fresh', true, now()->addMinutes(5));
            }
        }

        return collect($posts ?? [])->take($limit);
    }

    public function refreshToken(): void
    {
        $token = Http::timeout(10)
            ->get(self::API.'/refresh_access_token', [
                'grant_type' => 'ig_refresh_token',
                'access_token' => $this->token(),
            ])
            ->throw()
            ->json('access_token');

        Storage::put(self::TOKEN_FILE, $token);
    }

    public function token(): ?string
    {
        return Storage::exists(self::TOKEN_FILE)
            ? trim(Storage::get(self::TOKEN_FILE))
            : config('moesika.instagram_token');
    }

    private function fetch(): array
    {
        $media = Http::timeout(5)
            ->get(self::API.'/me/media', [
                'fields' => 'id,caption,media_type,media_url,thumbnail_url,permalink',
                'limit' => 12,
                'access_token' => $this->token(),
            ])
            ->throw()
            ->json('data', []);

        return collect($media)
            ->map(fn (array $post) => [
                'image' => $post['media_type'] === 'VIDEO' ? ($post['thumbnail_url'] ?? null) : $post['media_url'],
                'url' => $post['permalink'],
                'caption' => Str::limit(strtok($post['caption'] ?? '', "\n") ?: '', 120),
            ])
            ->filter(fn (array $post) => $post['image'])
            ->values()
            ->all();
    }
}
