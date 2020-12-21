<?php

namespace System;

class Kernel
{
    public function init()
    {
        $router = new Router(config('routes'));
        $router->handle(new Request());
    }
}