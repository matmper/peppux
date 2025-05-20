<?php

namespace Peppux\Exceptions\Http;

use Exception;

class PageNotFoundException extends Exception
{
    public function __construct(\Throwable|null $previous = null)
    {
        parent::__construct('HTTP - Page not found', 404, $previous);
    }
}
