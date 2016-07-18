<?php

namespace Economic\Tests;

use Economic\API\Request;
use Economic\API\Response;
use Economic\RestClient;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    protected $request;

    public function setUp()
    {
        $client = new RestClient('demo','demo');
        $this->request = new Request($client);
    }

    public function testResponseInstance()
    {
        $pingResponse = $this->request->get('/');

        $this->assertTrue(($pingResponse instanceof Response));
    }
    
}
