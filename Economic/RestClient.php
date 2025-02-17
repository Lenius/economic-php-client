<?php

namespace Lenius\Economic;

use Lenius\Economic\API\Client;
use Lenius\Economic\API\Request;

class RestClient
{
    /**
     * Contains the Economic_Request object.
     *
     * @var Request
     **/
    public Request $request;

    /**
     * __construct function.
     *
     * Instantiates the main class.
     * Creates a client which is passed to the request construct.
     *
     * @auth_string string Authentication string for Economic
     *
     * @param string $secret_token
     * @param string $grant_token
     *
     * @throws API\Exception
     */
    public function __construct(string $secret_token = '', string $grant_token = '', string $base_url)
    {
        $client = new Client($secret_token, $grant_token, $base_url);
        $this->request = new Request($client);
    }
}
