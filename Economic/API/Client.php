<?php
namespace Economic\API;

/**
 * @class       Economic_Client
 */
class Client
{
    /**
     * Contains cURL instance
     *
     * @access public
     */
    public $ch;

    /**
     * Contains the authentication string
     *
     * @access protected
     */
    protected $secret_token;

    protected $grant_token;

    /**
     * __construct function.
     *
     * Instantiate object
     *
     * @access public
     */
    public function __construct($secret_token = '',$grant_token = '')
    {
        // Check if lib cURL is enabled
        if (!function_exists('curl_init')) {
            throw new Exception('Lib cURL must be enabled on the server');
        }

        // Set auth string property
        $this->secret_token = $secret_token;
        $this->grant_token = $grant_token;

        // Instantiate cURL object
        $this->authenticate();
    }

    /**
     * Shutdown function.
     *
     * Closes the current cURL connection
     *
     * @access public
     */
    public function shutdown()
    {
        if (!empty($this->ch)) {
            curl_close($this->ch);
        }
    }

    /**
     * authenticate function.
     *
     * Create a cURL instance with authentication headers
     *
     * @access public
     */
    protected function authenticate()
    {
        $this->ch = curl_init();

        $headers = array(
            'Accept: application/json',
        );

        if (!empty($this->secret_token)) {
            $headers[] = 'X-AppSecretToken:' . $this->secret_token;
        }

        if (!empty($this->grant_token)) {
            $headers[] = 'X-AgreementGrantToken:' . $this->grant_token;
        }

        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
            CURLOPT_HTTPHEADER => $headers
        );

        curl_setopt_array($this->ch, $options);
    }
}
