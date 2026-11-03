<?php

namespace Tests\Unit;

use App\Services\SmsService;
use App\Support\Sms\SmsScenario;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class SmsServiceSendTest extends TestCase
{
    public function test_send_pattern_posts_to_ippanel_edge_api(): void
    {
        config([
            'auth.sms.base_url' => 'https://edge.ippanel.com/v1',
            'auth.sms.token' => 'test-token',
            'auth.sms.from' => '+983000505',
            'sms.patterns.otp' => 'pattern-code-123',
        ]);

        Http::fake([
            'https://edge.ippanel.com/v1/api/send' => Http::response([
                'data' => ['message_outbox_ids' => [1]],
                'meta' => ['status' => true, 'message' => 'انجام شد'],
            ]),
        ]);

        $service = new SmsService;
        $service->sendOtp('09121234567', '1234', SmsScenario::AuthOtpLogin);

        Http::assertSent(function ($request) {
            return $request->url() === 'https://edge.ippanel.com/v1/api/send'
                && $request['sending_type'] === 'pattern'
                && $request['code'] === 'pattern-code-123'
                && $request['recipients'] === ['+989121234567']
                && $request['params'] === ['code' => '1234']
                && $request->hasHeader('Authorization', 'test-token');
        });
    }
}
