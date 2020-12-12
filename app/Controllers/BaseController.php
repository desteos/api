<?php

namespace App\Controllers;

use App\Helpers\AuthHelper;

class BaseController
{
    public function __construct()
    {
        //auth middleware in future
        $accessToken = AuthHelper::getAccessTokenFromHeader();

        if (is_null($accessToken) || !AuthHelper::isValidToken($accessToken)) {
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