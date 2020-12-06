<?php

namespace System;

class Request
{
    public $uri;
    public $method;
    public $put;
    public $post;
    public $get;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->uri = trim($_SERVER['REQUEST_URI'], '/');
        $this->post = $_POST;
        $this->get = $_GET;

        //todo refactor
        $correctMimeType = true; //application/x-www-form-urlencoded

        //need add mime type without save php://input to tmp file
        if($this->method === 'PUT' && $correctMimeType){
            parse_str(file_get_contents('php://input'), $this->put);
        }

        //trim query
        if($queryPosition = strpos($this->uri, '?')){
            $this->uri = substr($this->uri, 0, $queryPosition);
        }
    }
}