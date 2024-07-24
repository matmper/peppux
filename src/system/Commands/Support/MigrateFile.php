<?php

namespace Database\Migrations;

use System\Libraries\Migration;

return new class extends Migration
{
    /**
     * Up migrations
     *
     * @return void
     */
    public function run(): void
    {
        $this->migrate('');
    }

    /**
     * Rollback migrations
     *
     * @return void
     */
    public function rollback(): void
    {
        $this->migrate('');
    }
};
