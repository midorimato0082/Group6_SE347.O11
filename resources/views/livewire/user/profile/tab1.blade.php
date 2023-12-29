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
                <b class="small">
                    <span data-bs-toggle="tooltip" title="Lượt thích">
                        <i class="fa fa-thumbs-up"></i>
                        {{ $comment->likes_count }}
                    </span>

                    <span data-bs-toggle="tooltip" title="Phản hồi">
                        <i class="fa fa-reply ms-3"></i>
                        {{ $comment->replies->count() }}
                    </span>

                    <span class="ms-3">
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
