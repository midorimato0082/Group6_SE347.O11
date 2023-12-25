<div>
    @foreach ($this->comments as $comment)
        <div class="d-flex mb-2">
            <a href="{{ route('post', $comment->post->slug) }}">
                <img src="{{ $comment->post->first_image }}">
            </a>
            <div class="flex-fill ms-2">
                <a href="{{ route('post', $comment->post->slug) }}" class="text-black">
                    <strong class="card-title fw-bold mt-01">
                        {{ $comment->post->title }}
                    </strong>
                </a>
                <p class="mt-1 mb-1">
                    {{ $comment->content }}
                </p>
                <p class="text-muted small mb-0">{{ $comment->created_time }}</p>
                <b class="text-muted small">
                    Có {{ $comment->likes_count }} người thích
                    <span class="ms-2">
                        Có {{ $comment->replies->count() }} phản hồi
                    </span>

                    <span class="ms-2">
                        @if ($comment->is_active)
                            <i class="fa fa-circle text-success"></i>
                            Đang hiển thị
                        @else
                            <i class="fa fa-circle text-danger"></i>
                            Đã ẩn
                        @endif

                    </span>
                </b>
            </div>
        </div>
    @endforeach
</div>
