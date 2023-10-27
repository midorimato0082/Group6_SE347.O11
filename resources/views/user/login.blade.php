@extends('layouts.entry')

@section('left-box')
    <img src="images/others/login-page.jpg" alt="Việt Nam Travel" class="img-fluid rounded-3 mt-3">
    <h1 class="fw-bold text-wrap text-center">Review Travel</h1>
    <p class="text-wrap text-center mb-3">Cùng nhau thảo luận về những nơi tuyệt vời cho các chuyến đi nào!</p>
@endsection

@section('right-box')
    <h1 class="title text-wrap text-center mb-4">ĐĂNG NHẬP</h1>

    @livewire('login')

    <div class="row">
        <p>Bạn không có tài khoản đăng nhập? <a href="register">Hãy đăng ký ở đây</a></p>
    </div>
@endsection
