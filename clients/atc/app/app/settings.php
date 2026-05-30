<?php



    /** @noinspection HttpUrlsUsage */

$forwardedProto = $_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '';
$forwardedSsl = $_SERVER['HTTP_X_FORWARDED_SSL'] ?? '';
$https = $_SERVER['HTTPS'] ?? '';
$scheme = (!empty($https) && strtolower($https) !== 'off')
    || strtolower($forwardedProto) === 'https'
    || strtolower($forwardedSsl) === 'on'
    ? 'https'
    : 'http';
$host = $_SERVER['HTTP_X_FORWARDED_HOST'] ?? ($_SERVER['HTTP_HOST'] ?? 'localhost');

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

                'host' => 'atc-mysql',

                'user' => 'gepros1com_atc',

                'password' => 'gepros15082008',

                'dbname' => 'gepros1com_atc',

            ],

            'data'                              => [

                'path'        => __DIR__,

                'url'         => $scheme . '://' . $host . '/',

                'title'       => 'Gepros ' . date("Y"),

                'description' => 'Sistema Gepros'

            ]

        ],

    ];



