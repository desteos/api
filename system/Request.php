<?php


namespace System;


class Request
{
    public $uri;
    public $method;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->uri = trim($_SERVER['REQUEST_URI'], '/');
    }
}