<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveUserRequest extends FormRequest
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
            'user.*.first_name' => 'required | alpha:ascii | max:20',
            'user.*.last_name' => 'required | alpha:ascii | max:40',
            'user.*.email' => 'required | email:rfc,dns | max:30 | unique:tbl_user',
            'user.*.phone' => 'required | digits:10 | unique:tbl_user',
            'user.password' => 'required | min:6 | max:12 | confirmed',
            'avatar' => 'nullable | sometimes | mimes:gif,png,jpeg,jpg | max:1024'
        ];
    }

    // public function messages(): array
    // {
    //     return [
    //         'user.firstName.required' => 'Bạn cần nhập tên.',
    //         'user.firstName.alpha' => 'Tên chỉ bao gồm các chữ cái Latinh.',
    //         'user.firstName.max' => 'Tên tối đa chỉ có 20 ký tự.',
    //         'user.lastName.required' => 'Bạn cần nhập họ.',
    //         'user.lastName.alpha' => 'Họ chỉ bao gồm các chữ cái Latinh.',
    //         'user.lastName.max' => 'Họ tối đa chỉ có 40 ký tự.',
    //         'user.email.required' => 'Bạn cần nhập email.',
    //         'user.email.email' => 'Không đúng định dạng email.',
    //         'user.email.max' => 'Email tối đa chỉ có 30 ký tự.',
    //         'user.email.unique' => 'Email đã tồn tại.',
    //         'user.phone.required' => 'Bạn cần nhập số điện thoại.',
    //         'user.phone.digits' => 'Số điện thoại phải gồm 10 chữ số.',
    //         'user.phone.unique' => 'Số điện thoại đã tồn tại trong hệ thống.',
    //         'user.password.required' => 'Bạn cần nhập mật khẩu.',
    //         'user.password.min' => 'Mật khẩu cần có ít nhất 6 ký tự và tối đa 12 ký tự.',
    //         'user.password.max' => 'Mật khẩu cần có ít nhất 6 ký tự và tối đa 12 ký tự.',
    //         'user.password.confirmed' => 'Nhập lại mật khẩu không đúng.',
    //         'user.passwordConfirmation.required' => 'Bạn cần nhập lại mật khẩu.',
    //         'user.avatar.mimes' => 'Ảnh phải là định dạng gif, png, jpeg hoặc jpg.',
    //         'user.avatar.size' => 'Kích thước ảnh lớn hơn 1 MB.'
    //     ];
    // }
}
