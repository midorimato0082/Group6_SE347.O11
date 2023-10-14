<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'bail | required | alpha | max:20',
            'last_name' => 'bail | required | alpha | max:40',
            'email' => 'bail | required | email | unique:tbl_user',
            'password' => 'bail | required | min:6 | max:12 | confirmed'
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'Bạn cần nhập tên.',
            'first_name.alpha' => 'Tên chỉ bao gồm các chữ cái.',
            'first_name.max' => 'Tên tối đa chỉ có 20 ký tự.',
            'last_name.required' => 'Bạn cần nhập họ.',
            'last_name.alpha' => 'Họ chỉ bao gồm các chữ cái.',
            'last_name.max' => 'Họ tối đa chỉ có 40 ký tự.',
            'email.required' => 'Bạn cần nhập email.',
            'email.email' => 'Không đúng định dạng email.',
            'email.unique' => 'Email đã tồn tại.',
            'password.required' => 'Bạn cần nhập mật khẩu.',
            'password.min' => 'Mật khẩu cần ít nhất 6 ký tự.',
            'password.max' => 'Mật khẩu tối đa chỉ có 12 ký tự',
            'password.confirmed' => 'Nhập lại mật khẩu không đúng.'
        ];
    }
}
