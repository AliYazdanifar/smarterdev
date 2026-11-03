<?php

namespace Modules\Auth\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexOtpCodeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'search' => ['nullable', 'string', 'max:255'],
            'receiver_type' => ['nullable', Rule::in(['sms', 'email'])],
            'status' => ['nullable', Rule::in(['active', 'used', 'expired'])],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ];
    }

    /**
     * @return array{search?: string, receiver_type?: string, status?: string}
     */
    public function filters(): array
    {
        return $this->safe()->only(['search', 'receiver_type', 'status']);
    }
}
