<?php

namespace Modules\Auth\Exceptions;

use Exception;

class InvalidOtpException extends Exception
{
    public function __construct(string $message = 'کد تایید نامعتبر یا منقضی شده است.')
    {
        parent::__construct($message);
    }
}
