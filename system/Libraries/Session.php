<?php

namespace System\Libraries;

class Session
{
    /**
     * Session expires (lifetime) in minutes
     *
     * @var int
     */
    private $sessionExpires;

    public function __construct()
    {
        $this->sessionExpires = config('session.lifetime', 120);
    }

    public function __invoke()
    {
        session_cache_expire($this->sessionExpires);
        session_start(['cookie_lifetime' => $this->sessionExpires]);

        if (!isset($_SESSION['__s'])) {
            $_SESSION['__s'] = []; // persistent session
            $_SESSION['__f'] = []; // flashdata session (once)
            $_SESSION['__t'] = []; // tempdata session (time)
        }
    }

    /**
     * Get value from session key
     *
     * @param string|integer $param
     * @return mixed
     */
    public static function get(string|int $param): mixed
    {
        return $_SESSION['__s'][$param] ?? null;
    }

    /**
     * Set value into session key and return this value
     *
     * @param string|integer $param
     * @param mixed $value
     * @return mixed
     */
    public static function set(string|int $param, mixed $value): mixed
    {
        $_SESSION['__s'][$param] = $value;

        return self::get($param);
    }

    /**
     * Remove value from session key
     *
     * @param string|integer $param
     * @return boolean
     */
    public static function unset(string|int $param): void
    {
        if (isset($_SESSION['__s'][$param])) {
            unset($_SESSION['__s'][$param]);
        }
    }

    /**
     * Set value into session flashdata key (visible once time)
     *
     * @param string|integer $param
     * @param mixed $value
     * @return boolean
     */
    public static function setFlashdata(string|int $param, mixed $value): bool
    {
        $_SESSION['__f'][$param] = $value;

        return isset($_SESSION['__f'][$param]);
    }

    /**
     * Unset all values and keys from session flashdata
     *
     * @return void
     */
    public static function unsetFlashdata(): void
    {
        $_SESSION['__f'] = [];
    }

    /**
     * Destroy session (all)
     *
     * @return boolean
     */
    public static function destroy(): bool
    {
        return session_destroy();
    }
}
