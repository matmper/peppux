<?php

namespace System\Bootstrap\Support;

final class Errors
{
    public function __construct()
    {
        $this->__invoke();
    }

    /**
     * Invoke application error config
     *
     * @return void
     */
    public function __invoke(): void
    {
        ini_set('display_errors', 0);
        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);

        if (config('app.debug', false) === true) {
            error_reporting(-1);
            ini_set('display_errors', 1);
        }
    }
}
