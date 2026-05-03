<?php

return [
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
    'pix' => [
        'key' => env('PIX_KEY'),
        'key_type' => env('PIX_KEY_TYPE', 'email'),
        'merchant_name' => env('PIX_MERCHANT_NAME', 'CadêMeuPix'),
        'merchant_city' => env('PIX_MERCHANT_CITY', 'SAO PAULO'),
    ],
];
