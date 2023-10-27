<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'first_name' => 'bail | required | alpha:ascii | max:20',
            'last_name' => 'bail | required | alpha:ascii | max:40',
            'email' => 'bail | required | email:rfc,dns | max:30 | unique:tbl_user',
            'password' => 'bail | required | min:6 | max:12 | confirmed',
            'avatar' => 'bail | nullable | mimes:gif,png,jpeg,jpg | size:1024'
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'Bạn cần nhập tên.',
            'first_name.alpha' => 'Tên chỉ bao gồm các chữ cái Latinh.',
            'first_name.max' => 'Tên tối đa chỉ có 20 ký tự.',
            'last_name.required' => 'Bạn cần nhập họ.',
            'last_name.alpha' => 'Họ chỉ bao gồm các chữ cái Latinh.',
            'last_name.max' => 'Họ tối đa chỉ có 40 ký tự.',
            'email.required' => 'Bạn cần nhập email.',
            'email.email' => 'Không đúng định dạng email.',
            'email.max' => 'Email tối đa chỉ có 30 ký tự.',
            'email.unique' => 'Email đã tồn tại.',
            'password.required' => 'Bạn cần nhập mật khẩu.',
            'password.min' => 'Mật khẩu cần ít nhất 6 ký tự.',
            'password.max' => 'Mật khẩu tối đa chỉ có 12 ký tự',
            'password.confirmed' => 'Nhập lại mật khẩu không đúng.',
            'avatar.mimes' => 'Ảnh phải là địng dạng gif, png, jpeg hoặc jpg.',
            'avatar.size' => 'Kích thước ảnh lớn hơn 1 MB'
        ];
    }
}