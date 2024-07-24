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
    private Database $database;

    public function __construct()
    {
        $this->database = new Database();
        $this->createIfNotExistsMigrationTable();
    }

    /**
     * @inheritDoc
     */
    public function up(): void
    {
        $this->database->beginTransaction();

        try {
            $files = $this->getMigrationFiles();
            $migrations =  $this->getMigrations();
            $up = array_diff($files, $migrations);

            if (empty($up)) {
                \System\Helpers\OutputHelper::success("Migrate Up: Already up to date");
            } else {
                foreach ($up as $file) {
                    $instance = require_once database_path("Migrations/$file");
                    $instance->run();

                    $this->database->execute(
                        "INSERT INTO `{$this->table}` (`name`, `created_at`) VALUES (?, ?)",
                        [$file, now()->format('Y-m-d H:i:s')]
                    );

                    \System\Helpers\OutputHelper::success("Migrate Up: {$file}");
                }
            }

            $this->database->commit();
        } catch (\Throwable $th) {
            $this->database->rollback();
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
        $this->database->beginTransaction();

        try {
            $down = $this->getMigrations($steps);

            if (empty($down)) {
                \System\Helpers\OutputHelper::success("Migrate Down: nothing to rollback");
            } else {
                foreach ($down as $file) {
                    $instance = require_once database_path("Migrations/$file");
                    $instance->rollback();

                    $this->database->execute("DELETE FROM `{$this->table}` WHERE `name` = ?", [$file]);

                    \System\Helpers\OutputHelper::success("Migrate Down: {$file}");
                }
            }

            $this->database->commit();
        } catch (\Throwable $th) {
            $this->database->rollback();
            throw $th;
        }
    }

    /**
     * Execute a new query into migrate
     *
     * @param string $query
     * @param array $bind<mixed,mixed>
     * @return void
     */
    protected function migrate(string $query, array $bind = []): void
    {
        $this->database->execute($query, $bind);
    }

    /**
     * Return executed migrations
     *
     * @param integer $steps
     * @return array<int,string>
     */
    private function getMigrations(int $steps = 0): array
    {
        $query = $steps > 0
            ? "SELECT `name` FROM `{$this->table}` ORDER BY `created_at` DESC, `id` DESC LIMIT {$steps}"
            : "SELECT `name` FROM `{$this->table}` ORDER BY `created_at` ASC, `id` ASC";

        $migrations =  $this->database->all($query);

        $response = [];

        foreach ($migrations as $migration) {
            $response[] = $migration->name;
        }

        return $response;
    }

    /**
     * Return files into migration path
     *
     * @return array<int,string>
     */
    private function getMigrationFiles(): array
    {
        return array_slice(scandir(database_path('Migrations')), 2);
    }

    /**
     * Create if not exists migrations table
     *
     * @return void
     */
    private function createIfNotExistsMigrationTable(): void
    {
        $this->database->beginTransaction();

        try {
            $this->database->execute("CREATE TABLE IF NOT EXISTS `{$this->table}` (
                `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                `name` VARCHAR(255) NOT NULL,
                `created_at` DATETIME NOT NULL,
                PRIMARY KEY `pk_id` (`id`),
                UNIQUE KEY `uq_name` (`name`)
            )");

            $this->database->commit();
        } catch (\Throwable $th) {
            $this->database->rollBack();
            throw $th;
        }
    }
}
