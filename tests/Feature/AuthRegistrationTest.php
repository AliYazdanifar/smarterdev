<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Modules\Auth\Models\OtpCode;
use Modules\User\Models\User;
use Tests\TestCase;

class AuthRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_sends_otp_and_verify_issues_token(): void
    {
        config([
            'auth.sms.base_url' => 'https://edge.ippanel.com/v1',
            'auth.sms.token' => 'test-token',
            'auth.sms.from' => '+983000505',
            'sms.patterns.otp' => 'otp-pattern',
        ]);

        Http::fake([
            'https://edge.ippanel.com/v1/api/send' => Http::response([
                'data' => ['message_outbox_ids' => [1]],
                'meta' => ['status' => true],
            ]),
        ]);

        $register = $this->postJson('/api/v1/auth/register', [
            'first_name' => 'علی',
            'last_name' => 'رضایی',
            'phone' => '09121234567',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $register->assertCreated()
            ->assertJsonPath('success', true);

        $otp = OtpCode::query()->where('receiver', '09121234567')->first();
        $this->assertNotNull($otp);

        $verify = $this->postJson('/api/v1/auth/verify-otp', [
            'phone' => '09121234567',
            'code' => $otp->code,
        ]);

        $verify->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonStructure(['data' => ['token', 'user' => ['id', 'phone']]]);

        $user = User::query()->where('phone', '09121234567')->first();
        $this->assertNotNull($user->phone_verified_at);
    }
}
