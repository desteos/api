<?php

if (!function_exists('apiResponse')) {
    function apiResponse($data = [], int $code = 200) {
        header('Content-Type: application/json');
        http_response_code($code);
        echo json_encode($data);
        exit();
    }
}

if (!function_exists('config')) {
    function config(string $name) {
        static $configs = [];

        if (!isset($configs[$name]) && $configs !== true) {
            $configs[$name] = require_once '../config/'.$name.'.php';
        }

        return $configs[$name];
    }
}

if (!function_exists('base64UrlEncode')) {
    function base64UrlEncode($text) {
        return str_replace(
            ['+', '/', '='],
            ['-', '_', ''],
            base64_encode($text)
        );
    }
}

if (!function_exists('dd')) {
    function dd(...$var) {
        var_dump(...$var);
        die;
    }
}