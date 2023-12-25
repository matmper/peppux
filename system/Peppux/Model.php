<?php

namespace Peppux;

use System\Libraries\QueryBuilder;

class Model extends QueryBuilder
{
    /**
     * @var string
     */
    public string $table;

    /**
     * @var string
     */
    public string $primary = 'id';

    /**
     * Array to store data values
     *
     * @var array
     */
    private $data = [];

    public function __construct()
    {
        parent::__construct();
        $this->table($this->table);
    }

    /**
     * Get dynamic variable
     *
     * @param string $name
     * @return
     */
    public function __get(string $name)
    {
        if (isset($this->data[$name])) {
            return $this->data[$name];
        }
    }

    /**
     * Set dynamic variable
     *
     * @param string $name
     * @param mixed $value
     */
    public function __set(string $name, mixed $value): void
    {
        $this->data[$name] = $value;
    }

    /**
     * Find and get first result
     *
     * @return object|null
     */
    public function find(int $id): ?object
    {
        return $this->where($this->primary, '=', $id)->first();
    }
}
