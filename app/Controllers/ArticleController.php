<?php

namespace App\Controllers;

use App\Models\Article;
use System\Request;
use System\Response;

class ArticleController extends BaseController
{
    public function index()
    {
        Response::json(Article::all());
    }

    public function show($id)
    {
        Response::json(Article::find($id));
    }

    public function store(Request $request)
    {
        Response::json(Article::create($request->post));
    }

    public function update($id)
    {
        echo 'update '.$id;
    }

    public function destroy($id)
    {
        echo 'destroy '.$id;
    }
}