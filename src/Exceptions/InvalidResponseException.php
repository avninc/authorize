<?php

namespace AVN\Authorize\Exceptions;

use Exception;

class InvalidResponseException extends Exception
{
    public function __construct($message = 'Invalid response from authorize.net') {}
}