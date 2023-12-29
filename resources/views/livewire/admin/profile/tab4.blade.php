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
                <b class="small mt-0">
                    <span data-bs-toggle="tooltip" title="Lượt xem">
                        <i class="fa fa-eye"></i>
                        {{ $post->view_count }}
                    </span>

                    <span data-bs-toggle="tooltip" title="Lượt thích">
                        <i class="fa fa-thumbs-up ms-3"></i>
                        {{ $post->like_count }}
                    </span>

                    <span data-bs-toggle="tooltip" title="Lượt không thích">
                        <i class="fa fa-thumbs-down ms-3"></i>
                        {{ $post->dislike_count }}
                    </span>

                    <span data-bs-toggle="tooltip" title="Lượt bình luận">
                        <i class="fa-solid fa-comment ms-3"></i>
                        {{ $post->comments_count }}
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
