<?php

namespace Peppux\Trait;

trait ArrayableEnum
{
    /**
     * Return all const into an array
     *
     * @return array
     */
    public static function toArray(): array
    {
        $array = [];

        foreach (self::cases() as $case) {
            $array[] = $case->value;
        }

        return $array;
    }

    /**
     * Get array keys and return into an array
     *
     * @return array
     */
    public static function toArrayKeys(): array
    {
        $array = [];

        foreach (self::cases() as $case) {
            $array[] = $case->name;
        }

        return $array;
    }
}
