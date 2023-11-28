<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showResetForm(Request $request, $token)
    {
        $email = $request->email;
        return view('auth.passwords.reset', compact('token', 'email'))->with('title', 'Đặt lại mật khẩu');
    }
}
