<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function viewLogin()
    {
        return view('user.login')->with('title', 'Đăng nhập');
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (empty($user->email_verified_at))
            return back()->with('fail', 'Email của bạn chưa được xác nhận. Bạn cần phải xác nhận email trước khi đăng nhập.');

        if (md5($request->password) == $user->password) {
            $request->session()->put('user', ['id' => $user->id, 'first_name' => $user->first_name, 'last_name' => $user->last_name, 'avatar' => $user->avatar, 'is_admin' => $user->is_admin]);

            $this->rememberMe($request);

            if ($user->is_admin == 1)
                return redirect('dashboard');

            return redirect('');
        }
        return back()->with('fail', 'Mật khẩu không chính xác.');
    }

    public function logout()
    {
        Session::pull('user');
        return redirect('');
    }

    private function rememberMe(LoginRequest $request)
    {
        if ($request->has('remember')) {
            Cookie::queue('email', $request->email, 1440);
            Cookie::queue('password', $request->password, 1440);
        } else {
            Cookie::queue(Cookie::forget('email'));
            Cookie::queue(Cookie::forget('password'));
        }
    }
}
