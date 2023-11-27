<!DOCTYPE html>
<html lang="en">

@include('includes.head')

<body>
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="row bg-white p-3 p-sm-3 p-md-3 p-lg-3 p-xl-3 border rounded-5 shadow">
            <div class="col rounded-4 d-flex align-items-center justify-content-center flex-column text-white box">
                @yield('left-box')
            </div>
            <div class="col m-auto form-box">
                <div class="row px-6 px-sm-0 px-md-2 px-lg-5 px-xl-5">
                    @yield('right-box')
                </div>
            </div>
        </div>
    </div>

    @include('includes.scripts')

</body>

</html>
