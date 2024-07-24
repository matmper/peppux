<?php

namespace System\Libraries;

use PDO;

class Database extends PDO
{
    /**
     * @var integer
     */
    public int $transactionCounter = 0;

    public function __construct()
    {
        $this->connect();
    }

    /**
     * @inheritDoc
     */
    public function beginTransaction(): bool
    {
        // if (empty($this->transactionCounter++)) {
        //     return parent::beginTransaction();
        // }

        return true;
    }

    // /**
    //  * @inheritDoc
    //  */
    public function commit(): bool
    {
        // $this->transactionCounter = $this->transactionCounter - 1;

        // if (empty($this->transactionCounter)) {
        //     return parent::commit();
        // }

        return false;
    }

    // /**
    //  * @inheritDoc
    //  */
    public function rollBack(): bool
    {
        // $this->transactionCounter = $this->transactionCounter - 1;

        // if (empty($this->transactionCounter)) {
        //     return parent::rollback();
        // }

        return false;
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
    private function connect(): void
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
