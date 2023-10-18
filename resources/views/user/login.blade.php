@extends('templates.entry')

@section('left-box')
    <img src="images/others/login_page.jpg" alt="Việt Nam Travel" class="img-fluid rounded-3 mt-3">
    <h1 class="fw-bold text-wrap text-center">Review Travel</h1>
    <p class="text-wrap text-center mb-3">Cùng nhau thảo luận về những nơi tuyệt vời cho các chuyến đi nào!</p>
@endsection

@section('right-box')
    <h1 class="title text-wrap text-center mb-4">ĐĂNG NHẬP</h1>

    <form action="login" method="post">
        @csrf

        @if (Session::has('fail'))
            <div class="alert alert-danger">{{ session('fail') }}</div>
        @endif

        @if (Session::has('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="form-outline mb-3">
            <input type="text" class="form-control bg-light rounded-2 @error('email') is-invalid @enderror"
                placeholder="Email" name="email" value="{{ Cookie::get('email', old('email')) }}" autofocus required>
            @error('email')
                <p class="invalid-feedback">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-outline mb-3">
            <input type="password" class="form-control bg-light rounded-2 @error('password') is-invalid @enderror"
                placeholder="Mật khẩu" name="password" value="{{ Cookie::get('password', '') }}" required minlength="6"
                maxlength="12">
            @error('password')
                <p class="invalid-feedback">{{ $message }}</p>
            @enderror

        </div>

        <div class="d-flex justify-content-between mb-3 ps-3 pe-3">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="form-check" name="remember"
                    @if (Cookie::has('email')) checked @endif>
                <label for="form-check" class="form-check-label">Nhớ đăng nhập</label>
            </div>
            <div>
                <a href="forget-password">Quên mật khẩu?</a>
            </div>
        </div>

        <div class="mb-4">
            <button class="btn btn-orange w-100 fs-5 fw-bold shadow">Đăng nhập</button>
        </div>
    </form>

    <div class="row">
        <p>Bạn không có tài khoản đăng nhập? <a href="register">Hãy đăng ký ở đây</a></p>
    </div>
@endsection
