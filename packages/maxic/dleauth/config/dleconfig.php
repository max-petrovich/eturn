<?php

return [
    'db_connection_name' => 'mysql_dle',
    'db_connection' => [
        'driver' => 'mysql',
        'host' => env('DB_DLE_HOST', 'localhost'),
        'port' => env('DB_DLE_PORT', '3306'),
        'database' => env('DB_DLE_DATABASE', 'forge'),
        'username' => env('DB_DLE_USERNAME', 'forge'),
        'password' => env('DB_DLE_PASSWORD', ''),
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => 'dle_',
        'strict' => false,
        'engine' => null,
    ],

    'roles_user' => [
        'admin' => 1,
        'master' => [3]
    ],
];