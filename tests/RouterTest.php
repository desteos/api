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
            'GET|articles/([0-9]+)' => 'ArticleController/show/$1',
            'GET|articles' => 'ArticleController/index',
            'PUT|articles/([0-9]+)' => 'ArticleController/update/$1',
            'POST|articles' => 'ArticleController/store',
            'DELETE|articles/([0-9]+)' => 'ArticleController/destroy/$1',
            'DELETE|articles' => 'ArticleController/destroyAll',
        ];
    }

    protected function tearDown(): void
    {
        $this->routes = null;
        Mockery::close();
    }

    public function testHandle()
    {
        $router = new Router($this->routes);
        $router->handle();
        //mock request
        //assert
    }
}
