@extends('auth.passwords.email')

@section('right-box')
    <h1 class="title text-wrap text-center mb-4">ĐẶT LẠI MẬT KHẨU</h1>

    @livewire('auth.passwords.reset', ['token' => $token, 'email' => $email])

    <div class="row">
        <p>Quay lại <a href="{{ route('login') }}">trang đăng nhập</a> hay <a href="{{ route('home') }}">trang chủ</a></p>
    </div>
@endsection