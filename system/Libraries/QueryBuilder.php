<?php

namespace System\Libraries;

class QueryBuilder
{
    /**
     * Query builder
     *
     * @var array
     */
    private $builder;

    /**
     * Database connection
     *
     * @var Database
     */
    private Database $connection;

    public function __construct()
    {
        $this->connection = new Database;
        $this->reset();
    }

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //
    // RESULT
    //
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    /**
     * Get query rows
     *
     * @return array
     */
    public function get(): array
    {
        $this->build();
        $execute = $this->connection->all($this->builder['raw'], $this->builder['bind']);
        $this->reset();

        return $execute;
    }

    /**
     * Get query row
     *
     * @return object|null
     */
    public function first(): ?object
    {
        $this->build();
        $execute = $this->connection->row($this->builder['raw'], $this->builder['bind']);
        $this->reset();

        return $execute;
    }

        /**
     * Set a query raw
     *
     * @param string $queryRaw
     * @param array $bind
     * @return array
     */
    public function raw(string $queryRaw, array $bind = []): array
    {
        return $this->connection->all($queryRaw, $bind);
    }

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //
    // BUILDER - PUBLIC
    //
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    /**
     * Set columns to get select query
     *
     * @param string|array $columns
     * @return self
     */
    public function columns(string|array $columns): self
    {
        if (is_string($columns)) {
            $columns = explode(',', $columns);
        }

        $this->builder['columns'] = array_merge($this->builder['columns'], $columns);

        return $this;
    }

    /**
     * Set table to query
     *
     * @param string $table
     * @return self
     */
    public function table(string $table): self
    {
        $this->builder['table'] = $table;
        return $this;
    }

    /**
     * Set a new "and" where condition to query
     *
     * @param string $column
     * @param string $condition
     * @param string|integer|float $where
     * @return self
     */
    public function where(string $column, string $condition, string|int|float $where): self
    {
        $condition = strtoupper($condition);

        if (!in_array($condition, ['=', '>', '<', '>=', '<=', '!=', '<>', 'LIKE'])) {
            throw new \Exception("Query Exception: Where condition is invalid: $condition");
        }

        $this->builder['where'][] = [
            'column' => $column,
            'condition' => $condition,
            'where' => $where,
            'type' => 'and'
        ];

        return $this;
    }

    /**
     * Set limit pagination query
     *
     * @param integer $limit
     * @param integer|null $offset
     * @return self
     */
    public function limit(int $limit, ?int $offset = null): self
    {
        $this->builder['limit'] = $limit;

        if ($offset) {
            $this->builder['offset'] = $offset;
        }

        return $this;
    }

    /**
     * Set order by to query
     *
     * @param string $column
     * @param string $type
     * @return self
     */
    public function order(string $column, string $type = 'ASC'): self
    {
        $this->builder['order'][] = [
            'column' => $column,
            'type' => $type
        ];

        return $this;
    }

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //
    // PRIVATE
    //
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    /**
     * Create query sequence
     *
     * @return self
     */
    private function build(): void
    {
        $this->buildColumns();
        $this->buildTable();
        $this->buildWhere();
        $this->buildOrder();
        $this->buildLimit();
    }

    /**
     * Concat raw into query builder
     *
     * @param string $raw
     * @return void
     */
    private function concat(string $raw): void
    {
        $this->builder['raw'] .= "{$raw} ";
    }

    /**
     * Reset query builder params
     *
     * @return void
     */
    private function reset(): void
    {
        $this->builder = [
            'table' => !empty($this->builder['table']) ? $this->builder['table'] : '',
            'raw' => 'SELECT ',
            'bind' => [],
            'columns' => [],
            'where' => [],
            'limit' => null,
            'offset' => null,
            'order' => [],
        ];
    }

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //
    // BUILDER - PRIVATE
    //
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    /**
     * Query Sequence: columns
     *
     * @return void
     */
    private function buildColumns(): void
    {
        $columns = empty($this->builder['columns'])
            ? '*'
            : '`' . implode('`,`', $this->builder['columns']) . "`";

        $this->concat($columns);
    }

    /**
     * Query Sequence: table
     *
     * @return void
     */
    private function buildTable(): void
    {
        $this->concat("FROM `{$this->builder['table']}`");
    }

    /**
     * Query Sequence: where
     *
     * @return void
     */
    private function buildWhere(): void
    {
        if (empty($this->builder['where'])) {
            return;
        }

        $this->concat("WHERE");

        foreach ($this->builder['where'] as $key => $where) {
            if ($key) {
                $this->concat(strtoupper($where['type']));
            }

            $this->concat("`{$where['column']}` {$where['condition']} ?");

            $this->builder['bind'][] = $where['where'];
        }
    }

    /**
     * Query Sequence: order
     *
     * @return void
     */
    private function buildOrder(): void
    {
        if (empty($this->builder['order'])) {
            return;
        }

        $orders = [];

        foreach ($this->builder['order'] as $order) {
            $orders[] = "`{$order['column']}` " . strtoupper($order['type']);
        }

        $this->concat('ORDER BY ' . implode(', ', $orders));
    }

    /**
     * Query Sequence: limit and offset
     *
     * @return void
     */
    private function buildLimit(): void
    {
        if (is_int($this->builder['limit']) && is_int($this->builder['offset'])) {
            $this->concat("LIMIT {$this->builder['limit']} OFFSET {$this->builder['offset']}");
        } elseif (is_int($this->builder['limit'])) {
            $this->concat("LIMIT {$this->builder['limit']}");
        }
    }
}
