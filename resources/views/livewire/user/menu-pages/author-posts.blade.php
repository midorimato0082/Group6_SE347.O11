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

        <button wire:click="setSortBy('min_price')" @class(['badge', 'focus' => $sortBy === 'min_price'])>
            Giá
            <i
                class="ms-1 fa-solid fa-sm {{ $sortBy !== 'min_price' ? 'fa-sort' : ($sortDirection === 'asc' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt') }}"></i>
        </button>

        <button wire:click="setSortBy('star')" @class(['badge', 'focus' => $sortBy === 'star'])>
            Sao
            <i
                class="ms-1 fa-solid fa-sm {{ $sortBy !== 'star' ? 'fa-sort' : ($sortDirection === 'asc' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt') }}"></i>
        </button>
    </div>

    <div>
        @foreach ($this->posts as $post)
            <div class="card mt-4 bg-transparent border-0 menu" wire:key="row-{{ $post->id }}">
                <div class="row g-0">
                    <div class="col-md-4 position-relative">
                        <a href="{{ route('post', $post->slug) }}">
                            <img src="{{ $post->first_image }}" class="img-fluid horizontal-card-image"
                                alt="{{ 'Review Travel - ' . $post->title }}">
                        </a>

                        @if ($post->best_star_place)
                            <div class="overlay-0">
                                <a href="{{ route('province', $post->best_star_place->district->province->slug) }}">
                                    {{ $post->best_star_place->district->province->name }}
                                </a>
                            </div>
                        @endif
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
                                <span data-bs-toggle="tooltip" title="Giá" data-bs-placement="right">
                                    <i class="fa-solid fa-sack-dollar ms-3"></i>
                                    {!! $post->formatRangePrice($post->min_price, $post->max_price) !!}
                                </span>
                            </p>
                            @if ($post->best_star_place)
                                <p class="mb-0" data-bs-toggle="tooltip"
                                    title="{{ $post->best_star_place->star . ' - ' . $post->best_star_place->starTooltip }}"
                                    data-bs-placement="left">
                                    {!! str_repeat('<i class="fa fa-star star-color fa-lg"></i>', $post->best_star_place->star) !!}
                                </p>
                            @endif
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