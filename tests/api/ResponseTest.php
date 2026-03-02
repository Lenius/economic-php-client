<?php

namespace Lenius\Economic\Tests;

use Lenius\Economic\API\Response;
use Lenius\Economic\RestClient;

class ResponseTest extends BaseTest
{
    /** @var RestClient */
    protected $client;

    public function setUp(): void
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

    public function testReturnOfResponseDataAsRawAndKeepAuthorization()
    {
        $response = $this->client->request->get('/units', ['demo' => 'true']);

        list($statusCode, $headers, $responseRaw) = $response->asRaw(true);

        $this->assertTrue(is_int($statusCode));
        $this->assertTrue(is_array($headers));
        $this->assertTrue(is_string($responseRaw));
        $this->assertContains('X-AppSecretToken:demo', preg_split("/\r\n|\n|\r/", $headers['sent']));
    }

    public function testReturnOfResponseDataAsArray()
    {
        $response = $this->client->request->get('/units', ['demo' => 'true']);

        $responseArray = $response->asArray();

        $this->assertTrue(is_array($responseArray));
    }

    public function testReturnOfResponseDataAsArrayAndJsonDecodeFails()
    {
        $response = $this->client->request->get('/units');

        $property = $this->getPrivateProperty('Lenius\Economic\API\Response', 'response_data');
        $property->setValue($response, 'test');

        $responseArray = $response->asArray();

        $this->assertCount(0, $responseArray);
    }

    public function testReturnOfResponseDataAsObjectAndJsonDecodeFails()
    {
        $response = $this->client->request->get('/units');

        $property = $this->getPrivateProperty('Lenius\Economic\API\Response', 'response_data');
        $property->setValue($response, 'test');

        $responseObject = $response->asObject();

        $this->assertCount(0, (array) $responseObject);
    }

    public function testReturnOfResponseDataAsString()
    {
        $response = $this->client->request->get('/units', ['demo' => 'true']);
        $this->assertTrue(is_string($response->asString()));
    }

    public function testSentHeaders()
    {
        $response = $this->client->request->get('/units', ['demo' => 'true']);
        $this->assertTrue(is_string($response->sentHeaders()));
    }

    public function testReceivedHeaders()
    {
        $response = $this->client->request->get('/units', ['demo' => 'true']);
        $this->assertTrue(is_string($response->receivedHeaders()));
    }

    public function testAuthorizationHeaderMasking()
    {
        $sentHeaders = "GET /units HTTP/1.1\nAuthorization: Basic dGVzdA==\nAccept: application/json\n";
        $response = new Response(200, $sentHeaders, '', '{}');

        list(, $headers,) = $response->asRaw(false);

        $lines = explode("\n", $headers['sent']);
        $this->assertContains('Authorization: <hidden by default>', $lines);
    }
}
