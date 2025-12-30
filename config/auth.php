<?php

return [

    'defaults' => [
        'guard' => 'userlist',
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    /*  
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],

        'userlist' => [
            'driver' => 'session',
            'provider' => 'userlists',
        ],
    ],  // ← THIS bracket was wrongly placed in your file

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', App\Models\User::class),
        ],

        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],

        'userlists' => [
            'driver' => 'eloquent',
            'model' => App\Models\Userlist::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Reset Passwords
    |--------------------------------------------------------------------------
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
