<?php

namespace Database\Migrations;

use System\Libraries\Migration;

return new class extends Migration
{
    /**
     * Up migration
     *
     * @return void
     */
    public function run(): void
    {
        $this->migrate("CREATE TABLE `logs` (
            `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            `level` VARCHAR(255) NOT NULL,
            `message` TEXT NOT NULL,
            `description` json DEFAULT NULL,
            `created_at` DATETIME NOT NULL,
            PRIMARY KEY `pk_id` (`id`)
        )");
    }

    /**
     * Rollback migrations
     *
     * @return void
     */
    public function rollback(): void
    {
        $this->migrate("DROP TABLE IF EXISTS `logs`");
    }
};
