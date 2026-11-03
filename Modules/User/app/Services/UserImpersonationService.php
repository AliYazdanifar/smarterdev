<?php

namespace Modules\User\Services;

use Modules\User\Exceptions\InvalidImpersonationTokenException;
use Modules\User\Models\User;

class UserImpersonationService
{
    public function sessionTtlHours(): int
    {
        return 2;
    }

    public function consume(string $plainToken): User
    {
        throw new InvalidImpersonationTokenException;
    }
}
