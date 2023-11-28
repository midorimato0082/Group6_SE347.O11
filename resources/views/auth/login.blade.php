@extends('layouts.entry')

@section('left-box')
    <img src="{{ asset('images/others/login.jpg') }}" alt="Việt Nam Travel" class="img-fluid rounded-3 mt-3">
    <h1 class="fw-bold text-wrap text-center">{{ config('app.name') }}</h1>
    <p class="text-wrap text-center mb-3">Cùng nhau thảo luận về những nơi tuyệt vời cho các chuyến đi nào!</p>
@endsection

@section('right-box')
    <h1 class="title text-wrap text-center mb-4">ĐĂNG NHẬP</h1>

    @livewire('auth.login')

    <div class="row">
        <p>Bạn không có tài khoản đăng nhập? <a href="{{ route('register') }}">Hãy đăng ký ở đây</a></p>
    </div>
    <div class="row text-center">
        <p>Quay lại <a href="{{ route('home') }}">trang chủ</a></p>
    </div>
@endsection