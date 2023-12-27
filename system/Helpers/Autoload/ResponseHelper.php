<?php

use System\Libraries\Response;

if (!function_exists('response')) {
    function response(): Response
    {
        return new Response();
    }
}
