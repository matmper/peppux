<?php

namespace System\Bootstrap\Support;

interface Arrayable
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
