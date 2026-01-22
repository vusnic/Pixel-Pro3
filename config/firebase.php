<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Firebase Credentials
    |--------------------------------------------------------------------------
    |
    | Please set the following credentials to connect to Firebase.
    |
    */

    'credentials' => [
        'file' => env('FIREBASE_CREDENTIALS_JSON', storage_path('firebase-credentials.json')),
    ],

    /*
    |--------------------------------------------------------------------------
    | Firebase Database URL
    |--------------------------------------------------------------------------
    |
    | The URL to your Firebase Realtime Database.
    |
    */

    'database_url' => env('FIREBASE_DATABASE_URL'),

    /*
    |--------------------------------------------------------------------------
    | Firebase Storage
    |--------------------------------------------------------------------------
    |
    | Configure the default bucket for Firebase Storage.
    |
    */

    'storage' => [
        'default_bucket' => env('FIREBASE_STORAGE_BUCKET'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Firebase Dynamic Links
    |--------------------------------------------------------------------------
    |
    | Configure Firebase Dynamic Links.
    |
    */

    'dynamic_links' => [
        'default_domain' => env('FIREBASE_DYNAMIC_LINKS_DEFAULT_DOMAIN'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Firebase Cloud Messaging
    |--------------------------------------------------------------------------
    |
    | Configure Firebase Cloud Messaging.
    |
    */

    'messaging' => [
        'default_sender_id' => env('FIREBASE_MESSAGING_DEFAULT_SENDER_ID', ''),
    ],
]; 