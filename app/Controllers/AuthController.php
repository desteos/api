<?php

namespace App\Controllers;

use App\Helpers\AuthHelper;
use App\Models\User;
use System\Request;
use System\Response;

class AuthController
{
    public function login(Request $request)
    {
        if (User::checkCredentials($request->post)) {
            setcookie('_token', AuthHelper::generateRefreshToken());

            Response::json([
                'accessToken' => AuthHelper::generateAccessToken()
            ]);
        }

        Response::json([], 422); //todo general error response with messages
    }

    public function logout()
    {
        //remove tokens

        Response::json([], 200);
    }
}