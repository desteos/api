<?php

namespace App\Controllers;

use App\Helpers\AuthHelper;
use System\Response;

class BaseController
{
    public function __construct()
    {
        if (!empty($_POST['accessToken'])) {
            if (!AuthHelper::checkAccessToken($_POST['accessToken'])) {
                //todo auth headers
                Response::json('dsd', 401);
            }
        } else {
            //todo auth headers
            Response::json(array(), 401);
        }
    }

    //todo call magic method role check access
}