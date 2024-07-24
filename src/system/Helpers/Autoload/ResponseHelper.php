<?php

use System\Libraries\Response;

/**
 * Instance Response library
 *
 * @return Response
 */
if (!function_exists('response')) {
    function response(): Response
    {
        return new Response();
    }
}
