<?php

namespace Tests;

use Mockery;
use System\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{

    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testHandle()
    {
        //create fake route config
        //create router
        //mock request
        //assert
    }

    public function testGetToShow()
    {

    }

    public function testGetToIndex()
    {

    }

    public function testPostToStore()
    {

    }

    public function testPutToUpdate()
    {

    }

    public function testDeleteToDestroy()
    {

    }

    public function testDeleteToDestroyAll()
    {

    }
}
