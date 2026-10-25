<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Throwable;

/**
 * Reads the business rating and reviews via the Google Places API (New).
 *
 * Google only returns up to 5 reviews per place through this API, so the
 * "best 10" can never be more than 5 until the Business Profile API is used.
 * Until the API is set up (or if it fails), the reviews in config/moesika.php are shown.
 */
class GoogleReviews
{
    private const API = 'https://places.googleapis.com/v1/places/';

    /**
     * @return array{rating: ?float, count: int, reviews: array, url: ?string}
     */
    public function summary(int $limit = 10): array
    {
        $summary = config('services.google_places.key') && $this->placeId() ? $this->live() : null;

        if (empty($summary['reviews'])) {
            $summary = $this->manual();
        }

        $summary['reviews'] = array_slice($summary['reviews'], 0, $limit);

        return $summary;
    }

    private function live(): ?array
    {
        $summary = Cache::get('google.reviews');

        if ($summary === null || Cache::missing('google.reviews.fresh')) {
            try {
                $summary = $this->fetch();

                Cache::put('google.reviews', $summary, now()->addDay());
                Cache::put('google.reviews.fresh', true, now()->addHours(6));
            } catch (Throwable $e) {
                report($e);

                // Back off briefly rather than hitting the API on every page load
                Cache::put('google.reviews.fresh', true, now()->addMinutes(5));
            }
        }

        return $summary;
    }

    /**
     * Reviews copied in by hand from her Google listing.
     */
    private function manual(): array
    {
        $reviews = collect(config('moesika.reviews'))
            ->map(fn (array $review) => [
                'author' => $review['author'],
                'photo' => null,
                'rating' => $review['rating'],
                'text' => $review['text'],
                'when' => 'Google review',
                'published' => '',
                'url' => null,
            ]);

        return [
            'rating' => $reviews->isEmpty() ? null : round($reviews->avg('rating'), 1),
            'count' => $reviews->count(),
            'reviews' => $reviews->sortByDesc('rating')->values()->all(),
            'url' => $this->placeId()
                ? 'https://www.google.com/maps/search/?api=1&query='.rawurlencode(config('services.google_places.business_name')).'&query_place_id='.$this->placeId()
                : null,
        ];
    }

    /**
     * Where the "Leave a review" button goes: the review link from her Google Business Profile
     * if set, else Google's review form for the Place ID, else her listing found by name on Google Maps.
     */
    public function writeReviewUrl(): string
    {
        if (config('services.google_places.review_url')) {
            return config('services.google_places.review_url');
        }

        if ($this->placeId()) {
            return 'https://search.google.com/local/writereview?placeid='.$this->placeId();
        }

        return 'https://www.google.com/maps/search/?api=1&query='.rawurlencode(config('services.google_places.business_name'));
    }

    private function placeId(): ?string
    {
        return config('services.google_places.place_id');
    }

    private function fetch(): array
    {
        $place = Http::timeout(5)
            ->withHeaders([
                'X-Goog-Api-Key' => config('services.google_places.key'),
                'X-Goog-FieldMask' => 'rating,userRatingCount,reviews,googleMapsUri',
            ])
            ->get(self::API.$this->placeId(), ['languageCode' => 'en'])
            ->throw()
            ->json();

        $reviews = collect($place['reviews'] ?? [])
            ->map(fn (array $review) => [
                'author' => $review['authorAttribution']['displayName'] ?? 'Google user',
                'photo' => $review['authorAttribution']['photoUri'] ?? null,
                'rating' => (int) ($review['rating'] ?? 0),
                'text' => trim($review['text']['text'] ?? $review['originalText']['text'] ?? ''),
                'when' => $review['relativePublishTimeDescription'] ?? '',
                'published' => $review['publishTime'] ?? '',
                'url' => $review['googleMapsUri'] ?? null,
            ])
            // Star-only reviews leave an empty slide, so only show reviews with words
            ->filter(fn (array $review) => $review['text'] !== '')
            ->sortBy([['rating', 'desc'], ['published', 'desc']])
            ->values()
            ->all();

        return [
            'rating' => isset($place['rating']) ? (float) $place['rating'] : null,
            'count' => (int) ($place['userRatingCount'] ?? 0),
            'reviews' => $reviews,
            'url' => $place['googleMapsUri'] ?? null,
        ];
    }
}
