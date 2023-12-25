<?php

namespace System\Contracts;

interface MigrationInterface
{
    /**
     * Run up migration
     *
     * @return void
     */
    public function up(): void;

    /**
     * Run down migration
     *
     * @return void
     */
    public function down(): void;
}
