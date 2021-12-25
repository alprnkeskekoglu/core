<?php

return [
    'guards' => [
        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],
    ],


    'providers' => [
        'admins' => [
            'driver' => 'eloquent',
            'model' => Dawnstar\Core\Models\Admin::class,
        ],
    ],


    'passwords' => [
        'admin' => [
            'provider' => 'admins',
            'table' => 'admin_password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],
];
