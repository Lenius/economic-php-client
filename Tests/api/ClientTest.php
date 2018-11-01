<?php

namespace Lenius\Economic\Tests;

use Lenius\Economic\API\Client;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
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
