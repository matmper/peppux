<?php

return [

    /**
     * Application name
     * @return string
     */
    'name' => env('APP_NAME', 'Peppux Framwork'),

    /**
     * Application environment
     * @return string
     */
    'env' => env('APP_ENV', 'production'),

    /**
     * Application debug mode
     * @return boolean
     */
    'debug' => (bool) env('DEBUG', false),

    /**
     * Application version
     * @return float
     */
    'version' => (float) env('APP_VERSION', '0.1'),

    /**
     * Application timezone
     * @return string
     */
    'timezone' => env('TIMEZONE', 'UTC'),

];
