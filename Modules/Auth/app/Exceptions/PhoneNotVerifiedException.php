<?php

namespace Modules\Auth\Exceptions;

use Exception;

class PhoneNotVerifiedException extends Exception
{
    public function __construct(string $message = 'شماره همراه تایید نشده است.')
    {
        parent::__construct($message);
    }
}
