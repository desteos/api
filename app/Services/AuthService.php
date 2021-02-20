<?php

namespace App\Services;

use App\Helpers\AuthHelper;
use App\Models\RefreshToken;
use App\Models\User;
use System\Request;

class AuthService
{
    /**
     * @param  Request  $request
     * @return string|false
     * @throws \Exception
     */
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

    /**
     * Update refresh token status and clear it from cookies
     */
    public static function logout(): void
    {
        $token = $_COOKIE['token'] ?? null;

        if (!is_null($token)) {
            RefreshToken::update(AuthHelper::encodedToken($token), ['active' => 0]);

            setcookie('token', null);
        }
    }

    /**
     * Refresh tokens after access token expired
     *
     * @param  array  $token
     * @return string
     * @throws \Exception
     */
    public static function refreshTokenPair(array $token): string
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
