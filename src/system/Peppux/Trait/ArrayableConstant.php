<?php

namespace System\Peppux\Trait;

use ReflectionClass;

trait ArrayableConstant
{
    /**
     * Return all const into an array
     *
     * @return array
     */
    public static function toArray(): array
    {
        return (new ReflectionClass(static::class))->getConstants();
    }

    /**
     * Get array keys and return into an array
     *
     * @return array
     */
    public static function toArrayKeys(): array
    {
        return array_keys(self::toArray());
    }

    /**
     * Get and returns const value
     *
     * @param string $value
     * @return mixed
     */
    public static function getConstant(string $value): mixed
    {
        return (new ReflectionClass(static::class))->getConstant(strtoupper($value));
    }
}
