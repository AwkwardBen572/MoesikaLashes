<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ReviewsSectionTest extends TestCase
{
    private function review(int $rating, string $text, string $published): array
    {
        return [
            'rating' => $rating,
            'text' => ['text' => $text],
            'publishTime' => $published,
            'relativePublishTimeDescription' => 'a month ago',
            'authorAttribution' => ['displayName' => "Client {$text}"],
            'googleMapsUri' => 'https://maps.google.com/review',
        ];
    }

    public function test_no_reviews_message_without_google_configured(): void
    {
        config(['services.google_places.key' => null, 'services.google_places.place_id' => null, 'services.google_places.review_url' => null, 'moesika.reviews' => []]);
        Http::fake();

        $this->get('/')
            ->assertOk()
            ->assertSee('No reviews yet.')
            ->assertSee('Leave a Google review')
            ->assertSee('https://www.google.com/maps/search/?api=1&amp;query=Moesika%20Lashes%20by%20Tania', false);

        Http::assertNothingSent();
    }

    public function test_best_ten_reviews_are_shown_highest_rated_and_newest_first(): void
    {
        config(['services.google_places.key' => 'test-key', 'services.google_places.place_id' => 'PLACE123']);

        $reviews = [$this->review(3, 'Okay', '2026-09-01T00:00:00Z'), $this->review(5, 'Stars only', '2026-10-01T00:00:00Z')];
        $reviews[1]['text']['text'] = '';
        foreach (range(1, 10) as $i) {
            $reviews[] = $this->review(5, "Lovely{$i}", sprintf('2026-08-%02dT00:00:00Z', $i));
        }
        $reviews[] = $this->review(4, 'Good', '2026-10-20T00:00:00Z');

        Http::fake(['places.googleapis.com/*' => Http::response([
            'rating' => 4.8,
            'userRatingCount' => 23,
            'googleMapsUri' => 'https://maps.google.com/?cid=1',
            'reviews' => $reviews,
        ])]);

        $this->get('/')
            ->assertOk()
            ->assertSee('4.8')
            ->assertSee('23 Google reviews')
            ->assertSeeInOrder(['Lovely10', 'Lovely9', 'Lovely1'])
            ->assertDontSee('Client Good')
            ->assertDontSee('Client Okay')
            ->assertDontSee('Client Stars only')
            ->assertSee('https://search.google.com/local/writereview?placeid=PLACE123', false)
            ->assertDontSee('No reviews yet.');

        Http::assertSent(fn ($request) => $request->hasHeader('X-Goog-Api-Key', 'test-key')
            && str_contains($request->url(), 'places/PLACE123'));
    }

    public function test_business_profile_review_link_is_preferred(): void
    {
        config(['services.google_places.review_url' => 'https://g.page/r/abc123/review']);

        $this->get('/')->assertSee('href="https://g.page/r/abc123/review"', false);
    }

    public function test_leave_a_review_link_shows_even_when_there_are_no_reviews(): void
    {
        config(['services.google_places.key' => 'test-key', 'services.google_places.place_id' => 'PLACE123', 'moesika.reviews' => []]);
        Http::fake(['places.googleapis.com/*' => Http::response(['rating' => null, 'userRatingCount' => 0])]);

        $this->get('/')
            ->assertSee('No reviews yet.')
            ->assertSee('https://search.google.com/local/writereview?placeid=PLACE123', false);
    }

    public function test_manual_reviews_show_until_the_api_is_set_up(): void
    {
        config(['services.google_places.key' => null]);
        Http::fake();

        $this->get('/')
            ->assertOk()
            ->assertSee('2 Google reviews')
            ->assertSeeInOrder(['Michelle', 'Francois'])
            ->assertSee('lash retention is incredible')
            ->assertSee('beard and eyebrow wax')
            ->assertDontSee('No reviews yet.');

        Http::assertNothingSent();
    }

    public function test_api_failure_falls_back_to_manual_reviews(): void
    {
        config(['services.google_places.key' => 'bad-key', 'services.google_places.place_id' => 'PLACE123']);
        Http::fake(['places.googleapis.com/*' => Http::response(['error' => ['message' => 'API key not valid']], 400)]);

        $this->get('/')->assertOk()->assertSee('Michelle')->assertDontSee('No reviews yet.');
    }
}
