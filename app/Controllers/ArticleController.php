<?php

namespace App\Controllers;

use App\Models\Article;
use System\Request;

class ArticleController
{
    public function index()
    {
        $result = Article::all();

        apiResponse($result);
    }

    public function show($id)
    {
        $result = Article::find($id);

        apiResponse($result);
    }

    public function store(Request $request)
    {
        $result = Article::create($request->post);

        apiResponse($result);
    }

    public function update($id, Request $request)
    {
        $result = Article::update($id, $request->put);

        apiResponse($result);
    }

    public function destroy($id)
    {
        apiResponse(['destroy '.$id]);
    }
}