<?php

namespace App\Helpers;

class AuthHelper
{
    public static function checkAccessToken(string $accessToken): bool
    {
        return true; //jwt
    }

    public static function generateAccessToken(): string
    {
        return 'jwt';
    }

    public static function generateRefreshToken(): string //todo handle exception
    {
        return bin2hex(random_bytes(16));
    }

    public static function prepareTokenToStore(string $token): string
    {
        return hash_hmac('sha256', $token, config('app')['secret']);
    }

    public static function setRefreshToken(string $refreshToken): void
    {
        setcookie('token', $refreshToken, [
            'path' => '/api/auth',
            'domain' => config('app')['url'],
            'expires' => strtotime('+1 day'),
            'httponly' => true,
            'SameSite' => 'Strict',
        ]);
    }
}