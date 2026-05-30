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
                'host' => 'restaurante-mysql',
                'user' => 'wwgepr_rest_tilapia',
                'password' => 'gepros15082008',
                'dbname' => 'wwgepr_rest_tilapia',
            ],
            'data'                              => [
                'path'        => __DIR__,
                'url'         => (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/',
                'title'       => 'Gepros ' . date("Y"),
                'description' => 'Sistema Gepros'
            ]
        ],
    ];



