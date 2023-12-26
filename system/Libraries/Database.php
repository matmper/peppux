<?php

namespace System\Libraries;

use Exception;

class Database
{
    /**
     * Active database connection
     *
     * @var \mysqli
     */
    private $connection;

    public function __construct()
    {
        $this->connect();
    }

    public function __destruct()
    {
        $this->close();
    }

    /**
     * Execute MySQL query and close connection
     *
     * @param string $query
     * @param array $bindParams
     * @param boolean $multiple
     * @return \mysqli_stmt|null
     */
    public function statement(string $query, array $bindParams = [], bool $multiple = true): ?\mysqli_stmt
    {
        $stmt = $this->connection->prepare($query);

        if (!empty($bindParams)) {
            $bind = '';

            foreach ($bindParams as $var) {
                $bind .= is_int($var) ? 'i' : (is_float($var) ? 'd' : 's');
            }

            $stmt->bind_param($bind, ...$bindParams);
        }

        $stmt->execute();

        return $stmt;
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
        $stmt = $this->statement($query, $bindParams);

        $result = $stmt->get_result();

        $stmt->close();

        $response = $result->fetch_array(MYSQLI_ASSOC);

        return !empty($response) ? (object) $response : null;
    }

    /**
     * Execute query and fetch all
     *
     * @param string $query
     * @param array $bindParams
     * @return object|null
     */
    public function all(string $query, array $bindParams = []): array
    {
        $stmt = $this->statement($query, $bindParams);

        $result = $stmt->get_result();

        $stmt->close();

        return json_decode(json_encode($result->fetch_all(MYSQLI_ASSOC)), false);
    }

    /**
     * Transaction: Begin
     *
     * @return void
     */
    public function beginTransction(): void
    {
        $this->connection->begin_transaction();
    }

    /**
     * Transaction: Commit
     *
     * @return void
     */
    public function commit(): void
    {
        $this->connection->commit();
    }

    /**
     * Transaction: Rollback
     *
     * @return void
     */
    public function rollback(): void
    {
        $this->connection->rollback();
    }

    /**
     * Create and open a new database with default data
     *
     * @return self
     */
    private function connect(): self
    {
        $connectionName = config('database.default');
        $config = config("database.connections.{$connectionName}");

        $this->connection = mysqli_connect(
            $config['host'],
            $config['user'],
            $config['pass'],
            $config['name'],
            $config['port'],
            $config['socket']
        );

        if (mysqli_connect_errno()) {
            throw new Exception(
                'database connection error: ' . mysqli_connect_errno(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return $this;
    }

    /**
     * Close a database connection
     * @param \mysqli_stmt|false $result
     * @return boolean
     */
    private function close(): void
    {
        $this->connection->close();
        $this->connection = null;
    }
}
