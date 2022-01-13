<?php

namespace Lenius\Economic\Tests;

use InvalidArgumentException;
use Lenius\Economic\API\Client;
use Lenius\Economic\API\Request;
use Lenius\Economic\API\Response;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    /** @var Request */
    protected $request;

    public function setUp(): void
    {
        $client = new Client('demo', 'demo');
        $this->request = new Request($client);
    }

    public function testMissingGetPath()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->request->get('');
    }

    public function testGetPath()
    {
        $getResponse = $this->request->get('units?demo=demo', ['limit' => 10]);
        $this->assertTrue(($getResponse instanceof Response));
    }

    public function testMissingPostPath()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->request->post('');
    }

    public function testMissingPutPath()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->request->put('');
    }

    public function testMissingPatchPath()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->request->patch('');
    }

    public function testMissingDeletePath()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->request->delete('');
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

        $response = $request->get('/units', ['demo' => 'true']);

        $this->assertEquals(401, $response->httpStatus());
    }

    public function testSuccessfullGetResponse()
    {
        $response = $this->request->get('/units', ['demo' => 'true']);

        $this->assertTrue($response->isSuccess());
    }

    public function testFailedGetResponse()
    {
        $pingResponse = $this->request->get('/notfound');

        $this->assertFalse($pingResponse->isSuccess());
    }
}
