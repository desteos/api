<?php

namespace App\Controllers;

use App\Helpers\AuthHelper;
use System\Response;

class BaseController
{
    public function __construct()
    {
        //auth middleware in future
        $accessToken = AuthHelper::getAccessTokenFromHeader();

        if (is_null($accessToken) || !AuthHelper::isValidToken($accessToken)) {
            Response::json([
                'errors' => ['invalid-token']
            ], 401);
        }

        if (AuthHelper::tokenExpired($accessToken)) {
            Response::json([
                'errors' => ['token-expired']
            ], 401);
        }
    }
}