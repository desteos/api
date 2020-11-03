<?php

namespace System;

class Response
{
    public static function json($data):void
    {
        header('Content-Type: application/json');
        echo json_encode($data);

        exit();
    }
}
