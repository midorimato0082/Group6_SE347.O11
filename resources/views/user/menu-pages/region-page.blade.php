@extends('layouts.user')

@section('breadcrumn')
    <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
@endsection

@section('content')
    @include('user.carousel-posts')

    <div class="container">
        <div class="row mt-4">
            <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8">
                <h3 class="text-orange fw-bold">{{ Str::upper($region->name) }}</h3>

                {{-- Hiển thị posts --}}
                <livewire:user.menu-pages.region-posts :region="$region->name" />
            </div>

            {{-- Lọc tìm kiếm --}}
            <livewire:user.menu-pages.region-filter :region="$region->id" />
        </div>
    </div>
@endsection
