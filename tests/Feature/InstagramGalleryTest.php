<?php

namespace Tests\Feature;

use App\Services\InstagramFeed;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class InstagramGalleryTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake();
    }

    public function test_instagram_is_not_called_without_a_token(): void
    {
        config(['moesika.instagram_token' => null]);
        Http::fake();

        $this->get('/')
            ->assertOk()
            ->assertSeeInOrder(['https://www.instagram.com/moe.sika_lashes/', 'https://www.instagram.com/moesikacollective_/'], false);

        Http::assertNothingSent();
    }

    public function test_gallery_shows_local_photos_without_a_token(): void
    {
        config(['moesika.instagram_token' => null]);

        $this->get('/')
            ->assertOk()
            ->assertSee('images/gallery/01-studio-lash-application.jpeg', false)
            ->assertSee('alt="Volume lashes blue eyes"', false)
            ->assertSeeInOrder(['01-studio-lash-application', '06-lip-blush-before-and-after-2'], false);
    }

    public function test_gallery_shows_instagram_posts(): void
    {
        config(['moesika.instagram_token' => 'test-token']);
        Http::fake([
            'graph.instagram.com/me/media*' => Http::response(['data' => [
                ['id' => '1', 'media_type' => 'IMAGE', 'media_url' => 'https://cdn.example/lash-1.jpg', 'permalink' => 'https://www.instagram.com/p/one/', 'caption' => "Soft volume set\n#lashes"],
                ['id' => '2', 'media_type' => 'VIDEO', 'media_url' => 'https://cdn.example/video.mp4', 'thumbnail_url' => 'https://cdn.example/thumb.jpg', 'permalink' => 'https://www.instagram.com/p/two/'],
            ]]),
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('https://cdn.example/lash-1.jpg', false)
            ->assertSee('alt="Soft volume set"', false)
            ->assertSee('https://cdn.example/thumb.jpg', false)
            ->assertDontSee('video.mp4')
            ->assertSee('https://www.instagram.com/p/two/', false);
    }

    public function test_api_failure_does_not_break_the_page(): void
    {
        config(['moesika.instagram_token' => 'expired-token']);
        Http::fake(['graph.instagram.com/*' => Http::response(['error' => ['message' => 'Invalid token']], 400)]);

        $this->get('/')->assertOk();
    }

    public function test_refreshed_token_is_stored_and_preferred(): void
    {
        config(['moesika.instagram_token' => 'old-token']);
        Http::fake(['graph.instagram.com/refresh_access_token*' => Http::response(['access_token' => 'new-token'])]);

        $this->artisan('instagram:refresh-token')->assertSuccessful();

        $this->assertSame('new-token', app(InstagramFeed::class)->token());
    }
}
