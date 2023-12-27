# Database Migrate

Control your database and its versions through database migration.
Use the resource to perform upgrades and downgrades of database updates.

## Create new migration file

A new migration file must be created in the project, to do this run the command below:

```bash
$ php peppux migrate:create name="CreateUsersTable"
```

A file will be created in folder `database/Migrations` with the name `20240101_120000_create_users_table.php`.

Edit this file and add your query inside the `$this->migrate(...)` methods.
Each method must contain only a single query, a migration file can contain multiple method calls and they will be executed in sequences within a transaction.

```php
<?php

namespace Database\Migrations;

use System\Libraries\Migration;

return new class extends Migration
{
    /**
     * Up migrations
     */
    public function run(): void
    {
        $this->migrate("CREATE TABLE `users` (
            `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            PRIMARY KEY `pk_id` (`id`)
        )");
    }

    /**
     * Rollback migrations
     */
    public function rollback(): void
    {
        $this->migrate("DROP TABLE IF EXISTS `users`");
    }
};
```

## Running migrations

With the necessary migration files created, run the command below to run all pending migrations.

```bash
$ php peppux migrate
```

## Rollback migrations

To perform a single version downgrade, use the command below.
```bash
$ php peppux migrate:rollback
```

If you downgrade one or more steps, enter the parameter `steps`.
```bash
$ php peppux migrate:rollback steps=10
```
