<?php

namespace App\Controllers\v1;

use App\Helpers\AuthHelper;
use App\Models\RefreshToken;
use App\Services\AuthService;
use System\Request;

class AuthController
{
    public function login(Request $request)
    {
        if ($accessToken = AuthService::login($request)) {
            apiResponse(data: ['accessToken' => $accessToken]);
        }

        apiResponse(data: [
            'errors' => ['bad-credentials']
        ], code: 422);
    }

    public function logout()
    {
        AuthService::logout();

        apiResponse(data: ['accessToken' => null]);
    }

    public function refreshTokens(Request $request)
    {
        $token = RefreshToken::find(AuthHelper::encodedToken($_COOKIE['token']));

        if (empty($token) || !AuthHelper::validateRefreshToken($token, $request->user_agent)) {
            setcookie('token', null);

            apiResponse(data: [
                'errors' => ['token-error'],
                'accessToken' => null
            ], code: 401);
        }

        $accessToken = AuthService::refreshTokenPair($token);

        apiResponse(data: ['accessToken' => $accessToken]);
    }
}