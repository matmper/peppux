<?php

namespace Peppux\Exceptions\Http;

use Exception;

class MethodNotAllowedException extends Exception
{
    public function __construct(\Throwable|null $previous = null)
    {
        parent::__construct('HTTP - Method not allowed', 405, $previous);
    }
}
