<?php

namespace Tests\Unit;

use App\Services\SmsService;
use InvalidArgumentException;
use Tests\TestCase;

class SmsServiceTest extends TestCase
{
    public function test_normalizes_iranian_mobile_to_e164(): void
    {
        $service = new SmsService;

        $this->assertSame('+989121234567', $service->normalizeRecipient('09121234567'));
        $this->assertSame('+989121234567', $service->normalizeRecipient('+989121234567'));
    }

    public function test_rejects_invalid_mobile(): void
    {
        $service = new SmsService;

        $this->expectException(InvalidArgumentException::class);
        $service->normalizeRecipient('12345');
    }
}
