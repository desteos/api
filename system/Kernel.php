<?php
namespace System;

class Kernel
{
    public function init()
    {
        $router = new \System\Router();
        $router->handle();
    }
}