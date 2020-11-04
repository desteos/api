<?php
namespace System;

class Router
{
    private $routes;
    private $routeFound;

    public function __construct(array $routes)
    {
        $this->routeFound = false;
        $this->routes = $routes;
    }

    public function handle(Request $request)
    {
        foreach ($this->routes as $route => $endpoint) {
            list($method, $uriPattern) = explode('|', $route, 2);

            if(preg_match("~^$uriPattern\z~", $request->uri) && $request->method === $method){
                $endpoint = preg_replace("~$uriPattern~", $endpoint, $request->uri);
                $parts    = explode('/', $endpoint);

                $controller = array_shift($parts);
                $action     = array_shift($parts);

                $params = $parts;
                $params[] = $request;

                $controllerFile = $this->getControllerFilePath($controller);

                if(file_exists($controllerFile)){
                    require_once $controllerFile;

                    $controller = $this->getControllerFullName($controller);

                    $instance = new $controller;
                    $instance->$action(...$params);

                    $this->routeFound = true;

                    break;
                }
            }
        }

        if(!$this->routeFound){
            Response::json(array(),404);
        }
    }

    private function getControllerFullName($controllerName)
    {
        return '\\App\\Controllers\\'.$controllerName;
    }

    private function getControllerFilePath($controllerName)
    {
        return __DIR__.'/../app/Controllers/'.$controllerName.'.php';
    }
}