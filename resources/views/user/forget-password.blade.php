@extends('layouts.entry')

@section('left-box')
    <div class="mt-3 mb-3">
        <img src="images/others/reset_password.png" alt="Reset password" class="img-box">
    </div>
@endsection

@section('right-box')
    <h1 class="title text-wrap text-center mb-4">QUÊN MẬT KHẨU</h1>
    <p id="text">Nhập địa chỉ email của bạn và Review Travel sẽ gửi link đặt lại mật khẩu cho bạn.</p>

    <form action="{{ route('forget') }}" method="post" id="forget-password-form">
        @csrf

        @include('includes.flash_message')
        
        <div class="form-outline mb-3">
            <input type="text" class="form-control bg-light rounded-2" placeholder="Email" name="email" autofocus
                value={{ old('email') }}>
            <p>
                @error('email')
                    {{ $message }}
                @enderror
            </p>
        </div>

        <div class="mb-4">
            <button class="btn btn-orange w-100 fs-5 fw-bold shadow">Đặt lại mật khẩu</button>
        </div>
    </form>

    <div class="row text-center">
        <p>Quay trở lại <a href="login">trang Đăng nhập</a></p>
    </div>
@endsection
