<?php

namespace System\Libraries;

class Session
{
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
     * @return void
     */
    public static function set(string|int $param, mixed $value): void
    {
        $_SESSION['__s'][$param] = $value;
    }

    /**
     * Remove value from session key
     *
     * @param string|integer $param
     * @return void
     */
    public static function unset(string|int $param): void
    {
        if (isset($_SESSION['__s'][$param])) {
            unset($_SESSION['__s'][$param]);
        }
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
