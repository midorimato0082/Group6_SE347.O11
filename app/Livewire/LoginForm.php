<?php

namespace App\Livewire;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class LoginForm extends Component
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
        return view('livewire.login-form');
    }

    protected function rules(): array
    {
        return (new LoginRequest())->rules();
    }

    protected function messages(): array
    {
        return (new LoginRequest())->messages();
    }

    public function login()
    {
        $this->validate();

        $user = User::where('email', $this->email)->first();

        if (empty($user->email_verified_at))
            return session()->flash('fail', 'Email của bạn chưa được xác nhận. Bạn cần phải xác nhận email trước khi đăng nhập.');

        if (md5($this->password) == $user->password) {
            Session::put('user', ['id' => $user->id, 'first_name' => $user->first_name, 'last_name' => $user->last_name, 'avatar' => $user->avatar, 'is_admin' => $user->is_admin]);

            $this->rememberMe($this->email, $this->password);

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
