<?php
namespace App\Controllers;

use App\Models\User;
use System\Request;
use System\Response;
use App\Services\AuthService;

class AuthController
{
    public function login(Request $request)
    {
        if(User::checkCredentials($request->post)){
            Response::json([
                'accessToken' => 'uin54qp98wrhuinj2q90ewh8p9ruib' //todo auth
            ]);
        }

        Response::json([], 422); //todo general error response with messages
    }

    public function logout()
    {
        echo 'logout';
    }
}