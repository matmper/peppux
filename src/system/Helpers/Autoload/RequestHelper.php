<?php

use System\Libraries\Request;

/**
 * Instance Request library
 *
 * @return Request
 */
if (!function_exists('request')) {
    function request(): Request
    {
        return new Request();
    }
}
