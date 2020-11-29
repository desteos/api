<?php
namespace App\Controllers;

use App\Models\User;
use System\Request;
use System\Response;
use App\Services\AuthService;

class AuthController
{
    public function login(Request $request)
    {
        if(User::checkCredentials($request->post)){
//            $ew = setcookie('youpds', 'WE', [
//                'expires' => strtotime('+1 day'),
//                'path' => '/',
//                'httponly' => true,
//                'domain' => 'rest.test',
//                'SameSite' => 'Strict',
//            ]);
            Response::json([
                'accessToken' => 'uin54qp98wrhuinj2q90ewh8p9ruib'
            ]);
        }

        Response::json([], 422);
    }

    public function logout()
    {
        echo 'logout';
    }
}