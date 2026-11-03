<?php

namespace App\Exceptions;

use Exception;

class SmsSendFailedException extends Exception
{
    public function __construct(string $message = 'ارسال پیامک با خطا مواجه شد.')
    {
        parent::__construct($message);
    }
}
