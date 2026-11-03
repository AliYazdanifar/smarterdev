<?php

namespace Modules\User\Exceptions;

use Exception;

class InvalidImpersonationTokenException extends Exception
{
    public function __construct(string $message = 'توکن ورود نمایشی نامعتبر یا منقضی شده است.')
    {
        parent::__construct($message);
    }
}
