<!DOCTYPE html>
<html lang="en">

@include('includes.head')

<body>
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="row flex-column align-items-center justify-content-center">
            @yield('home')
            {{-- @if (Session::has('user_id')) --}}
            @if (Session::has('user.id'))
                {{-- <img src="{{ asset("images/user/{$user->avatar}") }}" alt="Avatar" class="rounded-circle avatar"> --}}
                <img src="{{ asset("images/user/".session('user.avatar')) }}" alt="Avatar" class="rounded-circle avatar">
                <h1 class="fw-bold">Xin chào,
                    {{-- <span>{{ $user->first_name }}</span> --}}
                    <span>{{ session('user.first_name') }}</span>
                </h1>
                <a href="logout" class="btn btn-orange w-100 fs-5 fw-bold shadow">
                    <span><i class="fa fa-sign-out" aria-hidden="true"></i></span>
                    Đăng xuất
                </a>
            @else
                <a href="login" class="btn btn-orange w-100 fs-5 fw-bold shadow">
                    <span><i class="fa fa-sign-in" aria-hidden="true"></i></span> Đăng nhập
                </a>
            @endif

        </div>
    </div>
    @include('includes.scripts')
</body>

</html>
