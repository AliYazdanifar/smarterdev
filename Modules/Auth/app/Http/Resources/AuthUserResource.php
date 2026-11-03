<?php

namespace Modules\Auth\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\User\Support\UserProfile;

class AuthUserResource extends JsonResource
{
    protected bool $isImpersonating = false;

    public function impersonating(bool $value = true): static
    {
        $this->isImpersonating = $value;

        return $this;
    }

    public function toArray(Request $request): array
    {
        $missing = $this->missingProfileFields();
        $profile = UserProfile::fromExtraData($this->extra_data);

        return [
            'id' => $this->id,
            'full_name' => $this->name,
            'username' => $this->username,
            'family' => $profile['lastname'] ?? null,
            'lastname' => $profile['lastname'] ?? null,
            'first_name' => $profile['firstname'] ?? $profile['first_name'] ?? null,
            'first_name_en' => $profile['firstname_en'] ?? null,
            'lastname_en' => $profile['lastname_en'] ?? null,
            'phone' => $this->phone,
            'phone2' => $profile['phone2'] ?? null,
            'email' => $this->email,
            'national_code' => $this->national_code,
            'province' => $profile['province'] ?? null,
            'city' => $profile['city'] ?? null,
            'bio' => $this->bio,
            'address' => $this->address,
            'profile' => $profile,
            'profile_image' => $this->profileImagePayload(),
            'phone_verified_at' => $this->phone_verified_at?->toIso8601String(),
            'is_active' => $this->is_active,

            'roles' => $this->getRoleNames()->values(),
            'performable_roles' => collect($this->getRoleNames())
                ->filter(fn (string $role) => $this->canPerformRole($role))
                ->values(),
            'permissions' => $this->getAllPermissions()
                ->pluck('name')
                ->values(),

            'level_id' => $this->level_id,
            'level' => $this->whenLoaded('level', fn () => $this->level ? [
                'id' => $this->level->id,
                'name' => $this->level->name,
                'slug' => $this->level->slug,
            ] : null),
            'has_character' => $this->hasCharacter(),
            'profile_complete' => $missing === [],
            'missing_profile_fields' => $missing,
            'is_impersonating' => $this->isImpersonating || $this->resource->isImpersonating(),
        ];
    }

    /**
     * @return array<int, string>
     */
    private function missingProfileFields(): array
    {
        $missing = [];

        if (! filled($this->name)) {
            $missing[] = 'name';
        }

        if (! $this->hasCharacter()) {
            $missing[] = 'character';
        }

        if ($this->level_id === null) {
            $missing[] = 'level';
        }

        return $missing;
    }

    private function hasCharacter(): bool
    {
        if ($this->relationLoaded('character')) {
            return $this->character !== null;
        }

        return $this->character()->exists();
    }
}
