<?php

namespace App\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\Cookie;
use Livewire\Component;

class Login extends Component
{
    public $email, $password, $remember;

    public function mount()
    {
        $this->email = Cookie::get('email');
        $this->password = Cookie::get('password');
        $this->remember = Cookie::has('email') ?  true : false;
    }

    public function render()
    {
        return view('livewire.user.login');
    }

    protected function rules(): array
    {
        return [
            'email' => 'bail | required | email:rfc,dns | exists:users',
            'password' => 'bail | required | min:6 | max:12',
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
    }

    public function login()
    {
        $this->validate();

        $user = User::where('email', $this->email)->first();

        if (empty($user->email_verified_at)) {
            $this->reset();
            return session()->flash('fail', 'Email của bạn chưa được xác nhận. Bạn cần phải xác nhận email trước khi đăng nhập.');
        }

        if (md5($this->password) == $user->password) {
            session(['user' => ['id' => $user->id, 'first_name' => $user->first_name, 'name' => $user->fullName, 'avatar' => $user->avatar, 'is_admin' => $user->is_admin]]);

            $this->rememberMe($this->email, $this->password);

            $this->reset();

            if ($user->is_admin == 1)
                return redirect('dashboard');

            return redirect('');
        }
        return session()->flash('fail', 'Mật khẩu không chính xác.');
    }

    private function rememberMe($email, $password)
    {
        if ($this->remember) {
            Cookie::queue('email', $email, 1440);
            Cookie::queue('password', $password, 1440);
        } else {
            Cookie::queue(Cookie::forget('email'));
            Cookie::queue(Cookie::forget('password'));
        }
    }
}
