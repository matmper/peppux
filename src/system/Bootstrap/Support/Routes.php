<?php

namespace System\Bootstrap\Support;

use System\Libraries\Response;

final class Routes
{
    /**
     * @var string
     */
    protected string $uri;

    /**
     * @var string
     */
    protected string $path;

    /**
     * @var string
     */
    protected string $method;

    /**
     * @var string
     */
    protected string $routes;

    public function __construct()
    {
        $this->__invoke();
    }

    /**
     * Invoke application routes
     *
     * @return void
     */
    public function __invoke(): void
    {
        $this->__include();

        $routes = $_SERVER['_ROUTES'];

        $method = !empty($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';

        $requestUri = '/';
        $requestUri .= !empty($_SERVER['REQUEST_URI']) ? trim($_SERVER['REQUEST_URI'], '/') : '';

        self::routeCache();

        if (!isset($routes[$method])) {
            self::routeNotFound();
            return;
        }

        if (isset($routes[$method][$requestUri])) {
            self::loader($routes[$method][$requestUri], []);
            return;
        }

        foreach ($routes[$method] as $path => $route) {
            $pattern = '#^' . preg_replace('/\{(\w+)\}/', '(?P<$1>[^/]+)', $path) . '$#';

            if (preg_match($pattern, $requestUri, $matches)) {
                self::loader($route, $matches);
                return;
            }
        }

        if (is_string($routes)) {
            self::routeMethodNotAllowed();
            return;
        }

        // Route not found (404)
        self::routeNotFound();
        return;
    }

    /**
     * Load and include routes files
     *
     * @return void
     */
    private function __include(): void
    {
        $routes = config('routes.load');

        foreach ($routes as $route) {
            if (!file_exists($routefile = APPPATH . "routes/$route.php")) {
                throw new \Exception("route file `$routefile` not found", 1);
            }

            require_once($routefile);
        }
    }

    /**
     * Clean the route cache
     *
     * @return void
     */
    private static function routeCache(): void
    {
        unset($_SERVER['_ROUTES']);
    }

    /**
     * Load controller function
     *
     * @param array $route
     * @param array $matches
     * @return void
     * @throws \Throwable
     */
    private static function loader(array $route, array $matches): void
    {
        try {
            Loader::controller($route['controller'], $route['method'], $matches);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Return 404 - Not found
     *
     * @return void
     */
    private static function routeNotFound(): void
    {
        $code = Response::HTTP_NOT_FOUND;

        response()->setCode($code)->json([
            'errors' => ['error.not_found'],
            'metadata' => [
                'message' => Response::getMessage($code),
                'code' => $code,
            ]
        ]);
    }

    /**
     * Return 405 - Method not allowed
     *
     * @return void
     */
    private static function routeMethodNotAllowed(): void
    {
        $code = Response::HTTP_METHOD_NOT_ALLOWED;

        response()->setCode($code)->json([
            'errors' => ['error.method_not_allowed'],
            'metadata' => [
                'message' => Response::getMessage($code),
                'code' => $code,
            ]
        ]);
    }
}
