<?php

namespace Modules\Reporting\Support;

class AudienceAcquisitionChannel
{
    /**
     * @return array<int, string>
     */
    public static function values(): array
    {
        return [
            'organic',
            'referral',
            'paid',
            'social',
            'direct',
            'other',
        ];
    }
}
