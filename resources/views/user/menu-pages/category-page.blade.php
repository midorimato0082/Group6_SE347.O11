@extends('layouts.user')

@section('breadcrumn')
    <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
@endsection

@section('content')
    @include('user.carousel-posts')

    <div class="container">
        <div class="row mt-4">
            <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8">
                <h3 class="text-orange fw-bold">{{ Str::upper($category->name) }}</h3>

                {{-- Hiển thị posts --}}
                <livewire:user.menu-pages.category-posts :category="$category->id" />
            </div>

            {{-- Lọc tìm kiếm --}}
            <livewire:user.menu-pages.category-filter />
        </div>
    </div>
@endsection
