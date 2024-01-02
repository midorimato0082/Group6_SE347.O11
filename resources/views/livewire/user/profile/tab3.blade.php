<div>
    @foreach ($this->postLikes as $post)
        <div class="d-flex mb-2">
            <a href="{{ route('post', $post->slug) }}">
                <img src="{{ $post->first_image }}" alt="{{ 'Review Travel - ' . $post->title }}">
            </a>
            <div class="flex-fill ms-2">
                <a href="{{ route('post', $post->slug) }}" class="text-black">
                    <strong class="card-title fw-bold mt-01">
                        {{ $post->title }}
                    </strong>
                </a>
                <p class="small mt-3">
                    @if ($post->likes->where('id', Auth::user()->id)->first()->pivot->is_like)
                        <i class="fa fa-thumbs-up"></i>
                        Thích
                    @else
                        <i class="fa fa-thumbs-down"></i>
                        Không Thích
                    @endif
                </p>
            </div>
        </div>
    @endforeach
</div>
