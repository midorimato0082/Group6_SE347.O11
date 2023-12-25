@extends('layouts.user')

@section('breadcrumn')
    <li class="breadcrumb-item">
        <a
            href="{{ route('region', $place->district->province->region->slug) }}">{{ $place->district->province->region->name }}</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('province', $place->district->province->slug) }}">{{ $place->district->province->name }}</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('district', $place->district->slug) }}">{{ $place->district->name }}</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('category', $place->category->slug) }}">{{ $place->category->name }}</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
@endsection

@section('content')
    @include('user.carousel-posts')

    <div class="container">
        <div class="row mt-4">
            <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8">
                <h3 class="text-orange fw-bold">
                    {{ Str::upper($place->name) }}
                </h3>

                <p>{!! str_repeat('<i class="fa fa-star star-color fa-lg me-2"></i>', $place->star) !!}</p>

                <h5 class="fw-bold">
                    <i class="fa-solid fa-sack-dollar"></i>
                    {!! $place->lowest_price . ' - ' . $place->highest_price !!}
                </h5>

                {{-- Hiển thị posts --}}
                <livewire:user.menu-pages.place-posts :place="$place->name" />
            </div>

            {{-- Bài viết mới nhất --}}
            @livewire('user.post.latest-posts')
        </div>
    </div>
@endsection
