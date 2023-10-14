<!DOCTYPE html>
<html lang="en">

@include('includes.head')

<body>
    <div class="d-flex align-items-center justify-content-center vh-100">
        <div class="text-center">
            <h1 class="display-1 fw-bold">
                {{ $title }}
            </h1>
            <p class="lead">
                {{ $message }}
            </p>
            <a href="/" class="btn btn-orange fs-5 fw-bold shadow">Quay trở lại trang chủ</a>
        </div>
    </div>
</body>


</html>
