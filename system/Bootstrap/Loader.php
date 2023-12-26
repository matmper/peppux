<?php

namespace System\Bootstrap;

/*
|--------------------------------------------------------------------------
| Load and includes files
|--------------------------------------------------------------------------
*/
class Loader
{
    /**
     * Load a controller and method
     *
     * @param string $controller
     * @param string $method
     * @param array $params
     * @return void
     */
    public static function controller(string $controller, string $method, array $params): void
    {
        try {
            $matches = [];

            array_shift($params);

            foreach ($params as $key => $param) {
                $param = explode('?', $param)[0];

                if (!is_numeric($key)) {
                    $matches[$key] = $param;

                    // insert paths params to request get
                    if (empty($_GET[$key])) {
                        $_GET[$key] = $param;
                    }
                }
            }

            $controller = new $controller();

            call_user_func_array([$controller, $method], $matches);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Insert envs from file to putenv()
     *
     * @param string $__filename
     * @return void
     */
    public static function env_file(string $__filename = '.env'): void
    {
        if (!file_exists(FCPATH . $__filename)) {
            throw new \Exception("env file `$__filename` not found", 1);
        }

        foreach (parse_ini_file(FCPATH . $__filename) as $__envName => $__envValue) {
            $value = !empty($__envValue) ? $__envValue : '';
            putenv("{$__envName}={$value}");
        }
    }

    /**
     * Load all config files from app/config/*.php
     *
     * @return void
     */
    public static function config(): void
    {
        foreach (glob(APPPATH . 'config/*.php') as $file) {
            $__filename = pathinfo($file)['filename'];
            $__arr = require_once($file);

            if (!is_array($__arr)) {
                throw new \Exception("config file `$file` is not a valid array", 1);
            }

            foreach ($__arr as $__configKey => $__configValue) {
                $_SERVER['_CONFIG'][$__filename][$__configKey] = $__configValue;
            }
        }
    }
}
