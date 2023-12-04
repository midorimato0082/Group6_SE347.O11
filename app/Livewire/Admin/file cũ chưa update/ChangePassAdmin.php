<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class ChangePassAdmin extends Component
{
    public $oldPassword;
    public $newPassword;
    public $newPassword_confirmation;

    public function render()
    {
        return view('livewire.admin.change-pass-admin');
    }

    protected function rules(): array
    {
        return [
            'oldPassword' => 'bail | required  | min:6 | max:12',
            'newPassword' => 'bail | required  | min:6 | max:12 | confirmed',
        ];
    }

    protected function messages(): array
    {
        return [
            'oldPassword.required' => 'Bạn cần nhập mật khẩu cũ.',
            'oldPassword.min' => 'Mật khẩu cần có ít nhất 6 ký tự và tối đa 12 ký tự.',
            'oldPassword.max' => 'Mật khẩu cần có ít nhất 6 ký tự và tối đa 12 ký tự.',
            'newPassword.required' => 'Bạn cần nhập mật khẩu mới.',
            'newPassword.min' => 'Mật khẩu cần có ít nhất 6 ký tự và tối đa 12 ký tự.',
            'newPassword.max' => 'Mật khẩu cần có ít nhất 6 ký tự và tối đa 12 ký tự.',
            'newPassword.confirmed' => 'Nhập lại mật khẩu mới không đúng.'
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function clear()
    {
        $this->clearValidation();
        $this->reset();
    }

    public function changePass()
    {
        $this->validate();

        $user = User::find(session('user.id'));

        if (md5($this->oldPassword) != $user->password)
            return session()->flash('fail', 'Nhập lại mật khẩu cũ không đúng.');

        $user->password = md5($this->newPassword);
        $user->save();
        $this->clear();

        Session::pull('user');

        if (Cookie::has('email') || Cookie::has('password')) {
            Cookie::queue(Cookie::forget('email'));
            Cookie::queue(Cookie::forget('password'));
        }

        return redirect('login')->with('success', 'Vui lòng thực hiện đăng nhập lại nhé.');
    }
}
