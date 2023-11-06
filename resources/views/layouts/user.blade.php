<!DOCTYPE html>
<html lang="en">

@include('includes.head')

<body>
    <header>
        <div class="container mt-4 d-flex align-items-center">
            <a href="{{ url('') }}" class="logo">
                <img src="{{ asset('images/others/logo.png') }}" alt="Logo">
                <h1>Review Travel</h1>
            </a>
        </div>

        <div class="container mt-3 p-0">
            <nav class="navbar navbar-expand-lg navbar-header">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0 navbar-left">
                            <li class="nav-item"><a class="nav-link" href="{{ url('') }}">Trang chủ</a></li>

                            {{-- Biến $categories đã được truyền từ app/Providers/ViewServiceProvider --}}
                            @foreach ($categories as $category)
                                <li class="nav-item"><a class="nav-link"
                                        href="{{ url('category/' . $category->slug) }}">{{ $category->name }}</a></li>
                            @endforeach

                            <li class="nav-item"><a class="nav-link" href="{{ url('news/') }}">Tin tức</a></li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Địa
                                    điểm</a>
                                <ul class="dropdown-menu border-0">
                                    @foreach ($locations as $location)
                                        <li><a class="dropdown-item"
                                                href="{{ url('location/' . $location->slug) }}">{{ $location->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        </ul>

                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item position-relative">
                                <input type="search"
                                    class="form-control form-control-sm mt-1 border-0 shadow-none bg-transparent fw-bold input-header"
                                    placeholder="Nhập từ cần tìm...">
                                <a class="nav-link position-absolute end-0 top-0 search-header">
                                    <i class="fa fa-search"></i>
                                </a>

                            </li>

                            @if (Session::has('user.id'))
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle profile-nav py-0" data-bs-toggle="dropdown">
                                        <img class="rounded-circle me-1"
                                            src="{{ asset('images/users/' . session('user.avatar')) }}" alt="Avatar"">
                                        <span class="d-lg-inline-flex fw-bold text-dark align-middle">Xin chào,
                                            {{ session('user.first_name') }}</span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end border-0 rounded-0 rounded-bottom m-0">
                                        @if (session('user.is_admin') == 1)
                                            <a href="{{ url('dashboard') }}" class="dropdown-item">
                                                <i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                                            <a href="{{ url('profile-admin') }}" class="dropdown-item">
                                                <i class="fa fa-user-edit me-2"></i>Hồ sơ</a>
                                        @else
                                            <a href="{{ url('profile') }}" class="dropdown-item">
                                                <i class="fa fa-user-edit me-2"></i>Hồ sơ</a>
                                        @endif
                                        <a href="{{ url('logout') }}" class="dropdown-item"><i
                                                class="fa fa-sign-out me-2"></i>Đăng xuất</a>
                                    </div>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a href="{{ url('login') }}" class="btn btn-dark rounded-5 fw-bold shadow">
                                        <span class="me-2"><i class="fa fa-sign-in" aria-hidden="true"></i></span>Đăng
                                        nhập
                                    </a>
                                </li>
                            @endif

                        </ul>
                    </div>
                </div>
            </nav>
        </div>

    </header>

    {{-- Breadcrumb --}}
    <section id="breadcrumb">
        <div class="container mt-4 px-0 d-none">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-black py-2 px-3 rounded-2">
                    <li class="breadcrumb-item"><a href="{{ url('') }}">Trang chủ</a></li>
                    {{-- Truyền thêm nội dung tương ứng cho breadcrumb, xem mẫu ở category-page.blade.php --}}
                    @yield('breadcrumn')
                </ol>
            </nav>
        </div>
    </section>

    {{-- Main content --}}
    <section>
        @yield('content')
    </section>

    {{-- Footer --}}
    <footer class="bg-black text-white bottom-0 w-100 pt-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-xl-4 mb-5 mb-sm-5 mb-xl-3">
                    <h3 class="mb-4 fw-bold">About us</h3>
                    <p>Chuyên trang review & đánh giá các homestay - hostel - resort mới nhất, có view đẹp nhất với chi
                        phí phải chăng.</p>
                    <a>Liên hệ truyền thông quảng cáo: 0999999999</a>
                </div>

                <div class="col-12 col-sm-12 col-md-6 col-xl-4 mb-5 mb-sm-5 mb-xl-3 item">
                    <a href="{{ url('region/mien-bac') }}">
                        <h3 class="mb-4 fw-bold">Homestay Miền Bắc</h3>
                    </a>

                    {{-- Biến $bacReviews, $namReviews đã được truyền từ app/Providers/ViewServiceProvider --}}
                    @foreach ($bacReviews as $review)
                        <div class="row mb-2">
                            <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                                <a href="{{ url('/review/' . $review->slug) }}">
                                    <img src="{{ asset('images/reviews/' . $review->id . '/' . explode(' | ', $review->images)[0]) }}"
                                        class="rounded-3">
                                </a>
                            </div>
                            <div class="col ms-3">
                                <a href="{{ url('/review/' . $review->slug) }}">
                                    <h5>{{ $review->title }}</h5>
                                </a>
                                <p>{{ $review->created_at }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="col-12 col-sm-12 col-md-6 col-xl-4 mb-5 mb-sm-5 mb-xl-3 item">
                    <a href="{{ url('/region/mien-nam') }}">
                        <h3 class="mb-4 fw-bold">Homestay Miền Nam</h3>
                    </a>
                    @foreach ($namReviews as $review)
                        <div class="row mb-2">
                            <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                                <a href="{{ url('/review/' . $review->slug) }}">
                                    <img src="{{ asset('images/reviews/' . $review->id . '/' . explode('|', $review->images)[0]) }}"
                                        class="rounded-3">
                                </a>
                            </div>
                            <div class="col ms-3">
                                <a href="{{ url('/review/' . $review->slug) }}">
                                    <h5>{{ $review->title }}</h5>
                                </a>
                                <p>{{ $review->created_at }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="container d-flex justify-content-between final pt-3">
            <p>&copy 2023 - All Rights Reserved.</p>
            <p>Website Design: <a href="{{ url('') }}">Review Travel</a></p>
        </div>

    </footer>

    <button id="btn-to-top" class="btn btn-orange btn-lg rounded-5"><i class="fa fa-arrow-up"></i></button>

    @include('includes.scripts')
</body>

</html>
