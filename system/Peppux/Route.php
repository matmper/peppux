<?php

namespace Peppux;

class Route
{
    protected $method = 'GET';

    protected $controller = '';

    /**
     * Set route into your method http
     *
     * @param string $method
     * @return object
     */
    public function method(string $method): self
    {
        $this->method = strtoupper($method);

        if (!in_array($this->method, config('routes.methods'))) {
            throw new \Exception("method `$this->method` type is not allowed", 1);
        }

        return $this;
    }

    /**
     * Set controller class to a route
     *
     * @param string $controllerClass
     * @return self
     */
    public function controller(string $controllerClass): self
    {
        $this->controller = $controllerClass;
        return $this;
    }
  
    /**
     * Insert a new route into array server routes
     *
     * @param string $path
     * @param string $method
     * @return void
     */
    public function add(string $path, string $method): void
    {
        $path = '/' . trim($path, ' /');

        $_SERVER['_ROUTES'][$this->method][$path] = [
            'controller' => $this->controller,
            'method' => $method,
            'middlewares' => [],
        ];
    }
}
