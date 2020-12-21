<?php

namespace App\Helpers;

class AuthHelper
{
    public static function getAccessTokenFromHeader(): ?string
    {
        if ($token = $_SERVER['HTTP_AUTHORIZATION'] ?? false) {
            return str_replace('Bearer ', '', $token);
        }

        return null;
    }

    public static function tokenExpired(string $accessToken): bool
    {
        $tokenParts = explode('.', $accessToken);

        $payload = base64_decode($tokenParts[1]);

        return json_decode($payload)->exp < strtotime('now');
    }

    public static function isValidToken(string $accessToken): bool
    {
        $tokenParts = explode('.', $accessToken);

        if (count($tokenParts) < 3) {
            return false;
        }

        $header = base64_decode($tokenParts[0]);
        $payload = base64_decode($tokenParts[1]);
        $signatureProvided = $tokenParts[2];

        $encodedHeader = base64UrlEncode($header);
        $encodedPayload = base64UrlEncode($payload);
        $signature = hash_hmac('sha256', $encodedHeader.".".$encodedPayload, config('app')['secret'], true);
        $base64UrlSignature = base64UrlEncode($signature);

        return $base64UrlSignature === $signatureProvided;
    }

    public static function generateAccessToken(int $userId): string
    {
        $header = json_encode([
            'typ' => 'JWT',
            'alg' => 'HS256'
        ]);
        $payload = json_encode([
            'userId' => $userId,
            'exp' => strtotime('+5 minutes')
        ]);

        $base64UrlHeader = base64UrlEncode($header);
        $base64UrlPayload = base64UrlEncode($payload);

        $signature = hash_hmac('sha256', $base64UrlHeader.".".$base64UrlPayload,
            config('app')['secret'], true);

        $base64UrlSignature = base64UrlEncode($signature);

        return $base64UrlHeader.".".$base64UrlPayload.".".$base64UrlSignature;
    }

    public static function generateRefreshToken(): string
    {
        //todo handle exception
        return bin2hex(random_bytes(32));
    }

    public static function encodedToken(string $token): string
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