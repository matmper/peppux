<?php

return [

    /**
     * Routes file to load: /app/routes/*.php
     * @return array
     */
    'load' => [
        'app'
    ],

    /**
     * Return allowed method to generate routes
     * @return array
     */
    'methods' => [
        'GET',
        'POST',
        'PUT',
        'PATCH',
        'DELETE',
        'OPTIONS',
    ],

];
