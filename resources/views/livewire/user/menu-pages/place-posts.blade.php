<div>
    <div class="tag">
        <button wire:click="setSortBy('created_at')" @class(['badge', 'focus' => $sortBy === 'created_at']) @disabled($sortBy === 'created_at')>
            Mới nhất
        </button>

        <button wire:click="setSortBy('view_count')" @class(['badge', 'focus' => $sortBy === 'view_count'])>
            Lượt xem
            <i
                class="ms-1 fa-solid fa-sm {{ $sortBy !== 'view_count' ? 'fa-sort' : ($sortDirection === 'asc' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt') }}"></i>
        </button>

        <button wire:click="setSortBy('like_count')" @class(['badge', 'focus' => $sortBy === 'like_count'])>
            Lượt thích
            <i
                class="ms-1 fa-solid fa-sm {{ $sortBy !== 'like_count' ? 'fa-sort' : ($sortDirection === 'asc' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt') }}"></i>
        </button>

        <button wire:click="setSortBy('comments_count')" @class(['badge', 'focus' => $sortBy === 'comments_count'])>
            Lượt bình luận
            <i
                class="ms-1 fa-solid fa-sm {{ $sortBy !== 'comments_count' ? 'fa-sort' : ($sortDirection === 'asc' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt') }}"></i>
        </button>
    </div>

    <div>
        @foreach ($this->posts as $post)
            <div class="card mt-4 bg-transparent border-0 menu" wire:key="row-{{ $post->id }}">
                <div class="row g-0">
                    <div class="col-md-4 position-relative">
                        <a href="{{ route('post', $post->slug) }}">
                            <img src="{{ $post->first_image }}" class="img-fluid horizontal-card-image"
                                alt="{{ 'Review Travel Group 6 SE347.O11 - ' . $post->title }}">
                        </a>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body pt-0">
                            <a href="{{ route('post', $post->slug) }}" class="text-black">
                                <h5 class="card-title fw-bold mt-01">{{ $post->title }}</h5>
                            </a>
                            <p class="card-text mb-2">{{ str($post->desc)->words(30) }}</p>
                            <p class="small fw-bold mb-2">
                                <span data-bs-toggle="tooltip" title="Lượt xem">
                                    <i class="fa fa-eye"></i>
                                    {{ $post->view_count }}
                                </span>
                                <span data-bs-toggle="tooltip" title="Lượt thích">
                                    <i class="fa fa-thumbs-up ms-3"></i>
                                    {{ $post->like_count }}
                                </span>
                                <span data-bs-toggle="tooltip" title="Lượt bình luận">
                                    <i class="fa-solid fa-comment ms-3"></i>
                                    {{ $post->comments_count }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        @if ($this->posts->count() != $this->posts->total())
            <div class="text-center mt-4">
                <button wire:click="loadMore" class="btn btn-long w-100"><b>Tải thêm bài viết</b></button>
            </div>
        @endif
    </div>
</div>