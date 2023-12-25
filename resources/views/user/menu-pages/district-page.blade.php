@extends('layouts.user')

@section('breadcrumn')
    <li class="breadcrumb-item">
        <a href="{{ route('region', $district->province->region->slug) }}">{{ $district->province->region->name }}</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('province', $district->province->slug) }}">{{ $district->province->name }}</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
@endsection

@section('content')
    @include('user.carousel-posts')

    <div class="container">
        <div class="row mt-4">
            <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8">
                <h3 class="text-orange fw-bold">{{ Str::upper($district->name) }}</h3>

                {{-- Hiển thị posts --}}
                <livewire:user.menu-pages.district-posts :district="$district->name" />
            </div>

            {{-- Lọc tìm kiếm --}}
            <livewire:user.menu-pages.district-filter :district="$district->id" />
        </div>
    </div>
@endsection