@extends('templates.entry')

@section('left-box')
    <div class="mt-3 mb-3">
        <img src="/images/others/reset_password.png" alt="Reset password" class="img-box">
    </div>
@endsection

@section('right-box')
    <h1 class="title text-wrap text-center mb-4">ĐẶT LẠI MẬT KHẨU</h1>

    <form action="{{ route('reset') }}" method="post">
        @csrf

        <input type="hidden" name="email" value="{{ $email }}">
        <div class="form-outline mb-3">
            <input type="text" class="form-control bg-light rounded-2" value="{{ $email }}" disabled>
        </div>

        <div class="form-outline mb-3">
            <input type="password" class="form-control bg-light rounded-2" placeholder="Mật khẩu mới" name="password"
                autofocus>
            <p>
                @error('password')
                    {{ $message }}
                @enderror
            </p>
        </div>

        <div class="form-outline mb-3">
            <input type="password" class="form-control bg-light rounded-2" placeholder="Nhập lại mật khẩu mới"
                name="password_confirmation">
        </div>

        <div class="mb-4">
            <button class="btn btn-orange w-100 fs-5 fw-bold shadow">Đặt lại mật khẩu</button>
        </div>
    </form>

    <div class="row">
        <p>Quay lại <a href="/login">trang đăng nhập</a></p>
    </div>
@endsection
