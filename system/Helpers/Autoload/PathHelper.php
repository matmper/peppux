<?php

/**
 * ./app path dir
 *
 * @param string $file
 * @return mixed
 */
if (!function_exists('app_path')) {
    function app_path(string $file): mixed
    {
        return APPPATH . $file;
    }
}

/**
 * ./database path dir
 *
 * @param string $file
 * @return mixed
 */
if (!function_exists('database_path')) {
    function database_path(string $file): mixed
    {
        return DATABASEPATH . $file;
    }
}

/**
 * ./public path dir
 *
 * @param string $file
 * @return mixed
 */
if (!function_exists('public_path')) {
    function public_path(string $file): mixed
    {
        return PUBLICPATH . $file;
    }
}

/**
 * ./storage path dir
 *
 * @param string $file
 * @return mixed
 */
if (!function_exists('storage_path')) {
    function storage_path(string $file): mixed
    {
        return STORAGEPATH . $file;
    }
}
