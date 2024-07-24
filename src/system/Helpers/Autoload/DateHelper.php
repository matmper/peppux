<?php

/**
 * Instance DateTime class with now
 *
 * @param \DateTimeZone|null timezone
 * @return \DateTime
 */
if (!function_exists('now')) {
    function now(\DateTimeZone $timezone = null): \DateTime
    {
        return new \DateTime('now', $timezone);
    }
}
