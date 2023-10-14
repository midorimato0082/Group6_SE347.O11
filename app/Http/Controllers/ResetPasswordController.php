<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function viewForgetPassword()
    {
        return view('user.forget_password')->with('title', 'Quên mật khẩu');
    }

    public function viewResetPassword($email, $code)
    {
        $user = User::where('email', $email)->first();

        if (empty($user->code) || ($user->updated_at->diff(now()))->i > 10) {
            return redirect('login')->with('fail', 'Link đặt lại mật khẩu đã hết hiệu lực.');
        }

        return view('user.reset_password', ['title' => 'Đặt lại mật khẩu', 'email' => $email, 'code' => $code]);
    }

    public function forgetPassword(ForgetPasswordRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (empty($user->email_verified_at))
            return back()->with('fail', 'Email của bạn chưa được xác nhận.');

        $code = Str::uuid();

        $user = User::whereId($user->id)->update([
            'code' => $code
        ]);

        Mail::send('email.reset_password', ['email' => $request->email, 'code' => $code], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Đặt lại mật khẩu.');
        });

        return back()->with('success', 'Vui lòng đến hộp thư email của bạn để đến link đặt lại mật khẩu nhé. Lưu ý rằng link chỉ có hiệu lực trong 10 phút.');
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        User::where('email', $request->email)->update(['password' => md5($request->password), 'code' => null]);

        return redirect('login')->with('success', 'Đặt lại mật khẩu thành công. Đăng nhập nào.');
    }
}
