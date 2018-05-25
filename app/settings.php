<?php

return [
    'settings' => [
        'determineRouteBeforeAppMiddleware' => false,
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        // Twig settings
        'twig' => [
            'name' => 'slim-twig',
            'path' => __DIR__ . '/../templates/',
            'cache' => __DIR__ . '/../cache/',
            'allowed_functions' => array('fn_print_r', 'fn_print_die', 'base_url', 'asset', 'method_field', 'is_string', 'is_array'),
        ],

        // Eloquent
        'eloquent' => [
            'db1' => [
                'driver' => 'mysql',
                'host' => 'localhost',
                'database' => 'authorization',
                'username' => 'root',
                'password' => 'root',
                'charset'   => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix'    => ''
            ],
            'db2' => [
                'driver' => 'mysql',
                'host' => 'localhost',
                'database' => 'blog',
                'username' => 'root',
                'password' => 'root',
                'charset'   => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix'    => ''
            ]
        ],

        // OAuth2
        'oauth2' => [
            'private_key_path' => __DIR__ . '/../keys/private.key',
            'private_key_pass' => 'test1234',
            'public_key_path' =>  __DIR__ . '/../keys/public.key',
            'encryption_key' => 'aNVLDla5uO8K5q4cZlBQtDgIq9lYnbM9PuH0DK2Nd3g=',
            'grants' => [
                'authorization_code' => [
                    'enabled' => true,
                    'authorization_code_expiry' => 'PT10M',
                    'access_token_expiry' => 'PT1H',
                    'refresh_token_expiry' => 'P1M'
                ],
                'password' => [
                    'enabled' => true,
                    'access_token_expiry' => 'PT1H',
                    'refresh_token_expiry' => 'P1M'
                ],
                'client_credentials' => [
                    'enabled' => true,
                    'access_token_expiry' => 'PT1H',
                ],
                'refresh_token' => [
                    'enabled' => true,
                    'access_token_expiry' => 'PT1H',
                    'refresh_token_expiry' => 'P1M'
                ],
                'implicit' => [
                    'enabled' => true,
                    'implicit_expiry' => 'PT1H',
                    'access_token_expiry' => 'PT1H'
                ]
            ]
        ],
        // PDO settings
        // 'db' => [
        //     'host' => 'localhost',
        //     'dbname' => 'blog',
        //     'user' => 'root',
        //     'pass' => 'root'
        // ],
    ],
];
