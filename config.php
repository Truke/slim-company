<?php

$config = [
    'siteURI' => 'http://localhost',
    'users' => [
        'admin' => '123456',
    ],
    'settings' => [
        'db' => [
            'host' => 'localhost',
            'user' => 'root',
            'pass' => 'root',
            'name' => 'test'
        ],
        'displayErrorDetails' => true,
        'determineRouteBeforeAppMiddleware' => true,
        'routerCacheFile' => ROOT . '/cache/router.cache.php',

        'logger' => [
            'name' => 'app',
            'path' => ROOT . '/logs/app.log',
            'level' => \Monolog\Logger::INFO // set to ERROR in production
        ],

        'twig' => [
            'settings' => [
                'debug' => true,
                'cache' => ROOT . '/cache',
            ],
            'template' => ROOT . '/template'
        ],
    ]
];