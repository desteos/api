<?php

namespace System;

class Router
{
    private string $controllerNamespace = '\\App\\Controllers\\';
    private string $middlewareNamespace = '\\App\\Middlewares\\';

    public function __construct(
        public array $routes,
        public bool $routeFound = false
    ) {}

    public function handle(Request $request): void
    {
        foreach ($this->routes as $route => $data) {
            list($method, $uriPattern) = explode('|', $route, 2);

            if (preg_match("~^$uriPattern\z~", $request->uri) && $request->method === $method) {
                $endpoint = preg_replace("~$uriPattern~", $data['action'], $request->uri);
                $parts = explode('/', $endpoint);

                $controllerName = array_shift($parts);
                $action = array_shift($parts);

                $params = $parts;
                $params[] = $request; //last params will be request

                $controller = $this->controllerNamespace.$controllerName;

                // method_exists func call autoload functions
                // so if true then we dont need require_once controllers file
                if (!method_exists($controller, $action)) {
                    continue;
                }

                // middlewares runs only if action exists
                $this->runMiddlewares($data['middlewares'] ?? []);

                $this->execute($controller, $action, $params);

                $this->routeFound = true;

                break;
            }
        }

        if (!$this->routeFound) {
            apiResponse(code: 404);
        }
    }

    private function runMiddlewares(array $middlewares): void
    {
        $action = 'handle';

        foreach ($middlewares as $middleware) {
            $middleware = $this->middlewareNamespace.$middleware;

            if (!method_exists($middleware, $action)) {
                continue;
            }

            $this->execute($middleware, $action);
        }
    }

    private function execute(string $class, string $method, $params = []): void
    {
        $instance = new $class();
        $instance->$method(...$params);
    }
}