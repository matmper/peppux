<?php

namespace System\Libraries;

use PDO;

class Database extends PDO
{
    public function __construct()
    {
        $this->establishConnection();
    }

    /**
     * @inheritDoc
     */
    public function beginTransaction(): bool
    {
        return parent::beginTransaction();
    }

    /**
     * @inheritDoc
     */
    public function commit(): bool
    {
        return parent::commit();
    }

    /**
     * @inheritDoc
     */
    public function rollBack(): bool
    {
        return parent::rollBack();
    }

    /**
     * Execute PDO query
     *
     * @param string $query
     * @param array $bindParams
     * @return bool
     */
    public function execute(string $query, array $bindParams = []): bool
    {
        $stmt = $this->prepare($query);

        $execute = $stmt->execute($bindParams);

        $stmt->closeCursor();

        return $execute;
    }

    /**
     * Execute query and fetch object
     *
     * @param string $query
     * @param array $bindParams
     * @return object|null
     */
    public function row(string $query, array $bindParams = []): ?object
    {
        $stmt = $this->prepare($query);

        $stmt->execute($bindParams);

        $result = $stmt->fetchObject();

        $stmt->closeCursor();

        return !empty($result) ? $result : null;
    }

    /**
     * Execute query and fetch all
     *
     * @param string $query
     * @param array $bindParams
     * @return array<int,object>
     */
    public function all(string $query, array $bindParams = []): array
    {
        $stmt = $this->prepare($query);

        $stmt->execute($bindParams);

        $result = $stmt->fetchAll(PDO::FETCH_OBJ);

        $stmt->closeCursor();

        return $result;
    }

    /**
     * Create and open a new database with default data
     *
     * @return void
     */
    private function establishConnection(): void
    {
        $connectionName = config('database.default');
        $config = config("database.connections.{$connectionName}");

        try {
            parent::__construct(
                "{$config['driver']}:host={$config['host']}:{$config['port']};dbname={$config['name']}",
                $config['user'],
                $config['pass'],
                [
                    PDO::ATTR_PERSISTENT => true,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    ...$config['options']
                ],
            );
        } catch (\PDOException $e) {
            throw $e;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
