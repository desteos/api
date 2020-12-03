<?php

namespace System;

class Kernel
{
    public $routes;

    public function __construct()
    {
        $this->routes = require_once '../config/routes.php';
    }

    public function init()
    {
        $router = new \System\Router($this->routes);
        $request = new Request();
        $router->handle($request);
    }
}