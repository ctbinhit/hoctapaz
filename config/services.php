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
    ],
    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],
    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],
    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    // v2.10
    'facebook' => [
        'client_id' => '552682171742827',
        'client_secret' => '1f2cf041d156efdc9d7743643167d52b',
        'redirect' => env('APP_URL').'/login/facebook/callback',
    ],
    'google' => [
        'client_id' => '820843320850-g91ed10kpvmood4b7bb9867ga1fnbddr.apps.googleusercontent.com',
        'client_secret' => 'kakAWcTc0gVEacV6rAPorvWu',
        'redirect' => env('APP_URL') . '/login/google/callback',
    ],
        // GOOGLE 
        // Client Id: 371430001644-s38q48ldq8o57t63441pk2udkvb2f3ob.apps.googleusercontent.com
        // Client secret: y8NfoLlpjycka3aPI_yLalJa
];
