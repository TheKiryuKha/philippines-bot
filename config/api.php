<?php

declare(strict_types=1);

return [

    'cdek' => [
        /*
        |--------------------------------------------------------------------------
        | CDEK Account
        |--------------------------------------------------------------------------
        |
        | This value is your account in CDEK API, which will be used when application
        | need's to communicate with CDEK service's.
        |
        */

        'account' => env('CDEK_ACCOUNT', 'TEST'),

        /*
        |--------------------------------------------------------------------------
        | CDEK Secret
        |--------------------------------------------------------------------------
        |
        | This value is secret for your account in CDEK API, which will be used when application
        | need's to communicate with CDEK service's.
        |
        */

        'secret' => env('CDEK_SECRET', ''),
    ],

    'bot' => [
        /*
        |--------------------------------------------------------------------------
        | API url
        |--------------------------------------------------------------------------
        |
        | This value is the link to the current working api of the telegram bot
        |
        */

        'api_url' => env('BOT_API_URL', 'http://telegram-bot:1002'),
    ],
];
