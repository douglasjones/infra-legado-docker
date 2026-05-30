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
                'host' => 'vs-solucoes-mysql',
                'user' => 'gepros1com_vs_solucoes',
                'password' => 'gepros15082008',
                'dbname' => 'gepros1com_vs_solucoes',
            ],
            'data'                              => [
                'path'        => __DIR__,
                'url'         => (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/',
                'title'       => 'Gepros ' . date("Y"),
                'description' => 'Sistema Gepros'
            ]
        ],
    ];


