<div>
    @foreach ($this->posts as $post)
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
                <p class="text-muted small mt-1">{{ $post->created_time }}


                </p>
                <b class="text-muted small mt-0">
                    Có {{ $post->view_count }} lượt xem
                    <span class="ms-2">
                        Có {{ $post->like_count }} người thích
                    </span>

                    <span class="ms-2">
                        Có {{ $post->dislike_count }} người không thích
                    </span>

                    <span class="ms-2">
                        Có {{ $post->comments_count }} bình luận
                    </span>

                    <span class="ms-2">
                        @if ($post->is_active)
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
