<?php

/**
 * ./app path dir
 *
 * @param string $file
 * @return string
 */
if (!function_exists('app_path')) {
    function app_path(string $file): string
    {
        return APPPATH . $file;
    }
}

/**
 * ./database path dir
 *
 * @param string $file
 * @return string
 */
if (!function_exists('database_path')) {
    function database_path(string $file): string
    {
        return DATABASEPATH . $file;
    }
}

/**
 * ./public path dir
 *
 * @param string $file
 * @return string
 */
if (!function_exists('public_path')) {
    function public_path(string $file): string
    {
        return PUBLICPATH . $file;
    }
}

/**
 * ./storage path dir
 *
 * @param string $file
 * @return string
 */
if (!function_exists('storage_path')) {
    function storage_path(string $file): string
    {
        return STORAGEPATH . $file;
    }
}
