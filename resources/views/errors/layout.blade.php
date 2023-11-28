<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('includes.head')

<body class="error-page">
    <div class="d-flex align-items-center justify-content-center">
        <div class="text-center row">
            <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                @yield('image')
            </div>
            <div class=" col my-auto">
                <p class="fs-3"> <span class="text-danger">Opps!</span> @yield('message')</p>
                <p class="lead">@yield('sub-message')</p>
                <div class="d-flex justify-content-center">
                    <a href="{{ url()->previous() }}" class="btn btn-orange fs-5 fw-bold shadow me-3">Về trang trước</a>
                    <a href="{{ route('home') }}" class="btn btn-dark fs-5 fw-bold shadow">Về trang chủ</a>
            </div>
        </div>
    </div>
</body>

</html>
