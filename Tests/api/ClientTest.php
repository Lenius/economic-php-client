<?php

namespace Lenius\Economic\Tests;

use Lenius\Economic\API\Client;

class ClientTest extends BaseTest
{
    /** @var Client */
    protected $client;

    /**
     * @expectedException \Exception
     */
    public function testMissingSecretToken()
    {
        $this->client = new Client('', 'demo');
    }

    /**
     * @expectedException \Exception
     */
    public function testMissingGrantToken()
    {
        $this->client = new Client('demo', '');
    }
}
