<?php

return [
    /*
     * The property ID from Google Analytics.
     * For GA4 properties, this is in the format: "G-XXXXXXXXXX" 
     */
    'property_id' => env('ANALYTICS_PROPERTY_ID', 'G-6BPSV5KJDE'),

    /*
     * Path to the service account credentials JSON file.
     * You can download this from Google Cloud Console after creating a service account.
     */
    'service_account_credentials_json' => storage_path('app/analytics/service-account-credentials.json'),

    /*
     * The amount of minutes the Google API responses will be cached.
     * If you set this to zero, the responses won't be cached at all.
     */
    'cache_lifetime_in_minutes' => 60 * 24,

    /*
     * The directory where the underlying Google_Client will store its cache files.
     */
    'cache_location' => storage_path('app/analytics-cache'),
]; 