<?php

namespace Modules\Auth\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Modules\Auth\Models\OtpCode;

class OtpCodeAdminService
{
    /**
     * @param  array{search?: string, receiver_type?: string, status?: string}  $filters
     */
    public function paginate(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return OtpCode::query()
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('receiver', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
                });
            })
            ->when(
                filled($filters['receiver_type'] ?? null),
                fn ($query) => $query->where('receiver_type', $filters['receiver_type'])
            )
            ->when(
                filled($filters['status'] ?? null),
                fn ($query) => $this->applyStatusFilter($query, (string) $filters['status'])
            )
            ->latest('id')
            ->paginate(max(1, min(100, $perPage)))
            ->withQueryString();
    }

    private function applyStatusFilter(Builder $query, string $status): Builder
    {
        return match ($status) {
            'used' => $query->whereNotNull('used_at'),
            'expired' => $query->whereNull('used_at')->where('expires_at', '<=', now()),
            'active' => $query->whereNull('used_at')->where('expires_at', '>', now()),
            default => $query,
        };
    }
}
