<?php

namespace Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResendOtpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'phone' => ['required', 'string', 'regex:/^09\d{9}$/', 'exists:users,phone'],
        ];
    }

    public function messages(): array
    {
        return [
            'phone.required' => 'شماره همراه الزامی است.',
            'phone.regex' => 'فرمت شماره همراه صحیح نیست.',
            'phone.exists' => 'کاربری با این شماره همراه یافت نشد.',
        ];
    }
}
