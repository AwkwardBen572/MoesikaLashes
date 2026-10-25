<?php

use App\Services\InstagramFeed;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('instagram:refresh-token', function (InstagramFeed $feed) {
    if (! $feed->token()) {
        $this->warn('No Instagram token configured. Set INSTAGRAM_ACCESS_TOKEN in .env first.');

        return;
    }

    $feed->refreshToken();
    $this->info('Instagram access token refreshed.');
})->purpose('Renew the long-lived Instagram access token before it expires');

Schedule::command('instagram:refresh-token')->weekly();
