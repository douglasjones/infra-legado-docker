<?php

    /** @noinspection HttpUrlsUsage */
 return [
        'settings' => [
            'determineRouteBeforeAppMiddleware' => true,
            'addContentLengthHeader'            => false,
            'displayErrorDetails'               => true,
            'view'                              => [
                'template_path' => __DIR__ . '/templates',
                'twig'          => [
                    'cache' => false,
                    'debug' => true,
                ],
            ],
            'oracle_native'                     => [
                'connection' => []
            ],
            // Database connection settings
            'db' => [
                'host' => getenv('DB_HOST') ?: 'vistoriza-at-mysql',
                'user' => getenv('DB_USER') ?: 'gepros1com_vistoriza',
                'password' => getenv('DB_PASSWORD') ?: 'gepros15082008',
                'dbname' => getenv('DB_NAME') ?: 'gepros1com_vistoriza',
            ],
            'data'                              => [
                'path'        => __DIR__,
                'url'         => (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/',
                'title'       => 'Gepros ' . date("Y"),
                'description' => 'Sistema Gepros'
            ]
        ],
    ];


