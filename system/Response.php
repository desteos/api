<?php

namespace System;

class Response
{
    public static function json($data, int $code = 200):void
    {
//        $response = [
//            'data' => $data,
//            'status' => $code
//        ];

        header('Content-Type: application/json');
        http_response_code($code);
        echo json_encode($data);
        exit();
    }
}
