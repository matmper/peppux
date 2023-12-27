<?php

use System\Libraries\Request;

if (!function_exists('request')) {
    function request(): Request
    {
        return new Request();
    }
}
