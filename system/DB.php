<?php

namespace System;

use PDO;

class DB
{
    private static $pdo = null;

    public static function __callStatic($name, $args)
    {
        $callback = array(self::getPDO(), $name);

        return call_user_func_array($callback, $args);
    }

    private static function getPDO()
    {
        if (!is_null(self::$pdo)) {
            return self::$pdo;
        }

        $config = require '../config/db.php';

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
        ];

        self::$pdo = new PDO($config['dsn'], $config['username'], $config['password'], $options);

        return self::$pdo;
    }
}