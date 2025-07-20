<?php
/**
 * PayPal Setting & API Credentials
 * Created by Raza Mehdi <srmk@outlook.com>.
 */

return [
    'mode'    => env('PAYPAL_MODE', 'sandbox'), // Can only be 'sandbox' or 'live'
    'sandbox' => [
        'client_id'         => env('PAYPAL_SANDBOX_CLIENT_ID', 'AW3yEtO-LxHxmE8lg22eVCUZW0GOrfYvZNJPOqMoXN3EWEMptA2e1hYZNrz_DNd7UFJQLty_Z2n5PoEk'),
        'client_secret'     => env('PAYPAL_SANDBOX_CLIENT_SECRET', 'EHTOg4t-xiKzyXKbR8Vrr2Ms4R6S3x21jN7NEfCjL5GRWCvXbTb2Cn1z20xYLx5HgxwDVaf9L94lZdUC'),
        'app_id'            => 'APP-80W284485P519543T',  // Sandbox App ID
    ],
    'live' => [
        'client_id'         => env('PAYPAL_LIVE_CLIENT_ID', 'your-live-client-id'),
        'client_secret'     => env('PAYPAL_LIVE_CLIENT_SECRET', 'your-live-client-secret'),
        'app_id'            => env('PAYPAL_LIVE_APP_ID', 'your-live-app-id'),
    ],

    'payment_action' => env('PAYPAL_PAYMENT_ACTION', 'Sale'),  // Can only be 'Sale', 'Authorization' or 'Order'
    'currency'       => env('PAYPAL_CURRENCY', 'USD'),
    'notify_url'     => env('PAYPAL_NOTIFY_URL', 'http://your-site.com/paypal-notify'),
    'locale'         => env('PAYPAL_LOCALE', 'en_US'),  // PayPal express checkout language
    'validate_ssl'   => env('PAYPAL_VALIDATE_SSL', true),  // Validate SSL when creating API client
];
