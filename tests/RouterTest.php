<?php

namespace Tests;

use Mockery;
use System\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    private $routes;

    protected function setUp(): void
    {
        $this->routes = [
            'GET|tests/([0-9]+)' => 'TestController/show/$1',
            'GET|tests' => 'TestController/index',
            'PUT|tests/([0-9]+)' => 'TestController/update/$1',
            'POST|tests' => 'TestController/store',
            'DELETE|tests/([0-9]+)' => 'TestController/destroy/$1',
            'DELETE|tests' => 'TestController/destroyAll',
        ];
    }

    protected function tearDown(): void
    {
        $this->routes = null;
        Mockery::close();
    }

    public function testHandle()
    {

    }
}
