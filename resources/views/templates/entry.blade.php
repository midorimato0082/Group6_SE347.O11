<!DOCTYPE html>
<html lang="en">

@include('includes.head')

<body>
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="row bg-white p-3 border rounded-5 shadow">
            <div class="col rounded-4 d-flex align-items-center justify-content-center flex-column text-white box">
                @yield('left-box')
            </div>
            <div class="col m-auto form-box">
                <div class="row ps-5 pe-5">
                    @yield('right-box')
                </div>
            </div>
        </div>
    </div>

    @include('includes.scripts')

</body>

</html>
