<?php

namespace System;

use MongoDB\Client as Mongo;

class MongoDB
{
    private static $db = null;
    private static $config = null;

    public static function get()
    {
        if(is_null(self::$config) || is_null(self::$db)){
            self::$config = require_once '../config/mongo_db.php';
            self::$db = self::connection();
        }

        $name = self::$config['db_name'];

        return self::$db->$name;
    }

    private static function connection()
    {
        $options = 'mongodb://'.self::$config['username'].':'.self::$config['password'].'@127.0.0.1:27017';
        return new Mongo($options);
    }
}