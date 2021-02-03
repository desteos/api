<?php

namespace App\Middlewares;

use App\Helpers\AuthHelper;

class Authenticated
{
    public function handle()
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