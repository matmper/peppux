<?php

/**
 * Load env config value
 *
 * @param string $param
 * @param string|null $default
 * @return mixed
 */
if (!function_exists('env')) {
    function env(string $param, string $default = null): mixed
    {
        return !empty(getenv($param)) ? getenv($param) : $default;
    }
}

/**
 * Load config values into $_SERVER
 *
 * @param string $param     app.name
 * @param mixed $default
 * @return mixed
 */
if (!function_exists('config')) {
    function config(string $param, mixed $default = null): mixed
    {
        $config = $_SERVER['_CONFIG'];

        foreach (explode('.', $param) as $p) {
            if (!isset($config[$p])) {
                return $default;
            }

            $config = $config[$p];
        }

        return $config;
    }
}
