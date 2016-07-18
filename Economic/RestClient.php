<?php
namespace Economic;

use Economic\API\Client;
use Economic\API\Request;


class RestClient
{
    /**
     * Contains the Economic_Request object
     *
     * @access public
     **/
    public $request;

    /**
     * __construct function.
     *
     * Instantiates the main class.
     * Creates a client which is passed to the request construct.
     *
     * @auth_string string Authentication string for Economic
     *
     * @access public
     * @param string $secret_token
     * @param string $grant_token
     */
    public function __construct($secret_token = '', $grant_token = '')
    {
        $client = new Client($secret_token, $grant_token);
        $this->request = new Request($client);
    }
}
