<?php

namespace System\Bootstrap\Support;

final class Session
{
    public function __construct()
    {
        $this->__invoke();
    }

    /**
     * Invoke application session
     *
     * @return void
     */
    public function __invoke()
    {
        $sessionExpires = config('session.lifetime', 120);

        session_cache_expire($sessionExpires);
        session_start(['cookie_lifetime' => $sessionExpires]);

        if (!isset($_SESSION['__s'])) {
            $_SESSION['__s'] = []; // persistent session
        }
    }
}
