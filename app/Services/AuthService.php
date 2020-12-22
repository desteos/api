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
            $accessToken = AuthHelper::generateAccessToken($userId);
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

    public static function forgetToken()
    {
        $token = $_COOKIE['token'];

        if (isset($token)) {
            RefreshToken::update(AuthHelper::encodedToken($token), ['active' => 0]);

            setcookie('token', null);
        }
    }

    public static function validateToken($token, string $userAgent): bool
    {
        $tokenExpired = strtotime($token['expires_at']) < strtotime('now');
        $tokenInactive = $token['active'] === 0;
        $userAgentChanged = $token['user_agent'] !== $userAgent; //todo fingerprint in future

        return ($tokenExpired || $tokenInactive || $userAgentChanged) ? false : true;
    }

    public static function refreshTokenPair($token): string
    {
        $accessToken = AuthHelper::generateAccessToken($token['user_id']);
        $refreshToken = AuthHelper::generateRefreshToken();

        RefreshToken::update($token['id'], [
            'id' => AuthHelper::encodedToken($refreshToken),
            'expires_at' => date('Y-m-d H:i:s', strtotime('+1 day')),
        ]);

        AuthHelper::setRefreshToken($refreshToken);

        return $accessToken;
    }
}