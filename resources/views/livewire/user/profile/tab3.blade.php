<div>
    @foreach ($this->postLikes as $post)
        <div class="d-flex mb-2">
            <a href="{{ route('post', $post->slug) }}">
                <img src="{{ $post->first_image }}">
            </a>
            <div class="flex-fill ms-2">
                <a href="{{ route('post', $post->slug) }}" class="text-black">
                    <strong class="card-title fw-bold mt-01">
                        {{ $post->title }}
                    </strong>
                </a>
                <p class="text-muted small mt-3">
                    {{ $post->likes->where('id', Auth::user()->id)->first()->pivot->is_like ? 'Thích' : 'Không thích' }}
                </p>
            </div>
        </div>
    @endforeach
</div>

