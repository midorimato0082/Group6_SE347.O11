<div id="carousel" class="container mt-4 carousel carousel-dark slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        @foreach ($reviewsCarousel as $key => $review)
            <button type="button" data-bs-target="#carousel" data-bs-slide-to="{{ $key }}"
                class="{{ $key == 0 ? 'active' : '' }}"></button>
        @endforeach
    </div>

    <div class="carousel-inner rounded-2">
        @foreach ($reviewsCarousel as $key => $review)
            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}" data-bs-interval="3000">
                <img src="{{ $review->getFirstImageUrl() }}"
                    class="d-block w-100">
                <div class="carousel-caption d-none d-md-block">
                    <a href="{{ url('/review/' . $review->slug) }}">
                        <h2>{{ $review->title }}</h2>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>