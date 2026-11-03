<?php

namespace Modules\User\Support;

class UserProfile
{
    /**
     * @param  array<string, mixed>|null  $extra
     * @return array<string, mixed>
     */
    public static function fromExtraData(mixed $extra): array
    {
        if (! is_array($extra)) {
            return [];
        }

        return $extra;
    }

    /**
     * @param  array<string, mixed>  $fields
     * @return array<string, mixed>
     */
    public static function buildExtraData(array $fields): array
    {
        return array_filter($fields, fn ($value) => $value !== null && $value !== '');
    }
}
