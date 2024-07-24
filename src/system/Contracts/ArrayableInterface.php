<?php

namespace System\Contracts;

interface ArrayableInterface
{
    /**
     * @return array
     */
    public static function toArray(): array;

    /**
     * @return array
     */
    public static function toArrayKeys(): array;
}
