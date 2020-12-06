<?php

namespace App\Controllers;

use App\Models\Article;
use App\Models\User;
use System\Request;
use System\Response;

class UserController
{
    public function store(Request $request)
    {
        Response::json(User::create($request->post));
    }

    public function update(Request $request)
    {
        Response::json(User::update($request->post));
    }

    public function show($id)
    {
        //todo role permission check
        $result = User::find($id);

        Response::json($result);
    }
}