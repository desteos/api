<?php
namespace System;

class Router
{
    private $uri;
    private $type;
    private $routes;
    private $routeFound;

    public function __construct()
    {
        $this->routeFound = false;
        $this->routes = require '../config/routes.php';
        $this->uri = trim($_SERVER['REQUEST_URI'], '/');
        $this->type = $_SERVER['REQUEST_METHOD'];
    }

    public function handle()
    {
        foreach ($this->routes as $route => $endpoint) {
            list($method, $path) = explode('|', $route, 2);

            if($this->uri === $path && $this->type === $method){
                list($controller, $action) = explode('@', $endpoint, 2);

                $controllerFile = $this->getControllerFilePath($controller);

                if(file_exists($controllerFile)){
                    require_once $controllerFile;

                    $controller = $this->getControllerFullName($controller);

                    $instance = new $controller;
                    $instance->$action();
                    $this->routeFound = true;
                    break;
                }
            }
        }

        if(!$this->routeFound){
            http_response_code(404);
            die();
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