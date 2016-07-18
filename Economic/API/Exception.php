<?php
namespace Economic\API;

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
     * @access public
     */
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        // Make sure everything is assigned properly
        parent::__construct($message, $code, $previous);
    }
}
