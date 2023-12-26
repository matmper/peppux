<?php

namespace System\Bootstrap;

class Errors
{
    public function __construct()
    {
        $this->__invoke();
    }
    
    public function __invoke(): void
    {
        ini_set('display_errors', 0);
        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);

        if (config('app.debug') == true) {
            error_reporting(-1);
            ini_set('display_errors', 1);
        }
    }
}
