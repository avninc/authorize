<?php

namespace AVN\Authorize\Exceptions;

use Exception;

class MissingPaymentInformationException extends Exception
{
    public function __construct($message = 'Payment information is missing') {}
}