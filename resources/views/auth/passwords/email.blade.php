@extends('layouts.entry')

@section('left-box')
    <div class="mt-3 mb-3">
        <img src="{{ asset('images/others/reset-password.png') }}" class="img-box">
    </div>
@endsection

@section('right-box')
    <h1 class="title text-wrap text-center mb-4">QUÊN MẬT KHẨU</h1>

    @livewire('auth.passwords.email')

    <div class="row text-center">
        <p>Quay lại <a href="{{ route('login') }}">trang đăng nhập</a> hoặc <a href="{{ route('home') }}">trang chủ</a></p>
    </div>
@endsection