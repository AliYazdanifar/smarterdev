<?php

namespace Modules\Reporting\Services;

use Modules\User\Models\User;

class AudienceAttributionRecorder
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function recordFirstTouchForUser(User $user, array $data): void
    {
        if ($data === []) {
            return;
        }

        $extra = is_array($user->extra_data) ? $user->extra_data : [];
        if (isset($extra['acquisition'])) {
            return;
        }

        $extra['acquisition'] = array_filter([
            'channel' => $data['acquisition_channel'] ?? null,
            'campaign' => $data['acquisition_campaign'] ?? null,
            'utm_source' => $data['utm_source'] ?? null,
            'utm_campaign' => $data['utm_campaign'] ?? null,
            'recorded_at' => now()->toIso8601String(),
        ]);

        $user->forceFill(['extra_data' => $extra])->save();
    }
}
