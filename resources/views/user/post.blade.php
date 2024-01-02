@extends('layouts.user')

@section('breadcrumn')
    <li class="breadcrumb-item">
        <a href="{{ route('category', $post->category->slug) }}">{{ $post->category->name }}</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8 ps-1">
                {{-- Carousel --}}
                <div id="carousel" class="container mt-4 carousel carousel-dark slide ps-0" data-bs-ride="carousel">
                    <div class="carousel-inner rounded-2">
                        @foreach ($post->getImagesUrl() as $key => $imageUrl)
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}" data-bs-interval="3000">
                                <img src="{{ $imageUrl }}" class="d-block w-100" alt="{{ 'Review Travel - ' . $post->title }}">
                            </div>
                        @endforeach

                        <div class="carousel-caption bottom-0 pb-0">
                            <h2 class="mx-1">{{ $post->title }}</h2>
                            <p class="text-light mt-3">Đăng bởi
                                <a href="{{ route('author', $post->admin->email) }}" data-bs-toggle="tooltip"
                                    title="{{ $post->admin->email }}">
                                    <b>{{ $post->admin->first_name }}</b>
                                </a>

                                <span class="ms-4">Vào ngày
                                    <b>{{ $post->created_time }}</b>
                                </span>
                            </p>
                        </div>
                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>

                {{-- Địa điểm --}}
                @if ($places)
                    <div class="d-flex mt-4 tag align-items-center">
                        <i class="fa-solid fa-paperclip"></i>
                        @foreach ($regions as $region)
                            <a href="{{ route('region', $region->slug) }}" class="badge">{{ $region->name }}</a>
                        @endforeach
                        @foreach ($provinces as $province)
                            <a href="{{ route('province', $province->slug) }}" class="badge">{{ $province->name }}</a>
                        @endforeach
                        @foreach ($districts as $district)
                            <a href="{{ route('district', $district->slug) }}" class="badge">{{ $district->name }}</a>
                        @endforeach
                    </div>
                @endif

                {{-- Share --}}
                <div class="mt-4">
                    <i class="fa fa-share-alt"></i>
                    <b>Chia sẻ bài viết</b>
                    <a href="{{ 'https://www.facebook.com/sharer/sharer.php?u=' . route('post', $post->slug) }}"
                        class="btn btn-share facebook" data-bs-toggle="tooltip" title="Facebook">
                        <i class="fab fa-facebook-f fa-lg"></i>
                    </a>
                    <a href="{{ 'https://twitter.com/intent/tweet?url=' . route('post', $post->slug) }}"
                        class="btn btn-share twitter" data-bs-toggle="tooltip" title="Twitter">
                        <i class="fab fa-twitter fa-lg"></i>
                    </a>
                </div>

                {{-- Content --}}
                <p style="text-align:justify; line-height:1.8rem" class="mt-4 me-3">
                    <span style="color:hsl(0,0%,0%);font-family:Arial, Helvetica, sans-serif">
                        {{ $post->desc }}
                    </span> 
                </p>
                <div class="mt-4 details me-3">
                    {!! $post->content !!}
                </div>

                {{-- Tags --}}
                <div class="mt-4 me-3">
                    <i class="fa fa-tags"></i>
                    @foreach ($post->getTags() as $tag)
                        <a href="{{ route('tag', $tag) }}"
                            class="text-orange fw-bold badge bg-dark">{{ $tag }}</a>
                    @endforeach
                </div>

                {{-- Like --}}
                <div class="mt-4 text-center">
                    @guest
                        <div class="card login-required mb-2 d-none">
                            <div class="card-body mt-3">
                                <p>Bạn cần đăng nhập để có thể thích, đánh giá hoặc bình luận bài viết.
                                    <br>
                                    <a href="{{ route('login') }}">Đăng nhập tại đây.</a>
                                </p>
                                <p>Nếu bạn vẫn chưa có tài khoản, <a href="{{ route('register') }}">hãy đăng ký ở đây</a>.</p>
                            </div>
                        </div>

                        <div id="like" class="btn-group">
                            <button type="button" class="btn btn-like" data-bs-toggle="tooltip" title="Thích bài viết">
                                <i class="fas fa-lg fa-thumbs-up"></i>
                                <span class="ms-1">{{ $post->like_count }}</span>
                            </button>
                            <button type="button" class="btn btn-like" data-bs-toggle="tooltip" title="Không thích bài viết">
                                <i class="fas fa-lg fa-thumbs-down fa-flip-horizontal"></i>
                                <span class="ms-1">{{ $post->dislike_count }}</span>
                            </button>
                        </div>
                    @else
                        <livewire:user.post.like-post :$post />
                    @endguest

                    <p class="mt-3 text-orange fw-bold">Bài viết đã có {{ $post->view_count }} lượt xem.</p>
                </div>

                {{-- Share --}}
                <div class="mt-4">
                    <i class="fa fa-share-alt"></i>
                    <b>Chia sẻ bài viết</b>
                    <a href="{{ 'https://www.facebook.com/sharer/sharer.php?u=' . route('post', $post->slug) }}"
                        class="btn btn-share facebook" data-bs-toggle="tooltip" title="Facebook">
                        <i class="fab fa-facebook-f fa-lg"></i>
                    </a>
                    <a href="{{ 'https://twitter.com/intent/tweet?url=' . route('post', $post->slug) }}"
                        class="btn btn-share twitter" data-bs-toggle="tooltip" title="Twitter">
                        <i class="fab fa-twitter fa-lg"></i>
                    </a>
                </div>

                {{-- Rating --}}
                @if ($places)
                    <div class="mt-4">
                        <i class="fa-solid fa-ranking-star me-1"></i>
                        @auth
                            <i id="required-rating">Bạn đã đến {{ strtolower($post->category->name) }} này rồi?
                                Vui lòng để lại
                                <b>đánh giá</b>
                                góp phần giúp chúng tôi cải thiện nội dung nhé.
                            </i>
                            <i class="d-none result-rating"><b>Đánh giá</b> của những người đã đến
                                {{ strtolower($post->category->name) }}</i>
                            @foreach ($places as $place)
                                <livewire:user.post.rating-place :$place :key="$place->id" />
                            @endforeach
                            <div class="row ms-3 mt-3">
                                <div class="col offset-sm-5 offset-md-4 offset-lg-4 offset-xl-3">
                                    <button id="rating" class="btn btn-sm btn-orange">Đánh giá</button>
                                    <button id="rating-reset" class="btn btn-sm btn-orange d-none">Đánh giá lại</button>
                                </div>
                            </div>
                        @else
                            <i><b>Đánh giá</b> của những người đã đến {{ strtolower($post->category->name) }}</i>
                            @foreach ($places as $place)
                                <div class="row d-flex text-start align-items-center mt-3 ms-3">
                                    <div class="col-sm-5 col-md-4 col-lg-4 col-xl-3">
                                        <i class="fa-solid fa-location-dot me-1"></i>
                                        <a href="{{ route('place', $place->slug) }}"
                                            class="link-place">{{ $place->name }}</a>
                                    </div>
                                    <div class="col-sm-4 col-md-4 col-lg-4 col-xl-3">
                                        <p class="mb-0" data-bs-toggle="tooltip"
                                            title="{{ $place->star . ' - ' . $place->starTooltip }}"
                                            data-bs-placement="left">
                                            {!! str_repeat('<i class="fa fa-star star-color fa-lg me-2"></i>', $place->star) !!}
                                        </p>
                                    </div>
                                    <div class="col">
                                        {{ $place->users->count() }} đánh giá
                                    </div>
                                </div>
                            @endforeach
                        @endauth
                    </div>
                @endif

                {{-- Next & Previous --}}
                <div class="mt-4 border-top border-bottom border-secondary d-flex justify-content-between me-3 next-prev">
                    <div class="row my-3 me-1">
                        <p class="text-secondary fw-bold"><i class="fa fa-arrow-left me-2"></i>Bài tiếp theo</p>
                        <a href="{{ route('post', $post->previous->slug) }}">{{ $post->previous->title }}</a>
                    </div>

                    <div class="row my-3 text-end ms-1">
                        <p class="text-secondary fw-bold">Bài tiếp theo<i class="fa fa-arrow-right ms-2"></i></p>
                        <a href="{{ route('post', $post->next->slug) }}">{{ $post->next->title }}</a>
                    </div>
                </div>

                {{-- Comment --}}
                <livewire:user.post.comments-post :$post />
            </div>

            @livewire('user.post.latest-posts')
        </div>
    </div>
@endsection
