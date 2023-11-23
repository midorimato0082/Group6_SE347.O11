@extends('layouts.user')

{{-- Em làm tương tự cho các view location-page, region-page,... nhé --}}
@section('breadcrumn')
    <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
@endsection
@section('content')
    @include('user.carousel-reviews')
    <div class="container">
        <div class="row mt-4">
            <div class="col-md-8 col-lg-8 col-xl-8">
                <h3 class="text-warning fw-bold">{{ $location->name }}</h3>
                <p>Chuyên trang số 1 về review Việt Nam</p>

                @foreach($reviews as $review)
                    <div class="card mb-4 bg-transparent border-0">
                        <div class="row g-0">
                            <div class="col-md-4 position-relative">
                                <img src="{{ asset('images/reviews/' . $review->id . '/' . explode(' | ', $review->images)[0]) }}" class="img-fluid rounded horizontal-card-image" alt="{{ $review->$title }}">
                                <p class="position-absolute bg-warning px-2 py-1 rounded fw-bold" style="bottom: -8px; left: 10px; font-size: 14px"><a class="text-black" href="{{ '/category/' . $review->category->slug }}">{{ $review->category->name }}</a></p>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body pt-0">
                                    <h5 class="card-title">{{ $review->title }}</h5>
                                    <p class="card-text truncate-text-3">{{ $review->desc }}</p>
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
