<?php

namespace App\Controllers\v1;

use App\Models\User;
use System\Request;

class UserController
{
    public function store(Request $request)
    {
        apiResponse(User::create($request->post));
    }

    public function update($id, Request $request)
    {
        //todo permission check
        apiResponse(User::update($id, $request->put));
    }

    public function show($id)
    {
        //todo role permission check
        apiResponse(User::find($id));
    }
}
