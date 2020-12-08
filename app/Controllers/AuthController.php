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
        if ($userId = User::checkCredentials($request->post)) {
            $accessToken = AuthHelper::generateAccessToken($userId);
            $refreshToken = AuthHelper::generateRefreshToken();

            RefreshToken::create([
                'id' => AuthHelper::encodedToken($refreshToken),
                'user_id' => $userId,
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

    public function logout()
    {
        $token = $_COOKIE['token'];

        if(isset($token)){
            RefreshToken::update(AuthHelper::encodedToken($token), ['active' => 0]);

            setcookie('token', null);
        }

        Response::json([
            'accessToken' => null
        ], 200);
    }

    public function refreshTokens(Request $request)
    {
        $token = $_COOKIE['token'];

        $storedToken = RefreshToken::find(AuthHelper::encodedToken($token));

        if(empty($storedToken)){
            setcookie('token', null);

            Response::json([
                'errors' => ['token-error'],
                'accessToken' => null
            ], 401);
        }

        $tokenExpired = strtotime($storedToken['expires_at']) < strtotime('now');
        $tokenInactive = $storedToken['active'] === 0;
        $userAgentChanged = $storedToken['user_agent'] !== $request->user_agent;

        if($tokenExpired || $tokenInactive || $userAgentChanged){
            setcookie('token', null);

            Response::json([
                'errors' => ['token-erro1r'],
                'accessToken' => null
            ], 401);
        }

        // if all good
        $accessToken = AuthHelper::generateAccessToken($storedToken['user_id']);
        $refreshToken = AuthHelper::generateRefreshToken();

        RefreshToken::update($storedToken['id'], [
            'id' => AuthHelper::encodedToken($refreshToken),
            'expires_at' => date('Y-m-d H:i:s', strtotime('+1 day')),
        ]);

        AuthHelper::setRefreshToken($refreshToken);

        Response::json([
            'accessToken' => $accessToken
        ]);
    }
}