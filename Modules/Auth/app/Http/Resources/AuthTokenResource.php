<?php

namespace Modules\Auth\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthTokenResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $isImpersonating = (bool) ($this->resource['is_impersonating'] ?? false);

        return [
            'user' => (new AuthUserResource($this->resource['user']))
                ->impersonating($isImpersonating),
            'token' => $this->resource['token'],
            'is_impersonating' => $isImpersonating,
        ];
    }
}
