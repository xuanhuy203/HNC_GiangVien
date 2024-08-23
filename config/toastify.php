<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Toastify CDN links
    |--------------------------------------------------------------------------
    |
    | Here you may specify the CDN links for the toastify library.
    |
    */

    'cdn' => [
        'js' => 'https://unpkg.com/toastify-js@1.12.0/src/toastify.js',
        'css' => 'https://unpkg.com/toastify-js@1.12.0/src/toastify.css',
    ],

    /*
    |--------------------------------------------------------------------------
    | Toastify Toastifiers Options
    |--------------------------------------------------------------------------
    |
    | Here you may specify the toastifiers options for the toastify library.
    | Each toastifier will be available as a method in the Toastify facade.
    |
    */

    'toastifiers' => [
        'duration' => 5000,
        'toast' => [
            'style' => [
                'font-size' => '14px',
                'display' => 'flex',
                'align-items' => 'center',
                'background-color'=> '#fff',
                'border-radius' => '2px',
                'padding' => '20px 0',
                'border-left' => '4px solid',
                'box-shadow' => '0 5px 8px rgba(0, 0, 0, 0.08)',
                'transition' => 'all linear 0.3s'
            ],
        ],
        'error' => [
            'style' => [
                'background-color'=> '#fff',
                'border-color'=> '#ff623d',
                'color'=>'#ff623d'
            ],
        ],
        'success' => [
            'style' => [
                'background-color'=> '#fff',
                'border-color'=> '#47d864',
                'color'=>'#47d864'
            ],
        ],
        'info' => [
            'style' => [
                'background-color'=> '#fff',
                'border-color'=> '#2f86eb',
                'color'=>'#2f86eb'
            ],
        ],
        'warning' => [
            'style' => [
                'background-color'=> '#fff',
                'border-color'=> '#ffc021',
                'color'=>'#ffc021'
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Toastify Default Options
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default options for the toastify library.
    |
    */

    'defaults' => [
        'gravity' => 'toastify-top',
        'position' => 'right',
    ],
];