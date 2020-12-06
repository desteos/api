<?php

namespace App\Controllers;

use App\Models\Article;
use System\Request;
use System\Response;

class ArticleController extends BaseController
{
    public function index()
    {
        $result = Article::all();

        Response::json($result);
    }

    public function show($id)
    {
        $result = Article::find($id);

        Response::json($result);
    }

    public function store(Request $request)
    {
        $result = Article::create($request->post);

        Response::json($result);
    }

    public function update($id, Request $request)
    {
        $result = Article::update($id, $request->put);

        Response::json($result);
    }

    public function destroy($id)
    {
        echo 'destroy '.$id;
    }
}