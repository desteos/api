<?php
namespace App\Controllers;

use App\Models\Article;

class ArticleController
{
    public function index()
    {
        var_dump(Article::all());

        echo 'list';
    }

    public function show($id)
    {
        echo 'show article '.$id;
    }

    public function store()
    {
        echo 'store';
    }

    public function update()
    {
        echo 'update';
    }
}