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

    /**
     * Create migration file
     *
     * @param array $args
     * @return void
     */
    public function create(array $args): void
    {
        try {
            if (empty($name = $args['name'])) {
                throw new \Exception("Migration name can`t be empty");
            }

            if (!is_dir($path = database_path('Migrations'))) {
                throw new \Exception("Migration folder not found: {$path}");
            }

            $date = now()->format('Ymd_His');

            $name = preg_replace('/[A-Z]/', " $0", $name);
            $name = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '_', $name)));
            $name = str_replace('__', '_', "{$date}_{$name}.php");

            $content = file_get_contents(SYSTEMPATH . '/Commands/Support/MigrateFile.php');

            file_put_contents("{$path}/{$name}", $content);

            \System\Helpers\Support\OutputHelper::success("Migration file created successfully: {$name}");
        } catch (\Throwable $th) {
            \System\Helpers\Support\OutputHelper::error($th->getMessage());
        }
    }
}
