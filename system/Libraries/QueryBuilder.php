<?php

namespace System\Libraries;

use System\Enums\QueryCondition;

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
     * Push new where condition: and where
     *
     * @param string $column
     * @param string $condition
     * @param string|integer|float $where
     * @return self
     */
    public function where(string $column, string $condition, string|int|float $where): self
    {
        $this->pushWhere($column, $condition, $where, 'AND');
        return $this;
    }

    /**
     * Push new where condition: or where
     *
     * @param string $column
     * @param string $condition
     * @param string|integer|float $where
     * @return self
     */
    public function orWhere(string $column, string $condition, string|int|float $where): self
    {
        $this->pushWhere($column, $condition, $where, 'OR');
        return $this;
    }

    /**
     * Push new where condition: and where in
     *
     * @param string $column
     * @param array $where
     * @return self
     */
    public function whereIn(string $column, array $where): self
    {
        $this->pushWhere($column, QueryCondition::IN, $this->implodeWhere($where), 'AND');
        return $this;
    }

    /**
     * Push new where condition: or where in
     *
     * @param string $column
     * @param array $where
     * @return self
     */
    public function orWhereIn(string $column, array $where): self
    {
        $this->pushWhere($column, QueryCondition::IN, $this->implodeWhere($where), 'OR');
        return $this;
    }

    /**
     * Push new where condition: and where not in
     *
     * @param string $column
     * @param array $where
     * @return self
     */
    public function whereNotIn(string $column, array $where): self
    {
        $this->pushWhere($column, QueryCondition::NOT_IN, $this->implodeWhere($where), 'AND');
        return $this;
    }

    /**
     * Push new where condition: or where not in
     *
     * @param string $column
     * @param array $where
     * @return self
     */
    public function orWhereNotIn(string $column, array $where): self
    {
        $this->pushWhere($column, QueryCondition::NOT_IN, $this->implodeWhere($where), 'OR');
        return $this;
    }

    /**
     * Set limit pagination query
     *
     * @param integer $limit
     * @param integer|null $offset
     * @return self
     */
    public function limit(int $limit, int $offset = null): self
    {
        $this->builder['limit'] = $limit;

        if (is_int($offset)) {
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
     * Push new item to where array
     *
     * @param string $column
     * @param string $condition
     * @param string|integer|float $where
     * @param string $type
     * @return void
     */
    private function pushWhere(string $column, string $condition, string|int|float $where, string $type): void
    {
        $this->builder['where'][] = [
            'column' => $column,
            'condition' => $condition,
            'where' => $where,
            'type' => $type,
        ];
    }

    /**
     * Implode array to where in condition, eg: [1,2] -> ('1','2')
     *
     * @param array $where
     * @return string
     */
    private function implodeWhere(array $where): string
    {
        return "('" . implode("','", $where) . "')";
    }

    /**
     * Create query sequence
     *
     * @return self
     */
    private function build(): void
    {
        try {
            $this->buildColumns();
            $this->buildTable();
            $this->buildWhere();
            $this->buildOrder();
            $this->buildLimit();
        } catch (\Throwable $th) {
            throw $th;
        }
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

        $conditionsArray = QueryCondition::toArray();

        $this->concat("WHERE");

        foreach ($this->builder['where'] as $key => $where) {
            $condition = strtoupper($where['condition']);
            $type = strtoupper($where['type']);

            if (!in_array($condition, $conditionsArray)) {
                throw new \Exception("Where type is invalid: " . json_encode($where));
            }

            if ($key) {
                $this->concat($type);
            }

            if (in_array($condition, [QueryCondition::IN, QueryCondition::NOT_IN])) {
                $this->concat("`{$where['column']}` {$condition} {$where['where']}");
            } else {
                $this->concat("`{$where['column']}` {$condition} ?");
                $this->builder['bind'][] = $where['where'];
            }
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
            if (!in_array($order['type'], ['ASC', 'DESC'])) {
                throw new \Exception("Order type is invalid: " . json_encode($order));
            }

            $orders[] = "`{$order['column']}` {$order['type']}";
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
