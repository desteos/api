<?php

namespace System;

use MongoDB\Client as Mongo;

class MongoDB
{
    private static $db = null;
    private static $config = null;

    public static function get()
    {
        if (is_null(self::$config) || is_null(self::$db)) {
            self::$config = require_once '../config/mongo_db.php';
            self::$db = new Mongo(self::$config['connection_string']);
        }

        $name = self::$config['db_name'];

        return self::$db->$name;
    }
}