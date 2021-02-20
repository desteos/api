<?php

namespace App\Helpers;

class AuthHelper
{
    /**
     * Get access token from header
     *
     * @return string|null
     * @static
     */
    public static function getAccessTokenFromHeader(): ?string
    {
        if ($token = $_SERVER['HTTP_AUTHORIZATION'] ?? false) {
            return str_replace('Bearer ', '', $token);
        }

        return null;
    }

    /**
     * Check if access token expired
     *
     * @param  string  $accessToken
     * @static
     * @return bool
     */
    public static function tokenExpired(string $accessToken): bool
    {
        $tokenParts = explode('.', $accessToken);

        $payload = base64_decode($tokenParts[1]);

        return json_decode($payload)->exp < strtotime('now');
    }

    /**
     * Token signature verification
     *
     * @param  string  $accessToken
     * @static
     * @return bool
     */
    public static function validateAccessToken(string $accessToken): bool
    {
        $tokenParts = explode('.', $accessToken);

        if (count($tokenParts) < 3) {
            return false;
        }

        $header  = base64_decode($tokenParts[0]);
        $payload = base64_decode($tokenParts[1]);
        $signatureProvided = $tokenParts[2];

        $encodedHeader  = base64UrlEncode($header);
        $encodedPayload = base64UrlEncode($payload);
        $signature = hash_hmac('sha256', $encodedHeader.".".$encodedPayload, config('app')['secret'], true);
        $base64UrlSignature = base64UrlEncode($signature);

        return $base64UrlSignature === $signatureProvided;
    }

    /**
     * Check refresh token on expired date, active status and user agent changes
     *
     * @todo make check for fingerprint changes
     *
     * @param  array  $token
     * @param  string  $userAgent
     * @static
     * @return bool
     */
    public static function validateRefreshToken(array $token, string $userAgent): bool
    {
        $tokenExpired = strtotime($token['expires_at']) < strtotime('now');
        $tokenInactive = $token['active'] === 0;
        $userAgentChanged = $token['user_agent'] !== $userAgent; //todo fingerprint in future

        return ($tokenExpired || $tokenInactive || $userAgentChanged) ? false : true;
    }

    /**
     * Generate JWT token
     *
     * @param  int  $userId
     * @return string
     */
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

        $base64UrlHeader  = base64UrlEncode($header);
        $base64UrlPayload = base64UrlEncode($payload);

        $signature = hash_hmac('sha256', $base64UrlHeader.".".$base64UrlPayload,
            config('app')['secret'], true);

        $base64UrlSignature = base64UrlEncode($signature);

        return $base64UrlHeader.".".$base64UrlPayload.".".$base64UrlSignature;
    }

    /**
     * Generate refresh token
     *
     * @return string
     * @throws \Exception
     */
    public static function generateRefreshToken(): string
    {
        //todo handle exception
        return bin2hex(random_bytes(32));
    }

    /**
     * Encode token for storing in db
     *
     * @param  string  $token
     * @return string
     */
    public static function encodedToken(string $token): string
    {
        return hash_hmac('sha256', $token, config('app')['secret']);
    }

    /**
     * Set refresh token in cookie
     *
     * @param  string  $refreshToken
     */
    public static function setRefreshToken(string $refreshToken): void
    {
        setcookie('token', $refreshToken, [
            'path' => '/api/v1/auth', //todo api version control
            'domain' => config('app')['url'],
            'expires' => strtotime('+1 day'),
            'httponly' => true,
            'SameSite' => 'Strict',
        ]);
    }
}