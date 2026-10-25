<?php

/*
|--------------------------------------------------------------------------
| Moesika Lashes site content
|--------------------------------------------------------------------------
|
| Editable business details for the one-page site. Service prices are in
| Rand; training course prices are intentionally not shown on the site.
|
*/

return [

    // International format, digits only (066 342 1732)
    'whatsapp' => env('MOESIKA_WHATSAPP', '27663421732'),

    'phone' => env('MOESIKA_PHONE', '066 342 1732'),

    // Announcement bar above the menu; set to null to hide it
    'notice' => 'Fully booked for the rest of 2026',

    // Instagram handles, main account first
    'instagram' => ['moe.sika_lashes', 'moesikacollective_'],

    'facebook' => env('MOESIKA_FACEBOOK', 'https://www.facebook.com/taniassweet/'),

    // Long-lived Instagram API token for the main account (Business/Creator), powers the gallery
    'instagram_token' => env('INSTAGRAM_ACCESS_TOKEN'),

    'email' => env('MOESIKA_EMAIL'),

    'location' => env('MOESIKA_LOCATION', 'Home studio, Kempton Park'),

    'hours' => [
        'Monday – Friday' => 'By appointment',
        'Saturday' => 'By appointment',
        'Sunday' => 'Closed',
    ],

    'services' => [
        [
            'category' => 'Lash Extensions',
            'items' => [
                [
                    'name' => 'Classic Set',
                    'description' => 'One extension to one natural lash for a soft, polished, mascara-like finish.',
                    'prices' => ['Full Set' => 480, '4 Week Fill' => 430, '3 Week Fill' => 380, '2 Week Fill' => 330],
                ],
                [
                    'name' => 'Hybrid Set',
                    'description' => 'A blend of classic and volume lashes for texture with a natural edge.',
                    'prices' => ['Full Set' => 580, '4 Week Fill' => 480, '3 Week Fill' => 430, '2 Week Fill' => 380],
                ],
                [
                    'name' => 'Volume Set',
                    'description' => 'Handmade fans for a fuller, fluffier look that still feels light.',
                    'prices' => ['Full Set' => 680, '4 Week Fill' => 580, '3 Week Fill' => 480, '2 Week Fill' => 430],
                ],
            ],
        ],
        [
            'category' => 'Permanent Makeup',
            'items' => [
                [
                    'name' => 'Lip Blush',
                    'description' => 'A subtle wash of colour that enhances your natural lip shape.',
                    'prices' => ['Full Treatment' => 1000, 'Touch Up' => 800],
                ],
                [
                    'name' => 'Brows',
                    'description' => 'Soft, defined brows that wake up looking done.',
                    'prices' => ['Full Treatment' => 800, 'Touch Up' => 650],
                ],
                [
                    'name' => 'Eyeliner',
                    'description' => 'A lasting, flattering line that frames and defines the eyes.',
                    'prices' => ['Full Treatment' => 700, 'Touch Up' => 550],
                ],
            ],
        ],
        [
            'category' => 'Lash, Brow & Wax',
            'items' => [
                [
                    'name' => 'Lashes',
                    'prices' => ['Lash Lift' => 300, 'Lash Shampoo' => 160, 'Lash Removal' => 150],
                ],
                [
                    'name' => 'Brows',
                    'prices' => ['Brow Lamination' => 300, 'Henna Brows' => 100, 'Brow Tint' => 80],
                ],
                [
                    'name' => 'Wax',
                    'prices' => ['Brow' => 80, 'Lip' => 50, 'Chin' => 50],
                ],
            ],
        ],
    ],

    // Moesika Lashes Academy
    'academy_why' => [
        'Professional hands-on training',
        'Beginner friendly',
        'Small class sizes',
        'Individual attention',
        'Live model practice',
        'Business guidance',
        'Ongoing support after training',
        'High-quality products and techniques',
        'Nationally recognised QCTO Accredited option available',
    ],

    'courses' => [
        [
            'name' => 'QCTO Accredited Professional Lash Course',
            'badge' => 'QCTO Accredited',
            'duration' => '3 days practical training',
            'hours' => '8:00–12:00',
            'summary' => 'Our most comprehensive course, ideal for students wanting a recognised qualification and a long-term career in the beauty industry.',
            'highlights' => ['Professional lash starter kit', 'QCTO-accredited qualification', 'Ongoing mentor support'],
            'includes' => [
                'Professional Lash Starter Kit', 'Classic Lash Extensions', 'Hybrid Lash Extensions', 'Volume Lash Extensions',
                'Lash Styling & Mapping', 'Eye Shape Analysis', 'Client Consultation', 'Health, Hygiene & Safety',
                'Contraindications', 'Lash Growth Cycle', 'Product Knowledge', 'Adhesive Science',
                'Isolation Techniques', 'Lash Application', 'Refills & Removals', 'Retention Techniques',
                'Troubleshooting', 'Client Aftercare', 'Pricing Your Services', 'Business & Marketing Basics',
                'Photography Tips', 'Live Model Practice', 'Theory & Practical Assessments',
            ],
        ],
        [
            'name' => 'Professional Classic & Volume Course',
            'badge' => 'Certificate',
            'popular' => true,
            'duration' => '3 days',
            'hours' => '8:00–12:00',
            'summary' => 'Perfect for students who want professional lash training without completing the QCTO qualification.',
            'highlights' => ['Professional lash kit', 'Certificate of attendance', 'Ongoing support'],
            'includes' => [
                'Professional Lash Kit', 'Classic Lash Extensions', 'Volume Lash Extensions', 'Lash Mapping',
                'Theory Training', 'Practical Training', 'Live Model Practice', 'Client Consultation',
                'Health & Hygiene', 'Product Knowledge', 'Refills & Removals', 'Client Aftercare',
                'Business Basics', 'Certificate of Attendance', 'Ongoing Support',
            ],
        ],
        [
            'name' => 'Beginner Classic & Volume Course',
            'badge' => 'Beginner',
            'duration' => '1 day',
            'hours' => '8:00–12:00',
            'summary' => 'Perfect for someone wanting to learn the fundamentals before investing in a full professional course.',
            'highlights' => ['Supply your own kit', 'Certificate of attendance', 'One month after-training support'],
            'includes' => [
                'Basic Theory', 'Classic Lash Extensions', 'Introduction to Volume Lashes', 'Basic Lash Mapping',
                'Product Knowledge', 'Health & Safety', 'Practical Application', 'Certificate of Attendance',
                'One Month After-Training Support',
            ],
        ],
    ],

    // QCTO course intakes; finished dates are crossed out and running ones marked "In progress"
    'training_dates' => [
        ['start' => '2026-10-26', 'end' => '2026-10-28', 'label' => '26–28 October 2026'],
        ['start' => '2026-11-23', 'end' => '2026-11-25', 'label' => '23–25 November 2026'],
        ['start' => '2027-01-25', 'end' => '2027-01-27', 'label' => '25–27 January 2027'],
        ['start' => '2027-02-22', 'end' => '2027-02-24', 'label' => '22–24 February 2027'],
        ['start' => '2027-03-23', 'end' => '2027-03-25', 'label' => '23–25 March 2027'],
    ],

    // Google reviews copied in by hand; shown until the Google Places API key is set up
    'reviews' => [
        [
            'author' => 'Michelle',
            'rating' => 5,
            'text' => "I've been going to Moesika Lashes by Tania for over a year now, and I honestly couldn't recommend her enough. She's absolutely amazing at what she does, and her lash retention is incredible. My lashes always last so well, and the quality of her work speaks for itself. She's consistent, professional, and genuinely passionate about what she does. I wouldn't trust anyone else with my lashes. If you're looking for a lash tech who delivers beautiful results and amazing retention, Tania is definitely the one.",
        ],
        [
            'author' => 'Francois',
            'rating' => 5,
            'text' => 'Had a great experience at Moesika Lashes for a beard and eyebrow wax! Everything was done super professionally, quick, and neat. Highly recommend their wax services!',
        ],
    ],

];
