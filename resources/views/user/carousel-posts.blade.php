<div id="carousel" class="container mt-4 carousel carousel-dark slide" data-bs-ride="carousel">
    @if ($carouselPosts->count() != 0)
        <div class="carousel-indicators">
            @foreach ($carouselPosts as $key => $post)
                <button type="button" data-bs-target="#carousel" data-bs-slide-to="{{ $key }}"
                    class="{{ $key == 0 ? 'active' : '' }}"></button>
            @endforeach
        </div>

        <div class="carousel-inner rounded-2">
            @foreach ($carouselPosts as $key => $post)
                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}" data-bs-interval="3000">
                    <img src="{{ $post->first_image }}" class="d-block w-100" alt="{{ 'Review Travel Group 6 SE347.O11 - ' . $post->title }}">
                    <div class="carousel-caption">
                        <a href="{{ route('post', $post->slug) }}">
                            <h2>{{ $post->title }}</h2>
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
    @endif
</div>
