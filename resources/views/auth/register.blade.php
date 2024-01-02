<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('includes.head')

<body>
    <div class="container d-flex align-items-center justify-content-center min-vh-100 my-3">
        <div class="row bg-white py-1 border rounded-5 shadow">
            <div class="col-0 col-sm-0 col-md-6">
                <div class="row px-6 px-sm-1 px-md-1 px-lg-3 px-xl-5">
                    <h1 class="title text-wrap text-center mt-4 mb-3">ĐĂNG KÝ</h1>

                    @livewire('auth.register')

                    <div class="row">
                        <p>Bạn đã có tài khoản đăng nhập? <a href="{{ route('login') }}">Hãy đăng nhập ở đây</a></p>
                    </div>
                </div>
            </div>

            <div class="col rounded-4 d-flex align-items-center justify-content-center me-2">
                <img src="{{ asset('images/others/register.jpg') }}" class="img-box rounded-5" alt="Review Travel Group 6 SE347.O11 - Đăng ký">
            </div>
        </div>
    </div>

    @include('includes.scripts')
</body>

</html>