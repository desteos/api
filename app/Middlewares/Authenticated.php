<?php

namespace App\Middlewares;

use App\Helpers\AuthHelper;
use System\Contracts\Middleware;

class Authenticated implements Middleware
{
    public function handle(): void
    {
        $accessToken = AuthHelper::getAccessTokenFromHeader();

        if (is_null($accessToken) || !AuthHelper::validateAccessToken($accessToken)) {
            apiResponse(data: [
                'errors' => ['invalid-token']
            ], code: 401);
        }

        if (AuthHelper::tokenExpired($accessToken)) {
            apiResponse(data: [
                'errors' => ['token-expired']
            ], code: 401);
        }
    }
}