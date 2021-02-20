<?php

namespace App\Controllers\v1;

use App\Models\User;
use System\Request;

class UserController
{
    /**
     * @param  Request  $request
     */
    public function store(Request $request)
    {
        apiResponse(User::create($request->post));
    }

    /**
     * @param $id
     * @param  Request  $request
     */
    public function update($id, Request $request)
    {
        //todo permission check
        apiResponse(User::update($id, $request->put));
    }

    /**
     * @param $id
     */
    public function show($id)
    {
        //todo role permission check
        apiResponse(User::find($id));
    }
}
