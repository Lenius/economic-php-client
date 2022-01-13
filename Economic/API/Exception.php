<?php

namespace Lenius\Economic\API;

/**
 * @class       Economic_Exception
 */
class Exception extends \Exception
{
    /**
     * __Construct function.
     *
     * Redefine the exception so message isn't optional
     *
     * @param string $message
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct($message, $code = 0, self $previous = null)
    {
        // Make sure everything is assigned properly
        parent::__construct($message, $code, $previous);
    }
}
