<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasRoles;
    use Notifiable;
    use SoftDeletes;

    public const ROLE_STUDENT = 'student';

    protected $fillable = [
        'name',
        'username',
        'phone',
        'national_code',
        'email',
        'address',
        'bio',
        'password',
        'extra_data',
        'is_active',
        'phone_verified_at',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'extra_data' => 'array',
            'is_active' => 'boolean',
            'phone_verified_at' => 'datetime',
            'email_verified_at' => 'datetime',
        ];
    }

    public function isPhoneVerified(): bool
    {
        return $this->phone_verified_at !== null;
    }

    public function isImpersonating(): bool
    {
        return false;
    }

    public function canPerformRole(string $role): bool
    {
        return $this->hasRole($role);
    }

    /**
     * @return array<string, mixed>|null
     */
    public function profileImagePayload(): ?array
    {
        return null;
    }
}
