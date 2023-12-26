<?php

namespace System\Libraries;

use System\Bootstrap\Support\Arrayable;

class Request implements Arrayable
{
    /**
     * $_GET
     *
     * @var array
     */
    private static $requestGet = [];

    /**
     * $_POST
     *
     * @var array
     */
    private static $requestPost = [];

    /**
     * Dynamic variables
     *
     * @var array
     */
    private $data = [];

    public function __construct()
    {
        $this->setRequestData();
    }

    /**
     * Get all get and post payload and params
     *
     * @return array
     */
    public static function all(): array
    {
        return self::toArray();
    }

    /**
     * Get a value from request (payload and params)
     *
     * @param string|int $param
     * @param string|null $method
     * @return mixed
     */
    public static function get(string|int $param, string $method = null): mixed
    {
        if ($method) {
            return self::getByMethod($param, $method);
        }

        foreach (['GET', 'POST'] as $method) {
            $get = self::getByMethod($param, $method);

            if ($get) {
                return $get;
            }
        }

        return null;
    }

    /**
     * Return a value from method (get = params and post = payload)
     *
     * @param string|integer $param
     * @param string $method
     * @return mixed
     */
    private static function getByMethod(string|int $param, string $method): mixed
    {
        $method = trim(mb_strtoupper($method));

        switch ($method) {
            case 'GET':
                return self::$requestGet[$param] ?? null;
            break;
            case 'POST':
                return self::$requestPost[$param] ?? null;
            break;
            default:
                return null;
            break;
        }
    }

    /**
     * Transform all request payload to and array
     *
     * @return array
     */
    public static function toArray(): array
    {
        return array_merge(self::$requestGet, self::$requestPost);
    }

    /**
     * Get array keys and return into an array
     *
     * @return array
     */
    public static function toArrayKeys(): array
    {
        return array_keys(self::toArray());
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
     * Set request get and post to dynmic variable
     *
     * @return void
     */
    private function setRequestData(): void
    {
        foreach ($_GET as $key => $value) {
            $this->{$key} = $this->requestGet[$key] = $value;
        }

        foreach ($_POST as $key => $value) {
            $this->{$key} = $this->requestPost[$key] = $value;
        }
    }
}
