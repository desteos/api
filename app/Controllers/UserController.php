<?php

namespace App\Controllers;

use App\Models\User;
use System\Request;
use System\Response;

class UserController
{
    public function store(Request $request)
    {
        Response::json(User::create($request->post));
    }
}