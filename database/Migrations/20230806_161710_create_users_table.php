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
        $this->migrate("CREATE TABLE `users` (
            `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `email` VARCHAR(255) NOT NULL,
            `name` VARCHAR(255) NOT NULL,
            `created_at` DATETIME NOT NULL,
            `updated_at` DATETIME NOT NULL,
            `deleted_at` DATETIME,
            PRIMARY KEY `pk_id` (`id`),
            UNIQUE KEY `uq_email` (`email`)
        )");
    }

    /**
     * Rollback migrations
     *
     * @return void
     */
    public function rollback(): void
    {
        $this->migrate("DROP TABLE IF EXISTS `users`");
    }
};
