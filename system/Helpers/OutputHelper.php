<?php

namespace System\Helpers;

class OutputHelper
{
    /**
     * Output success message
     *
     * @param string $message
     * @param string $color
     * @return void
     */
    public static function success(string $message): void
    {
        self::output($message, '092');
    }

    /**
     * Output alert message
     *
     * @param string $message
     * @param string $color
     * @return void
     */
    public static function alert(string $message): void
    {
        self::output($message, '033');
    }

    /**
     * Output error message
     *
     * @param string $message
     * @param string $color
     * @return void
     */
    public static function error(string $message): void
    {
        self::output($message, '031');
    }

    /**
     * Output message (print)
     *
     * @param string $message
     * @param string $color
     * @return void
     */
    private static function output(string $message, string $color = '033'): void
    {
        print "\033[0;{$color}m" . now()->format('H:i:s') . "\033[0m - {$message}\n";
    }
}
