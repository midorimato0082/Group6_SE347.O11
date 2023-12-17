@extends('layouts.user')

@section('breadcrumn')
    <li class="breadcrumb-item">
        <a href="{{ route('region', $location->region->slug) }}">{{ $location->region->name }}</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
@endsection

@section('content')
    @include('user.carousel-reviews')

    <div class="container">
        <div class="row mt-4">
            <div class="col-md-8 col-lg-8 col-xl-8">
                <h3 class="text-orange fw-bold">{{ Str::upper($location->name) }}</h3>

                <div class="mt-4 tag">
                    @foreach ($categories as $category)
                        <a href="{{ route('category', $category->slug) }}"
                            class="mx-1 text-orange fw-bold badge bg-dark">{{ $category->name }}</a>
                    @endforeach
                </div>

                @foreach ($reviews as $review)
                    <div class="card mt-4 bg-transparent border-0 menu">
                        <div class="row g-0">
                            <div class="col-md-4 position-relative">
                                <a href="{{ route('review', $review->slug) }}">
                                    <img src="{{ $review->first_image }}" class="img-fluid rounded horizontal-card-image" alt="{{ $review->title }}">
                                </a>
                                <div class="position-absolute bg-orange px-2 py-1 rounded fw-bold bottom-0 start-0 ms-2 mb-2">
                                    <a href="{{ route('category', $review->category->slug) }}">{{ $review->category->name }}</a>
                                </div> 
                            </div>
                            <div class="col-md-8">
                                <div class="card-body pt-0">
                                    <a href="{{ route('review', $review->slug) }}" class="text-black">
                                        <h5 class="card-title fw-bold">{{ $review->title }}</h5>
                                    </a>
                                    <p class="card-text">{{ $review->desc }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @livewire('user.latest-reviews')
        </div>
    </div>
@endsection
