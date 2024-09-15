<?php

namespace Lenius\Economic\API;

/**
 * @class       Economic_Client
 */
class Client
{
    /**
     * Contains cURL instance.
     * @var resource|false
     */
    public $ch;

    /**
     * Contains the authentication string.
     *
     * @var string
     */
    protected string $secret_token;

    /**
     * @var string
     */
    protected string $grant_token;

    /**
     * @var string
     */
    protected string $base_url;

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
    public function __construct(string $secret_token = '', string $grant_token = '', string $base_url = '')
    {
        // @codeCoverageIgnoreStart
        if (! function_exists('curl_init')) {
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
        if (empty($base_url)) {
          $this->base_url = Constants::API_URL;
        } else {
          $this->base_url = $base_url;
        }
    }

    /**
     * Shutdown function.
     *
     * Closes the current cURL connection
     */
    public function shutdown(): void
    {
        if (! empty($this->ch)) {
            curl_close($this->ch);
            $this->ch = false;
        }
    }

    /**
     * Create function.
     *
     * Create cURL connection with authentication
     */
    public function create(): void
    {
        // @codeCoverageIgnoreStart
        if (! empty($this->ch)) {
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
    protected function authenticate(): void
    {
        $headers = [
            'Accept: application/json',
            'Content-Type: application/json; charset=utf-8',
        ];

        if (! empty($this->secret_token)) {
            $headers[] = 'X-AppSecretToken:'.$this->secret_token;
        }

        if (! empty($this->grant_token)) {
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

  public function getUrl() {
    return $this->base_url;
  }

}
