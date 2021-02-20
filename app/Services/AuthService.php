<?php

namespace App\Services;

use App\Helpers\AuthHelper;
use App\Models\RefreshToken;
use App\Models\User;
use System\Request;

class AuthService
{
    public static function login(Request $request): string|false
    {
        if ($userId = User::checkCredentials($request->post)) {
            $accessToken  = AuthHelper::generateAccessToken($userId);
            $refreshToken = AuthHelper::generateRefreshToken();

            //todo check for refresh sessions(logged devices) count

            RefreshToken::create([
                'id' => AuthHelper::encodedToken($refreshToken),
                'user_id' => $userId,
                'expires_at' => date('Y-m-d H:i:s', strtotime('+1 day')),
                'ip' => $request->ip,
                'user_agent' => $request->user_agent, //todo add fingerprint
                'active' => 1
            ]);

            AuthHelper::setRefreshToken($refreshToken);

            return $accessToken;
        }

        return false;
    }

    public static function logout()
    {
        $token = $_COOKIE['token'];

        if (isset($token)) {
            RefreshToken::update(AuthHelper::encodedToken($token), ['active' => 0]);

            setcookie('token', null);
        }
    }

    public static function refreshTokenPair($token): string
    {
        $refreshToken = AuthHelper::generateRefreshToken();
        $accessToken  = AuthHelper::generateAccessToken($token['user_id']);

        RefreshToken::update($token['id'], [
            'id' => AuthHelper::encodedToken($refreshToken),
            'expires_at' => date('Y-m-d H:i:s', strtotime('+1 day')),
        ]);

        AuthHelper::setRefreshToken($refreshToken);

        return $accessToken;
    }
}