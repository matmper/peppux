<?php

if (!function_exists('url')) {
    function url($uri = '/')
    {
        $url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
        $url .= "://".$_SERVER['HTTP_HOST'];
        $url .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
        $url = rtrim($url, '/');

        $uri = "/{$uri}";
        $uri = str_replace('//', '/', $uri);

        return "{$url}{$uri}";
    }
}

if (!function_exists('asset')) {
    function asset(string $filename): string
    {
        $file = PUBLICPATH . "assets/{$filename}";

        if (file_exists($file)) {
            return url("/assets/{$filename}");
        }

        throw new \Exception("This assets doesn't exists: {$filename}");
    }
}
