<?php

namespace Tests\Feature;

use Tests\TestCase;

class TrainingSectionTest extends TestCase
{
    public function test_course_options_are_listed_without_prices(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('QCTO Accredited Professional Lash Course')
            ->assertSee('Professional Classic &amp; Volume Course', false)
            ->assertSee('Beginner Classic &amp; Volume Course', false)
            ->assertDontSee('R10,000')
            ->assertDontSee('R7,000')
            ->assertDontSee('R4,500');
    }

    public function test_certificate_course_is_marked_most_popular(): void
    {
        $this->get('/')->assertSeeInOrder(['Most popular', 'Professional Classic &amp; Volume Course'], false);
    }

    public function test_training_dates_show_completed_in_progress_and_upcoming(): void
    {
        $this->travelTo('2026-11-24');

        $this->get('/')
            ->assertSeeInOrder([
                'line-through">26–28 October 2026', 'Completed',
                '23–25 November 2026', 'In progress',
                '25–27 January 2027',
                '22–24 February 2027',
                '23–25 March 2027',
            ], false)
            ->assertDontSee('New dates coming soon');
    }

    public function test_last_day_of_training_is_still_in_progress(): void
    {
        $this->travelTo('2026-10-28 15:00');

        $this->get('/')->assertSeeInOrder(['26–28 October 2026', 'In progress'], false);
    }

    public function test_message_shown_when_no_dates_remain(): void
    {
        $this->travelTo('2027-04-01');

        $this->get('/')
            ->assertSee('New dates coming soon')
            ->assertSee('line-through">23–25 March 2027', false);
    }
}
