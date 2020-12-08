<?php

namespace App\Controllers;

use App\Models\User;
use System\Request;
use System\Response;

class UserController
{
    public function store(Request $request)
    {
        //todo without auth check
        Response::json(User::create($request->post));
    }

    public function update($id, Request $request)
    {
        //todo auth, permission check
        Response::json(User::update($id, $request->put));
    }

    public function show($id)
    {
        //todo auth, role permission check

        Response::json(User::find($id));
    }
}
