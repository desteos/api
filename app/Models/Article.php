<?php

namespace App\Models;

use System\DB;

class Article
{
    public static function all()
    {
        $articles = DB::query("SELECT * FROM articles;");

        return $articles->fetchAll();
    }

    public static function find(int $id)
    {
        $article = DB::prepare('SELECT * FROM articles WHERE id = :id;');

        $article->execute([':id' => $id]);

        return $article->fetch();
    }
}