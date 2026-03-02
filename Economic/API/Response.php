<?php

namespace Lenius\Economic\API;

/**
 * @class      Economic_Response
 */
class Response
{
    /**
     * HTTP status code of request.
     *
     * @var int
     */
    protected int $status_code;

    /**
     * The headers sent during the request.
     *
     * @var string
     */
    protected $sent_headers;

    protected string|false $received_headers;

    /**
     * Response body of last request.
     *
     * @var string
     */
    protected string $response_data;

    /**
     * Response constructor.
     *
     * @param int         $status_code
     * @param string      $sent_headers
     * @param string|false  $received_headers
     * @param string      $response_data
     */
    public function __construct(int $status_code, string $sent_headers, string|false $received_headers, string $response_data)
    {
        $this->status_code = $status_code;
        $this->sent_headers = $sent_headers;
        $this->received_headers = $received_headers;
        $this->response_data = $response_data;
    }

    /**
     * @param bool $keep_authorization_value
     *
     * @return array
     */
    public function asRaw(bool $keep_authorization_value = false)
    {
        // To avoid unintentional logging of credentials the default is to mask the value of the Authorization: header
        if ($keep_authorization_value) {
            $sent_headers = $this->sent_headers;
        } else {
            // Avoid dependency on mbstring
            $lines = explode("\n", $this->sent_headers);
            foreach ($lines as &$line) {
                if (strpos($line, 'Authorization: ') === 0) {
                    $line = 'Authorization: <hidden by default>';
                }
            }
            $sent_headers = implode("\n", $lines);
        }

        return [
            $this->status_code,
            [
                'sent'     => $sent_headers,
                'received' => $this->received_headers,
            ],
            $this->response_data,
        ];
    }

    /**
     * asArray.
     *
     * Returns the response body as an array
     *
     * @return array
     */
    public function asArray(): array
    {
        $response = json_decode((string) $this->response_data, true);
        if (is_array($response)) {
            return $response;
        }

        return [];
    }

    /**
     * asObject.
     *
     * Returns the response body as an array
     *
     * @return \stdClass
     */
    public function asObject(): \stdClass
    {
        $response = json_decode((string) $this->response_data);
        if ($response instanceof \stdClass) {
            return $response;
        }

        return new \stdClass();
    }

    /**
     * asObject.
     *
     * Returns the response body as string
     *
     * @return string
     */
    public function asString(): string
    {
        return (string) $this->response_data;
    }

    /**
     * httpStatus.
     *
     * Returns the http_status code
     *
     * @return int
     */
    public function httpStatus(): int
    {
        return $this->status_code;
    }


    /**
     * sentHeaders.
     *
     * Returns the sent_headers
     *
     * @return string
     */
    public function sentHeaders(): string
    {
        return $this->sent_headers;
    }


    /**
     * receivedHeaders.
     *
     * Returns the received_headers
     *
     * @return string|false
     */
    public function receivedHeaders(): string|false
    {
        return $this->received_headers;
    }

    /**
     * isSuccess.
     *
     * Checks if the http status code indicates a succesful or an error response.
     *
     * @return bool
     */
    public function isSuccess()
    {
        if ($this->status_code > 299) {
            return false;
        }

        return true;
    }
}
