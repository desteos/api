<?php
namespace System;

use PDO;

class DB extends PDO
{
    private $instance;

    public function __construct()
    {
        $config = require '../config/db.php';
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
        ];

        if(is_null($this->instance)){
            $this->instance = parent::__construct($config['dsn'], $config['username'], $config['password'], $options);
        }
    }
}