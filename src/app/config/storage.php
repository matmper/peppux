<?php

return [

    /**
     * Default storage name
     * @return string
     */
    'default' => env('STORAGE_TYPE', 'local'),

    /**
     * Storage disks options
     * @return array
     */
    'options' => [

        'local' => [
            'path' => storage_path('public'),
        ],

    ],

];
