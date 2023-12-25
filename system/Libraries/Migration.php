<?php

namespace System\Libraries;

use System\Contracts\MigrationInterface;

class Migration implements MigrationInterface
{
    /**
     * @var string
     */
    private string $table = 'migrations';

    /**
     * Database connection
     *
     * @var Database
     */
    private Database $connection;

    public function __construct()
    {
        $this->connection = new Database;
    }

    /**
     * @inheritDoc
     */
    public function up(): void
    {
        $this->connection->beginTransction();

        try {
            $this->firstOrCreateMigrationTable();

            $files = $this->getMigrationFiles();
            $migrations =  $this->getMigrations();
            $up = array_diff($files, $migrations);

            if (empty($up)) {
                $this->output("Migrate Up: Already up to date");
            } else {
                foreach ($up as $file) {
                    $instance = require_once database_path("Migrations/$file");
                    $instance->run();

                    $this->connection->statement(
                        "INSERT INTO `{$this->table}` (`name`, `created_at`) VALUES (?, ?)",
                        [$file, now()->format('Y-m-d H:i:s')]
                    );

                    $this->output("Migrate Up: {$file}");
                }
            }

            $this->connection->commit();
        } catch (\Throwable $th) {
            $this->connection->rollback();
            throw $th;
        }
    }

    /**
     * Run down migration
     *
     * @return void
     */
    public function down(int $steps = 1): void
    {
        $this->connection->beginTransction();

        try {
            $this->firstOrCreateMigrationTable();

            $down = $this->getMigrations($steps);

            if (empty($down)) {
                $this->output("Migrate Down: nothing to rollback");
            } else {
                foreach ($down as $file) {
                    $instance = require_once database_path("Migrations/$file");
                    $instance->rollback();

                    $this->connection->statement("DELETE FROM `{$this->table}` WHERE `name` = ?", [$file]);

                    $this->output("Migrate Down: {$file}");
                }
            }

            $this->connection->commit();
        } catch (\Throwable $th) {
            $this->connection->rollback();
            throw $th;
        }
    }

    /**
     * Execute a new query into migrate
     *
     * @param string $query
     * @param array $bind
     * @return void
     */
    protected function migrate(string $query, array $bind = []): void
    {
        $this->connection->statement($query, $bind);
    }

    /**
     * Return executed migrations
     *
     * @return array
     */
    private function getMigrations(int $steps = null): array
    {
        $query = $steps > 0
            ? "SELECT `name` FROM `{$this->table}` ORDER BY `created_at` DESC, `id` DESC LIMIT {$steps}"
            : "SELECT `name` FROM `{$this->table}` ORDER BY `created_at` ASC, `id` ASC";

        $migrations =  $this->connection->all($query);

        $response = [];

        foreach ($migrations as $migration) {
            $response[] = $migration->name;
        }

        return $response;
    }

    /**
     * Return files into migration path
     *
     * @return array
     */
    private function getMigrationFiles(): array
    {
        return array_slice(scandir(database_path('Migrations')), 2);
    }

    /**
     * Create if not exists migrations table and return executed migration names
     *
     * @return void
     */
    private function firstOrCreateMigrationTable(): void
    {
        $this->connection->statement("CREATE TABLE IF NOT EXISTS `{$this->table}` (
            `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(255) NOT NULL,
            `created_at` DATETIME NOT NULL,
            PRIMARY KEY `pk_id` (`id`),
            UNIQUE KEY `uq_name` (`name`)
        )");
    }

    /**
     * Output console message
     *
     * @param string $message
     * @return void
     */
    private function output(string $message): void
    {
        print "\033[0;32m" . now()->format('H:i:s') . "\033[0m - {$message}\n";
    }
}
