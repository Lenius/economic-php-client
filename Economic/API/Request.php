<?php

namespace Lenius\Economic\API;

/**
 * @class      Economic_Request
 */
class Request
{
    /**
     * Contains Economic_Client instance.
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
     * @param array $query
     *
     * @return Response
     * 
     * @throws Exception
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

        // Set the request params
        $this->setUrl($path);

        // Start the request and return the response
        return $this->execute('GET');
    }

    /**
     * POST function.
     *
     * Performs an API POST request
     *
     * @param string $path
     * @param array $form
     * 
     * @return Response
     * 
     * @throws Exception
     */
    public function post($path, $form = [])
    {
        // Set the request params
        $this->setUrl($path);

        // Start the request and return the response
        return $this->execute('POST', $form);
    }

    /**
     * PUT function.
     *
     * Performs an API PUT request
     *
     * @param string $path
     * @param array $form
     * 
     * @return Response
     * 
     * @throws Exception
     */
    public function put($path, $form = [])
    {
        // Set the request params
        $this->setUrl($path);

        // Start the request and return the response
        return $this->execute('PUT', $form);
    }

    /**
     * PATCH function.
     *
     * Performs an API PATCH request
     *
     * @param string $path
     * @param array $form
     * 
     * @return Response
     * 
     * @throws Exception
     */
    public function patch($path, $form = [])
    {
        // Set the request params
        $this->setUrl($path);

        // Start the request and return the response
        return $this->execute('PATCH', $form);
    }

    /**
     * DELETE function.
     *
     * Performs an API DELETE request
     *
     * @param string $path
     * @param array $form
     *
     * @return Response
     * 
     * @throws Exception
     */
    public function delete($path, $form = [])
    {
        // Set the request params
        $this->setUrl($path);

        // Start the request and return the response
        return $this->execute('DELETE', $form);
    }

    /**
     * setUrl function.
     *
     * Takes an API request string and appends it to the API url
     *
     * @param string $path
     *
     * @return void
     */
    protected function setUrl($path)
    {
        curl_setopt($this->client->ch, CURLOPT_URL, Constants::API_URL.trim($path, '/'));
    }

    /**
     * @param $request_type
     * @param array $form
     *
     * @throws Exception
     *
     * @return Response
     */
    protected function execute($request_type, $form = [])
    {
        // Set the HTTP request type
        curl_setopt($this->client->ch, CURLOPT_CUSTOMREQUEST, $request_type);

        // If additional data is delivered, we will send it along with the API request
        if (is_array($form) && !empty($form)) {
            $post = json_encode($form);
            curl_setopt($this->client->ch, CURLOPT_POSTFIELDS, $post);
        }

        // Store received headers in temporary memory file, remember sent headers
        $fh_header = fopen('php://temp', 'w+');
        curl_setopt($this->client->ch, CURLOPT_WRITEHEADER, $fh_header);
        curl_setopt($this->client->ch, CURLINFO_HEADER_OUT, true);

        // Execute the request
        $response_data = curl_exec($this->client->ch);

        if (curl_errno($this->client->ch) !== 0) {
            // An error occurred
            fclose($fh_header);
            throw new Exception(curl_error($this->client->ch), curl_errno($this->client->ch));
        }

        // Grab the headers
        $sent_headers = curl_getinfo($this->client->ch, CURLINFO_HEADER_OUT);
        rewind($fh_header);
        $received_headers = stream_get_contents($fh_header);
        fclose($fh_header);

        // Retrieve the HTTP response code
        $response_code = (int) curl_getinfo($this->client->ch, CURLINFO_HTTP_CODE);

        // Return the response object.
        return new Response($response_code, $sent_headers, $received_headers, $response_data);
    }
}
