<?php

namespace App\Controllers;

use App\Models\Article;
use App\Models\User;
use System\Request;
use System\Response;

class UserController extends BaseController
{
    public function store(Request $request)
    {
        Response::json(User::create($request->post));
    }

    public function update($id, Request $request)
    {
        Response::json(User::update($id, $request->put));
    }

    public function show($id)
    {
        //todo role permission check in BaseController
        $result = User::find($id);

        Response::json($result);
    }
}