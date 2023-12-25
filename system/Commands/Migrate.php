<?php

namespace System\Commands;

use System\Contracts\CommandInterface;

class Migrate implements CommandInterface
{
    /**
     * @inheritDoc
     */
    public function run(array $args): void
    {
        $run = new \System\Libraries\Migration;
        $run->up();
    }

    /**
     * Migrate rollback
     *
     * @param array $args
     * @return void
     */
    public function rollback(array $args): void
    {
        $steps = !empty($args['steps']) ? $args['steps'] : 1;

        $run = new \System\Libraries\Migration;
        $run->down($steps);
    }
}
