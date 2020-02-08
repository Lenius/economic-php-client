<?php

namespace Lenius\Economic\API;

/**
 * @class       Economic_Client
 */
class Client
{
    /**
     * Contains cURL instance.
     *
     * @var resource
     */
    public $ch;

    /**
     * Contains the authentication string.
     *
     * @var string
     */
    protected $secret_token;

    /**
     * @var string
     */
    protected $grant_token;

    /**
     * __construct function.
     *
     * Instantiate object
     *
     * @param string $secret_token
     * @param string $grant_token
     *
     * @throws Exception
     */
    public function __construct($secret_token = '', $grant_token = '')
    {
        // @codeCoverageIgnoreStart
        if (!function_exists('curl_init')) {
            throw new Exception('Lib cURL must be enabled on the server');
        }
        // @codeCoverageIgnoreEnd

        if (empty($secret_token)) {
            throw new Exception('secret token is missing');
        }

        if (empty($grant_token)) {
            throw new Exception('grant token is missing');
        }

        // Set auth string property
        $this->secret_token = $secret_token;
        $this->grant_token = $grant_token;
    }

    /**
     * Shutdown function.
     *
     * Closes the current cURL connection
     */
    public function shutdown()
    {
        if (!empty($this->ch)) {
            curl_close($this->ch);
            $this->ch = null;
        }
    }

    /**
     * Create function.
     *
     * Create cURL connection with authentication
     */
    public function create()
    {
        // @codeCoverageIgnoreStart
        if (!empty($this->ch)) {
            curl_close($this->ch);
        }
        // @codeCoverageIgnoreEnd

        // Instantiate cURL object
        $this->ch = curl_init();

        // Apply authentication headers
        $this->authenticate();
    }

    /**
     * authenticate function.
     *
     * Create authentication headers
     */
    protected function authenticate()
    {
        $headers = [
            'Accept: application/json',
            'Content-Type: application/json; charset=utf-8',
        ];

        if (!empty($this->secret_token)) {
            $headers[] = 'X-AppSecretToken:'.$this->secret_token;
        }

        if (!empty($this->grant_token)) {
            $headers[] = 'X-AgreementGrantToken:'.$this->grant_token;
        }

        //default headers
        $options = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_HTTPAUTH       => CURLAUTH_BASIC,
            CURLOPT_HTTPHEADER     => $headers,
        ];

        curl_setopt_array($this->ch, $options);
    }
}
