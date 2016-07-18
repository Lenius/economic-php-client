<?php
namespace Economic\Tests;

use Economic\API\Client;
use Economic\API\Request;
use Economic\API\Response;


class RequestTest extends \PHPUnit_Framework_TestCase
{
    protected $request;

    public function setUp()
    {
        $client = new Client('demo','demo');
        $this->request = new Request($client);
    }

    public function testResponseInstance()
    {
        $getResponse = $this->request->get('/');
        $this->assertTrue(($getResponse instanceof Response));
    }
    
}
