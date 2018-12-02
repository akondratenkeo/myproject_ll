<?php

return [

    'app' => [

        'name' => env('APP_NAME', 'Project'),

        'env' => env('APP_ENV', 'production'),

        'debug' => env('APP_DEBUG', false),

        'url' => env('APP_URL', 'http://localhost'),

        'timezone' => 'Europe/Kiev',

        'locale' => 'en',

        'key' => env('APP_KEY'),

        'cipher' => 'AES-256-CBC',
    ],

    'log' => [
        'name' => env('LOG_NAME', 'project_logger'),

        'filename' => env('LOG_FILENAME', 'project.log'),
    ],

    'database' => [
        'driver' => 'mysql',

        'host' => env('DB_HOST', '127.0.0.1'),

        'port' => env('DB_PORT', '3306'),

        'database' => env('DB_DATABASE', 'root'),

        'username' => env('DB_USERNAME', 'root'),

        'password' => env('DB_PASSWORD', ''),

        'charset' => 'utf8mb4',

        'collation' => 'utf8mb4_unicode_ci',

        'prefix' => '',

        'strict' => true,

        'engine' => null,
    ],

    'cache' => [
        'driver' => env('CACHE_DRIVER', 'file'),
    ],

    'session' => [
        'driver' => env('SESSION_DRIVER', 'file'),

        'lifetime' => env('SESSION_LIFETIME', 120),
    ],

    'redis' => [

        'scheme' => env('REDIS_SCHEME', 'tcp'),

        'host' => env('REDIS_HOST', '127.0.0.1'),

        'port' => env('REDIS_PORT', 6379),

        'password' => env('REDIS_PASSWORD', null),
    ],

];
