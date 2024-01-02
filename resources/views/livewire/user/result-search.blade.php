<div class="container">
    <div class="row mt-4">
        @forelse ($this->posts as $post)
            <div class="col-md-3 col-lg-3 col-xl-3 px-3">
                <a href="{{ route('post', $post->slug) }}">
                    <img src="{{ $post->first_image }}" class="img-fluid home-img-small" alt="{{ 'Review Travel - ' . $post->title }}"></a>
                <div class="my-2">
                    <a href="{{ route('post', $post->slug) }}" class="home-title-img">{{ $post->title }}</a>
                </div>
            </div>
        @empty
        <div class="text-center fw-bold">
            Không có kết quả phù hợp
        </div>
        @endforelse
    </div>
</div>
