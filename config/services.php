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
        'domain' => 'mg.aguias.pt',
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => '142f2862df0bb23f52b39ff5f4003c9bcecf9073',
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'facebook' => [
        'client_id' => '247993472370748',
        'client_secret' => 'd4bc5a5ded9ef07637011cc21bd6489e',
        'redirect' => 'http://localhost:8000/login/social/facebook/callback',
    ],

    'twitter' => [
        'client_id' => '0iwqnMl5UbMmvu7L9mA5Z7R68',
        'client_secret' => 'ETpekSvbeLm9lzn6P0vxVpg0KLHYj58rdDkQJmRQHKKoWrLJ6U',
        'redirect' => 'http://localhost:8000/login/social/twitter/callback',
    ],

    'google' => [
        'client_id' => '1034331109199-mrlmh4l424tu1cj31akm3729nabqbeau.apps.googleusercontent.com',
        'client_secret' => 'cv1GA-ur0oaDz1aSoPGCBr9A',
        'redirect' => 'http://localhost:8000/login/social/google/callback',
    ],

];
