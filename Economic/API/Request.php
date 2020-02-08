<?php

namespace Lenius\Economic\API;

/**
 * @class      Economic_Request
 */
class Request
{
    /**
     * Contains Economic_Client instance.
     *
     * @var Client
     */
    protected $client;

    /**
     * __construct function.
     *
     * Instantiates the object
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * GET function.
     *
     * Performs an API GET request
     *
     * @param string $path
     * @param array  $query
     *
     * @throws Exception
     *
     * @return Response
     */
    public function get($path, $query = [])
    {
        // Add query parameters to $path?
        if (!empty($query)) {
            if (strpos($path, '?') === false) {
                $path .= '?'.http_build_query($query, '', '&');
            } else {
                $path .= ini_get('arg_separator.output').http_build_query($query, '', '&');
            }
        }

        // Start the request and return the response
        return $this->execute('GET', $path);
    }

    /**
     * POST function.
     *
     * Performs an API POST request
     *
     * @param string $path
     * @param array  $form
     *
     * @throws Exception
     *
     * @return Response
     */
    public function post($path, $form = [])
    {
        // Start the request and return the response
        return $this->execute('POST', $path, $form);
    }

    /**
     * PUT function.
     *
     * Performs an API PUT request
     *
     * @param string $path
     * @param array  $form
     *
     * @throws Exception
     *
     * @return Response
     */
    public function put($path, $form = [])
    {
        // Start the request and return the response
        return $this->execute('PUT', $path, $form);
    }

    /**
     * PATCH function.
     *
     * Performs an API PATCH request
     *
     * @param string $path
     * @param array  $form
     *
     * @throws Exception
     *
     * @return Response
     */
    public function patch($path, $form = [])
    {
        // Start the request and return the response
        return $this->execute('PATCH', $path, $form);
    }

    /**
     * DELETE function.
     *
     * Performs an API DELETE request
     *
     * @param string $path
     * @param array  $form
     *
     * @throws Exception
     *
     * @return Response
     */
    public function delete($path, $form = [])
    {
        // Start the request and return the response
        return $this->execute('DELETE', $path, $form);
    }

    /**
     * @param string $request_type
     * @param array  $form
     * @param string $path
     *
     * @throws Exception
     *
     * @return Response
     */
    protected function execute($request_type, $path, $form = [])
    {
        // Store received headers in temporary memory file, remember sent headers
        if (!$path) {
            throw new \InvalidArgumentException('Path is missing');
        }

        // Init client
        $this->client->create();

        // Set the request path
        curl_setopt($this->client->ch, CURLOPT_URL, Constants::API_URL.trim($path, '/'));

        // Set the HTTP request type
        curl_setopt($this->client->ch, CURLOPT_CUSTOMREQUEST, $request_type);

        // If additional data is delivered, we will send it along with the API request
        if (is_array($form) && !empty($form)) {
            $post = json_encode($form);
            curl_setopt($this->client->ch, CURLOPT_POSTFIELDS, $post);
        }

        // @codeCoverageIgnoreStart
        // Store received headers in temporary memory file, remember sent headers
        if (!$fh_header = fopen('php://temp', 'w+')) {
            throw new Exception('Fail to create tmp');
        }
        // @codeCoverageIgnoreEnd

        curl_setopt($this->client->ch, CURLOPT_WRITEHEADER, $fh_header);
        curl_setopt($this->client->ch, CURLINFO_HEADER_OUT, true);

        // Execute the request
        $response_data = curl_exec($this->client->ch);

        // @codeCoverageIgnoreStart
        if (curl_errno($this->client->ch) !== 0) {
            // An error occurred
            fclose($fh_header);

            throw new Exception(curl_error($this->client->ch), curl_errno($this->client->ch));
        }
        // @codeCoverageIgnoreEnd

        // Grab the headers
        $sent_headers = curl_getinfo($this->client->ch, CURLINFO_HEADER_OUT);
        rewind($fh_header);
        $received_headers = stream_get_contents($fh_header);
        fclose($fh_header);

        // Retrieve the HTTP response code
        $response_code = (int) curl_getinfo($this->client->ch, CURLINFO_HTTP_CODE);

        // Shutdown client
        $this->client->shutdown();

        // Return the response object.
        return new Response($response_code, $sent_headers, $received_headers, $response_data);
    }
}
