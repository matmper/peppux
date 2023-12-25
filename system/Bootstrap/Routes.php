<?php

namespace System\Bootstrap;

use System\Libraries\Response;

class Routes
{
    protected $uri;
    protected $parsed;
    protected $path;
    protected $method;
    protected $routes;

    public function __construct()
    {
        $this->__invoke();
    }

    public function __invoke()
    {
        $this->__include();

        $routes = $_SERVER['_ROUTES'];

        $method = !empty($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';

        $requestUri = '/';
        $requestUri .= !empty($_SERVER['REQUEST_URI']) ? trim($_SERVER['REQUEST_URI'], '/') : '';

        self::routeCache();

        if (!isset($routes[$method])) {
            return self::routeNotFound();
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

        // Rota não encontrada
        return self::routeNotFound();

        return self::routeMethodNotAllowed();
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
     */
    private static function loader(array $route, array $matches): void
    {
        try {
            Loader::controller($route['controller'], $route['method'], $matches);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Return 404 - Not found
     *
     * @return Response
     */
    private static function routeNotFound(): Response
    {
        $code = Response::HTTP_NOT_FOUND;

        return response()->setCode($code)->json([
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
    private static function routeMethodNotAllowed(): Response
    {
        $code = Response::HTTP_METHOD_NOT_ALLOWED;

        return response()->setCode($code)->json([
            'errors' => ['error.method_not_allowed'],
            'metadata' => [
                'message' => Response::getMessage($code),
                'code' => $code,
            ]
        ]);
    }
}
