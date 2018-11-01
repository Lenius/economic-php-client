<?php

namespace Lenius\Economic\Tests;

use Lenius\Economic\RestClient;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    /** @var RestClient */
    protected $client;

    public function setUp()
    {
        $this->client = new RestClient('demo', 'demo');
    }

    public function testReturnOfResponseDataAsObject()
    {
        $response = $this->client->request->get('/units', ['demo' => 'true']);

        $responseObject = $response->asObject();

        $this->assertTrue(is_object($responseObject));
    }

    public function testReturnOfEmptyResponseDataAsObject()
    {
        $response = $this->client->request->get('/units', ['demo' => 'true']);

        $responseObject = $response->asObject();

        $this->assertTrue(is_object($responseObject));
    }

    public function testReturnOfResponseDataAsRaw()
    {
        $response = $this->client->request->get('/units', ['demo' => 'true']);

        list($statusCode, $headers, $responseRaw) = $response->asRaw();

        $this->assertTrue(is_int($statusCode));
        $this->assertTrue(is_array($headers));
        $this->assertTrue(is_string($responseRaw));
    }

    public function testReturnOfResponseDataAsArray()
    {
        $response = $this->client->request->get('/units', ['demo' => 'true']);

        $responseArray = $response->asArray();

        $this->assertTrue(is_array($responseArray));
    }
}
