<?php

namespace App\Controllers;

use App\Helpers\AuthHelper;
use App\Models\RefreshToken;
use App\Models\User;
use System\Request;
use System\Response;

class AuthController
{
    public function login(Request $request)
    {
        if ($userID = User::checkCredentials($request->post)) {
            $accessToken = AuthHelper::generateAccessToken();
            $refreshToken = AuthHelper::generateRefreshToken();

            RefreshToken::create([
                'id' => AuthHelper::prepareTokenToStore($refreshToken),
                'user_id' => $userID,
                'expires_at' => date('Y-m-d H:i:s', strtotime('+1 day')),
                'ip' => $request->ip,
                'user_agent' => $request->user_agent, //todo add fingerprint
                'active' => 1
            ]);

            AuthHelper::setRefreshToken($refreshToken);

            Response::json([
                'accessToken' => $accessToken
            ]);
        }

        Response::json([], 422); //todo general error response with messages
    }

    public function logout(Request $request)
    {
        //remove tokens

        Response::json([], 200);
    }

    public function refreshTokens()
    {

    }
}