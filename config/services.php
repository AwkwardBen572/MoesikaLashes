<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Resend, Postmark, AWS, and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    // Powers the reviews section; the Place ID is the business listing on Google Maps
    'google_places' => [
        'key' => env('GOOGLE_PLACES_API_KEY'),
        // Moesika Lashes by Tania (decoded from her Google Maps link)
        'place_id' => env('GOOGLE_PLACE_ID', 'ChIJU97Zuu8VlR4R01v_cRe3Lgc'),
        // Optional short link from Google Business Profile > "Ask for reviews", e.g. https://g.page/r/.../review
        'review_url' => env('GOOGLE_REVIEW_URL'),
        // Used to find the listing on Google Maps when neither of the above is set
        'business_name' => env('GOOGLE_BUSINESS_NAME', 'Moesika Lashes by Tania'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

];
