<?php

namespace App\Controllers\v1;

use App\Models\Article;
use System\Request;

class ArticleController
{
    public function index()
    {
        $result = Article::all();

        apiResponse($result);
    }

    /**
     * @param $id
     */
    public function show($id)
    {
        $result = Article::find($id);

        apiResponse($result);
    }

    /**
     * @param  Request  $request
     */
    public function store(Request $request)
    {
        $result = Article::create($request->post);

        apiResponse($result);
    }

    /**
     * @param $id
     * @param  Request  $request
     */
    public function update($id, Request $request)
    {
        $result = Article::update($id, $request->put);

        apiResponse($result);
    }

    /**
     * @param $id
     */
    public function destroy($id)
    {
        apiResponse(['destroy '.$id]);
    }
}