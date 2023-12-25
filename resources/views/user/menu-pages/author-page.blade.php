@extends('layouts.user')

@section('breadcrumn')
    <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
@endsection

@section('content')
    @include('user.carousel-posts')

    <div class="container">
        <div class="row mt-4">
            <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8">
                <h3 class="text-orange fw-bold">{{ Str::upper($user->full_name) }}</h3>
                <h5 class="fw-bold mt-3">{{ $user->email }}</h5>

                {{-- Hiển thị posts --}}
                <livewire:user.menu-pages.author-posts :author="$user->email" />
            </div>

            {{-- Lọc tìm kiếm --}}
            <livewire:user.menu-pages.author-filter />
        </div>
    </div>
@endsection