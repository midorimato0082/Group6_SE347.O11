<div>
    @foreach ($this->commentLikes as $commentLike)
        <div class="d-flex mb-2">
            <a href="{{ route('post', $commentLike->post->slug) }}">
                <img src="{{ $commentLike->post->first_image }}">
            </a>
            <div class="flex-fill ms-2">
                <a href="{{ route('post', $commentLike->post->slug) }}" class="text-black">
                    <strong class="card-title fw-bold mt-01">
                        {{ $commentLike->post->title }}
                    </strong>
                </a>
                <p class="mt-1 mb-1">
                    {{ $commentLike->content }}
                </p>
                <p class="text-muted small">{{ $commentLike->created_time }}
                    <span class="ms-2">
                        Từ: {{ $commentLike->user->full_name }}
                    </span>
                </p>
            </div>
        </div>
    @endforeach
</div>
