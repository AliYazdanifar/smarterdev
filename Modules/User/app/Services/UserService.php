<?php

namespace Modules\User\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\User\Models\User;
use Modules\User\Support\UserProfile;
use Spatie\Permission\Models\Role;

class UserService
{
    /**
     * @param  array{
     *     first_name?: string,
     *     last_name?: string,
     *     lastname?: string,
     *     phone: string,
     *     email?: string|null,
     *     password: string,
     *     roles?: array<int, string>
     * }  $data
     */
    public function create(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $firstName = trim((string) ($data['first_name'] ?? ''));
            $lastName = trim((string) ($data['last_name'] ?? $data['lastname'] ?? ''));
            $fullName = trim($firstName.' '.$lastName);

            $extra = UserProfile::buildExtraData([
                'firstname' => $firstName,
                'lastname' => $lastName,
            ]);

            $user = User::query()->create([
                'name' => $fullName !== '' ? $fullName : $firstName,
                'username' => $this->generateUniqueUsername($data['phone']),
                'phone' => $data['phone'],
                'email' => $data['email'] ?? null,
                'password' => $data['password'],
                'extra_data' => $extra,
                'is_active' => true,
            ]);

            foreach ($data['roles'] ?? [] as $roleName) {
                Role::findOrCreate($roleName, 'web');
                $user->assignRole($roleName);
            }

            return $user->fresh();
        });
    }

    private function generateUniqueUsername(string $phone): string
    {
        $base = 'u'.preg_replace('/\D/', '', $phone);
        $candidate = $base;
        $suffix = 1;

        while (User::query()->where('username', $candidate)->exists()) {
            $candidate = $base.'_'.$suffix;
            $suffix++;
        }

        return Str::lower($candidate);
    }
}
