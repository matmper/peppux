<?php

return [

    /**
     * Connection database name
     * @return string
     */
    'default' => env('DB_CONN', 'mysql'),

    /**
     * Database connections
     * @return array
     */
    'connections' => [

        'mysql' => [
            'host' => env('DB_HOST', 'localhost'),
            'name' => env('DB_NAME', 'peppux'),
            'port' => env('DB_PORT', 3306),
            'user' => env('DB_USER', 'root'),
            'pass' => env('DB_PASS', ''),
            'socket' => env('DB_SOCKET', null),
        ],

    ],

];
