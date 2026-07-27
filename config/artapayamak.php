<?php

return [
    /*
    |--------------------------------------------------------------------------
    | تنظیمات آرتا پیامک
    |--------------------------------------------------------------------------
    |
    | Here you can specify your IPPanel API key and optionally override the base URL.
    |
    */

    'api_key' => env('ARTAPAYAMAK_API_KEY', ''),

    'base_url' => env('ARTAPAYAMAK_BASE_URL', 'https://edge.ippanel.com/v1/api'),
];
