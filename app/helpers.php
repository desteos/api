<?php

if (! function_exists('config')) {
    function config(string $name){
        $config = require_once '../config/'.$name.'.php';

        if(empty($config)){
            return null;
        }

        return $config;
    }
}