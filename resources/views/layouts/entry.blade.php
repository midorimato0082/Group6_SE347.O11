<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('includes.head')

<body>
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="row bg-white p-3 border rounded-5 shadow">
            <div class="col-0 col-sm-0 col-md-6 rounded-4 d-flex align-items-center justify-content-center flex-column text-white box">
                @yield('left-box')
            </div>
            <div class="col m-auto form-box">
                <div class="row px-6 px-sm-0 px-md-0 px-lg-3 px-xl-5">
                    @yield('right-box')
                </div>
            </div>
        </div>
    </div>

    @include('includes.scripts')

</body>

</html>
