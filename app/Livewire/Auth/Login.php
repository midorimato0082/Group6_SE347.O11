<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $email, $password, $remember;

    public function render()
    {
        return view('livewire.auth.login');
    }

    protected function rules(): array
    {
        return [
            'email' => 'required|email:rfc,dns|exists:users',
            'password' => 'required|min:6|max:12',
        ];
    }

    protected function messages(): array
    {
        return [
            'email.required' => 'Bạn cần nhập email.',
            'email.email' => 'Không đúng định dạng email.',
            'email.exists' => 'Email đã nhập không có trong hệ thống.',
            'password.required' => 'Bạn cần nhập mật khẩu.',
            'password.min' => 'Mật khẩu cần ít nhất 6 ký tự.',
            'password.max' => 'Mật khẩu tối đa chỉ có 12 ký tự',
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);

        if ($propertyName === 'email')
            $this->isActive();
    }

    public function login(Request $request)
    {
        $this->validate();

        if(!$this->isActive()) return;

        if (Auth::attempt($this->only(['email', 'password']), $this->remember)) {
            $request->session()->regenerate();
            $this->reset();

            return Auth::user()->email_verified_at ? redirect()->intended() : to_route('verification.notice');
        }

        $this->reset('password');
        $this->addError('password', 'Mật khẩu không chính xác.');
    }

    private function isActive() 
    {
        if(User::where('email', $this->email)->value('is_active'))         
            return true;
        $this->addError('email', 'Tài khoản của bạn đã bị vô hiệu hóa.');
        return false;
    }
}
