<?php
namespace App\Models;

use System\DB;

class Article
{
    public static function all()
    {
        $query = DB::query("SELECT * FROM articles");

        return $query->fetchAll();
    }

    public static function find(int $id)
    {
        $query = DB::prepare('SELECT * FROM articles WHERE id = :id');

        $query->execute([':id' => $id]);

        return $query->fetch();
    }
}