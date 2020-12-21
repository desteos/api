<?php

namespace App\Controllers;

use App\Models\User;
use System\Request;

class UserController
{
    public function store(Request $request)
    {
        //todo without auth check
        apiResponse(User::create($request->post));
    }

    public function update($id, Request $request)
    {
        //todo auth, permission check
        apiResponse(User::update($id, $request->put));
    }

    public function show($id)
    {
        //todo auth, role permission check
        apiResponse(User::find($id));
    }
}
