<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'password' => 'bail | required | min:6 | max:12 | confirmed'
        ];
    }

    public function messages(): array
    {
        return [
            'password.required' => 'Bạn cần nhập mật khẩu mới.',
            'password.min' => 'Mật khẩu cần ít nhất 6 ký tự.',
            'password.max' => 'Mật khẩu tối đa chỉ có 12 ký tự',
            'password.confirmed' => 'Nhập lại mật khẩu mới không đúng.'
        ];
    }
}
