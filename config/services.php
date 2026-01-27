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

    'fel' => [
        'url' => env('FEL_API_URL', 'https://felgttestaws.digifact.com.gt/gt.com.fel.api.v3/api/sharedInfo'),
        'nit' => env('FEL_NIT', '44653948'),
        'data1' => env('FEL_DATA1', 'SHARED_GETINFOCUI'),
        'username' => env('FEL_USERNAME', 'CIVERNETTEST'),
        'authorization' => env('FEL_AUTHORIZATION', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1bmlxdWVfbmFtZSI6IkdULjAwMDA0NDY1Mzk0OC5DSVZFUk5FVFRFU1QiLCJuYmYiOjE3Njg4MzMzMDAsImV4cCI6MTc5OTkzNzMwMCwiaWF0IjoxNzY4ODMzMzAwLCJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjQ5MjIwIiwiYXVkIjoiaHR0cDovL2xvY2FsaG9zdDo0OTIyMCJ9.hUJC4xOvlebXO8OnKZY4jZPemPW3yDww010yapM2hoY'),
    ],

];
