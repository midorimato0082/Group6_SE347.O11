<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function viewRegister()
    {
        return view('.user.register')->with('title', 'Đăng ký');
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => Str::lower($request->email),
            'password' => md5($request->password),
            'avatar' => "no_avatar.png",
            'code' => Str::random(64),
        ]);

        if ($request->hasFile('avatar')) {
            $avatar = $user->id . '.' . $request->file('avatar')->getClientOriginalExtension();
            $request->file('avatar')->move('images/user', $avatar);

            User::where('id', $user->id)->update(['avatar' => $avatar]);
        }

        Mail::send('email.verification', ['code' => $user->code], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Xác nhận email.');
        });

        return redirect('login')->with('success', 'Bạn đã đăng ký tài khoản thành công. Vui lòng đến hộp thư email của bạn để xác nhận email trước khi đăng nhập nhé.');
    }

    public function verifyAccount($code)
    {
        $user = User::where('code', $code)->first();

        if (empty($user->email_verified_at))
            User::where('code', $code)->update(['email_verified_at' => now(), 'code' => null]);

        return redirect('login')->with('success', 'Email của bạn đã được xác nhận.');
    }
}
