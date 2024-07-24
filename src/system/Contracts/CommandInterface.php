<?php

namespace System\Contracts;

interface CommandInterface
{
    /**
     * Run command
     *
     * @return void
     */
    public function run(array $args): void;
}
