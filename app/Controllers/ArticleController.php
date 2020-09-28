<?php
namespace App\Controllers;

class ArticleController
{
    public function index()
    {
        echo 'list';
    }

    public function show($id)
    {
        echo 'one article'.$id;
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