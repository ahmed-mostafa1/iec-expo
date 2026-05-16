<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
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

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'gotenberg' => [
        'url' => env('GOTENBERG_URL'),
    ],

    'cloudconvert' => [
        'key' => env('CLOUDCONVERT_API_KEY'),
    ],

    'google_analytics' => [
        'property_id' => env('GA4_PROPERTY_ID'),
        'credentials_path' => env('GA4_CREDENTIALS_PATH', storage_path('app/private/google-analytics/service-account.json')),
        'import_start_date' => env('GA4_IMPORT_START_DATE', '2020-01-01'),
        'sync_chunk_days' => (int) env('GA4_SYNC_CHUNK_DAYS', 31),
    ],

    'contract_templates' => [
        'sponsor' => array_values(array_filter(explode(PATH_SEPARATOR, env('SPONSOR_CONTRACT_TEMPLATE_PATHS', '')))),
        'shared' => array_values(array_filter(explode(PATH_SEPARATOR, env('CONTRACT_TEMPLATE_PATHS', '')))),
    ],

];
