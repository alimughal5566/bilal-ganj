<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'google' => [
        'client_id' => '442305154513-55qp23pshu85phqe2d1kf0017isp56m3.apps.googleusercontent.com',
        'client_secret' => '88ZjlTskUHeUSb7GBuzUJQJ0',
        'redirect' => 'http://127.0.0.1:8000/callback/google',
    ],

    'facebook' => [
        'client_id' => '863157200683992',
        'client_secret' => '46812c1a8b9f61c9296acef6ce37a7cc',
        'redirect' => 'http://localhost:8000/callback/facebook',
    ],
    'instagram' => [
        'client_id' => 'edf70c788d3040da996eebb0ff774f4c',
        'client_secret' => '1c94b382f97c4046a4330cecaad720a8',
        'redirect' => 'http://localhost:8000/callback/instagram',
    ],
    'linkedin' => [
        'client_id' => '81n570jzs5ndmo',
        'client_secret' => 'hCPpo1tE8uVjIdGk',
        'redirect' => 'http://localhost:8000/callback/linkedin',
    ],
    'stripe' => [
        'secret'  => 'sk_test_SC0vlNombHle8UkteUhGkEOh004jQUyGFo',
        'version' => 'v2.2.10',
    ],

];
