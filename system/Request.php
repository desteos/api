<?php

namespace System;

class Request
{
    public $uri;
    public $method;
    public $headers;
    public $user_agent;
    public $post;
    public $put;
    public $get;
    public $ip;

    public function __construct()
    {
        $this->headers = apache_request_headers();
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->uri = trim($_SERVER['REQUEST_URI'], '/');
        $this->post = $_POST;
        $this->get = $_GET;
        $this->ip = $_SERVER['REMOTE_ADDR'];
        $this->user_agent = $_SERVER['HTTP_USER_AGENT'];

        //todo refactor
        $correctMimeType = $this->headers['Content-Type'] === 'application/x-www-form-urlencoded';

        if($this->method === 'PUT' && $correctMimeType){
            parse_str(file_get_contents('php://input'), $this->put);
        }

        //trim query
        if($queryPosition = strpos($this->uri, '?')){
            $this->uri = substr($this->uri, 0, $queryPosition);
        }
    }
}