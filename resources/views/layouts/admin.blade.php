<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('includes.head')

<body>
    <div class="container-fluid position-relative d-flex p-0">

        {{-- Sidebar --}}
        <div class="sidebar pe-1 pb-3">
            <nav class="navbar">
                <a href="{{ route('home') }}" class="navbar-brand mx-4 mb-3">
                    <h3>{{ config('app.name') }}</h3>
                </a>

                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative img-profile">
                        <img class="rounded-circle" src="{{ Auth::user()->avatar_url }}" alt="Avatar">
                        <div
                            class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1">
                        </div>
                    </div>
                    <div class="ms-3 profile-info">
                        <span>Xin chào,</span>
                        <h2>{{ Auth::user()->first_name }}</h2>
                    </div>
                </div>

                <div id="sidebar" class="navbar-nav w-100">
                    <a href="{{ route('dashboard') }}" class="nav-item nav-link"><i
                            class="fa fa-tachometer-alt me-2"></i>Tổng quan</a>

                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i
                                class="fa fa-user me-2"></i>User</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="{{ url('all-users') }}" class="dropdown-item">Danh sách User</a>
                            <a href="{{ url('add-admin') }}" class="dropdown-item">Thêm Admin</a>
                            <a class="dropdown-item admin d-none" onclick="return false">Cập nhật Admin</a>
                        </div>
                    </div>

                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i
                                class="fa fa-map-marker me-2"></i>Địa điểm</a>
                        <div class="dropdown-menu bg-transparent border-0 child-menu">
                            <a href="{{ url('all-locations') }}" class="dropdown-item">Danh sách địa điểm</a>
                            <a href="{{ url('add-location') }}" class="dropdown-item">Thêm địa điểm</a>
                            <a class="dropdown-item location d-none" onclick="return false">Cập nhật địa điểm</a>
                        </div>
                    </div>

                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-edit me-2"></i>Bài
                            viết</a>
                        <div class="dropdown-menu bg-transparent border-0 child-menu">
                            <a href="{{ url('all-reviews') }}" class="dropdown-item">Danh sách bài viết</a>
                            <a href="{{ url('add-review') }}" class="dropdown-item">Thêm bài viết</a>
                            <a class="dropdown-item review d-none" onclick="return false">Cập nhật bài viết</a>
                        </div>
                    </div>

                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i
                                class="fa fa-newspaper me-2"></i>Tin tức</a>
                        <div class="dropdown-menu bg-transparent border-0 child-menu">
                            <a href="{{ url('all-news') }}" class="dropdown-item">Danh sách tin tức</a>
                            <a href="{{ url('add-news') }}" class="dropdown-item">Thêm tin tức</a>
                            <a class="dropdown-item news d-none" onclick="return false">Cập nhật tin tức</a>
                        </div>
                    </div>

                    <a href="{{ url('all-comments') }}" class="nav-item nav-link"><i
                            class="fa fa-comment me-2"></i>Bình luận</a>
                </div>

                <div class="sidebar-footer hidden-small">
                    <a href="{{ route('logout') }}" data-toggle="tooltip" data-placement="top" title="Logout">
                        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </nav>
        </div>


        <div class="content">
            {{-- Navbar --}}
            <nav class="navbar navbar-expand navbar-dark sticky-top px-4 py-0">
                <a class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>

                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle profile-nav" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="{{ Auth::user()->avatar_url }}"
                                alt="Avatar"">
                            <span class="d-none d-lg-inline-flex">{{ Auth::user()->full_name }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end border-0 rounded-0 rounded-bottom m-0">
                            <a href="{{ url('profile') }}" class="dropdown-item"><i
                                    class="fa fa-user-edit me-2"></i>Hồ sơ</a>
                            <a href="{{ route('logout') }}" class="dropdown-item"><i
                                    class="fa fa-sign-out me-2"></i>Đăng xuất</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </nav>

            {{-- Main Content --}}
            <div class="container-fluid p-3">
                <h1 id="title-content"></h1>
                <div class="position-relative bg-white rounded mb-3 p-3 d-inline-block w-100 panel">
                    <div class="px-2 float-start w-100 clearfix">
                        <span id="title-section" class="d-block w-100 mb-4 lh-base d-none"></span>
                        @yield('content')
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <footer class="bg-white pe-3 position-absolute w-100 bottom-0 start-0">
                <div class="float-end">
                    <small>Website Design: Group 6 - SE347.O11</small>
                </div>
            </footer>

            <button id="btn-to-top" class="btn btn-orange btn-lg rounded-5"><i class="fa fa-arrow-up"></i></button>
        </div>

        @include('includes.scripts')
    </div>
</body>

</html>
