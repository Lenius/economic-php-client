<?php

namespace Lenius\Economic\Tests;

use Lenius\Economic\API\Client;

class ClientTest extends BaseTest
{
    /** @var Client */
    protected $client;

    public function testMissingSecretToken()
    {
        $this->expectException(\Exception::class);
        $this->client = new Client('', 'demo');
    }

    public function testMissingGrantToken()
    {
        $this->expectException(\Exception::class);
        $this->client = new Client('demo', '');
    }
}
