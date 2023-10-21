<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function viewLogin()
    {
        return view('user.login')->with('title', 'Đăng nhập');
    }

    public function logout()
    {
        Session::pull('user');
        return redirect('');
    }
}
