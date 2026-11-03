<?php

namespace App\Services;

use App\Exceptions\SmsSendFailedException;
use App\Support\Sms\SmsScenario;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class SmsService
{
    public function sendOtp(string $phone, string $code, SmsScenario $scenario = SmsScenario::AuthOtpLogin): void
    {
        $patternCode = $this->patternCodeFor($scenario);

        $this->sendPattern(
            patternCode: $patternCode,
            recipient: $phone,
            params: ['code' => $code],
        );
    }

    /**
     * @param  array<string, string>  $params
     */
    public function sendScenario(SmsScenario $scenario, string $phone, array $params = []): void
    {
        $patternCode = $this->patternCodeFor($scenario);

        if ($patternCode === '') {
            if ($this->shouldSkipWhenUnconfigured()) {
                Log::info('SMS pattern not configured; skipping send.', [
                    'scenario' => $scenario->value,
                    'phone' => $phone,
                ]);

                return;
            }

            throw new SmsSendFailedException('الگوی پیامک برای این سناریو پیکربندی نشده است.');
        }

        $this->sendPattern(
            patternCode: $patternCode,
            recipient: $phone,
            params: $params,
        );
    }

    /**
     * @param  array<string, string>  $params
     */
    public function sendPattern(string $patternCode, string $recipient, array $params): void
    {
        if ($patternCode === '') {
            if ($this->shouldSkipWhenUnconfigured()) {
                Log::info('SMS pattern send skipped (not configured).', [
                    'recipient' => $recipient,
                    'params' => $params,
                ]);

                return;
            }

            throw new SmsSendFailedException('کد الگوی پیامک تنظیم نشده است.');
        }

        if ($this->shouldSkipWhenUnconfigured()) {
            Log::info('SMS send skipped (provider not configured).', [
                'recipient' => $recipient,
                'pattern' => $patternCode,
                'params' => $params,
            ]);

            return;
        }

        $baseUrl = rtrim((string) config('auth.sms.base_url'), '/');
        $token = (string) config('auth.sms.token');
        $from = (string) config('auth.sms.from');

        if ($baseUrl === '' || $token === '' || $from === '') {
            throw new SmsSendFailedException('تنظیمات سرویس پیامک ناقص است.');
        }

        $payload = [
            'sending_type' => 'pattern',
            'from_number' => $this->normalizeSender($from),
            'code' => $patternCode,
            'recipients' => [$this->normalizeRecipient($recipient)],
            'params' => $params,
        ];

        try {
            $response = Http::withHeaders([
                'Authorization' => $token,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])
                ->timeout(15)
                ->post("{$baseUrl}/api/send", $payload)
                ->throw();
        } catch (RequestException $e) {
            Log::warning('IPPanel SMS request failed.', [
                'status' => $e->response?->status(),
                'body' => $e->response?->json(),
            ]);

            throw new SmsSendFailedException('ارسال پیامک ناموفق بود. لطفاً دوباره تلاش کنید.');
        }

        $body = $response->json();
        $status = data_get($body, 'meta.status');

        if ($status !== true && $status !== 1 && $status !== '1') {
            Log::warning('IPPanel SMS rejected.', ['response' => $body]);

            throw new SmsSendFailedException(
                (string) data_get($body, 'meta.message', 'ارسال پیامک ناموفق بود.')
            );
        }
    }

    public function normalizeRecipient(string $phone): string
    {
        $trimmed = trim($phone);

        if (str_starts_with($trimmed, '+') && preg_match('/^\+\d{10,15}$/', $trimmed)) {
            return $trimmed;
        }

        $digits = preg_replace('/\D/', '', $trimmed) ?? '';

        if (str_starts_with($digits, '98') && strlen($digits) === 12) {
            return '+'.$digits;
        }

        if (str_starts_with($digits, '09') && strlen($digits) === 11) {
            return '+98'.substr($digits, 1);
        }

        if (str_starts_with($digits, '9') && strlen($digits) === 10) {
            return '+98'.$digits;
        }

        throw new InvalidArgumentException('شماره گیرنده معتبر نیست.');
    }

    private function normalizeSender(string $from): string
    {
        $from = trim($from);

        if (str_starts_with($from, '+')) {
            return $from;
        }

        return $this->normalizeRecipient($from);
    }

    private function patternCodeFor(SmsScenario $scenario): string
    {
        $key = $scenario->patternConfigKey();

        return (string) config("sms.patterns.{$key}", '');
    }

    private function shouldSkipWhenUnconfigured(): bool
    {
        if (! app()->environment(['local', 'testing'])) {
            return false;
        }

        return ! $this->isConfigured();
    }

    private function isConfigured(): bool
    {
        return filled(config('auth.sms.base_url'))
            && filled(config('auth.sms.token'))
            && filled(config('auth.sms.from'));
    }
}
