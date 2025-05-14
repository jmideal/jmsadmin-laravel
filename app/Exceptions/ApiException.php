<?php

namespace App\Exceptions;

use Throwable;
class ApiException extends \RuntimeException
{
    public function __construct($message, $code = 500, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
