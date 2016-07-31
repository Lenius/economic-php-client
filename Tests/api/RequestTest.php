<?php

namespace Lenius\Economic\Tests;

use Lenius\Economic\API\Client;
use Lenius\Economic\API\Request;
use Lenius\Economic\API\Response;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    protected $request;

    public function setUp()
    {
        $client = new Client('demo', 'demo');
        $this->request = new Request($client);
    }

    public function testResponseInstance()
    {
        $getResponse = $this->request->get('/');
        $this->assertTrue(($getResponse instanceof Response));
    }

    public function testBadAuthentication()
    {
        $client = new Client('foo', 'foo');
        $request = new Request($client);

        $response = $request->get('/apps');

        $this->assertEquals(401, $response->httpStatus());
    }

    public function testSuccessfulGetResponse()
    {
        $pingResponse = $this->request->get('/apps');

        $this->assertTrue($pingResponse->isSuccess());
    }

    public function testFailedGetResponse()
    {
        $pingResponse = $this->request->get('/notfound');

        $this->assertFalse($pingResponse->isSuccess());
    }
}
