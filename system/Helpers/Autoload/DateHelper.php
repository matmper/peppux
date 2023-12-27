<?php

/**
 * Instance DateTime class with now
 *
 * @param string timezone
 * @return mixed
 */
if (!function_exists('now')) {
    function now(string $timezone = null): \DateTime
    {
        return new \DateTime('now', $timezone);
    }
}
