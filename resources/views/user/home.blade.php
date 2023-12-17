@extends('layouts.user')

@section('content')
    @include('user.carousel-posts')

    <div class="container" data-aos-easing="ease-out-back" data-aos-delay="0" data-aos-duration="1000">
        <div class="heading mt-3" data-aos="fade-right">
            <h5>ĐỊA ĐIỂM NỔI BẬT</h5>
        </div>
        <div class="row mt-4 mx-1">
            @foreach ($bestPlacePosts->take(3) as $post)
                <div class="col-md-4 col-lg-4 col-xl-4 px-3" data-aos="fade-right">
                    <a href="{{ route('post', $post->slug) }}">
                        <img src="{{ $post->first_image }}" class="img-fluid home-img"></a>
                    <div class="my-2">
                        <a href="{{ route('post', $post->slug) }}" class="home-title-img">{{ $post->title }}</a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row mt-4 mx-1">
            @foreach ($bestPlacePosts->slice(3) as $key => $post)
                <div class="col-md-4 col-lg-4 col-xl-4 px-3" data-aos="fade-right">
                    <a href="{{ route('post', $post->slug) }}">
                        <img src="{{ $post->first_image }}" class="img-fluid home-img"></a>
                    <div class="my-2">
                        <a href="{{ route('post', $post->slug) }}" class="home-title-img">{{ $post->title }}</a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="heading mt-3" data-aos="fade-down">
            <h5>NHIỀU NGƯỜI QUAN TÂM</h5>
        </div>

        <div class="row mt-4 mx-3">
            <div class="col-md-3 col-lg-3 col-xl-3" data-aos="fade-down-right">
                @foreach ($bestViewPosts->slice(1, 2) as $post)
                    <div class="row">
                        <a href="{{ route('post', $post->slug) }}">
                            <img src="{{ $post->first_image }}" class="img-fluid home-img-small"></a>
                        <div class="my-2">
                            <a href="{{ route('post', $post->slug) }}" class="home-title-img">{{ $post->title }}</a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="col-md-6 col-lg-6 col-xl-6 d-flex align-items-center">
                <div class="row flex-fill" data-aos="flip-down">
                    <div class="col-md-12 col-lg-12 col-xl-12">
                        <a href="{{ route('post', $bestViewPosts[0]->slug) }}">
                            <img src="{{ $bestViewPosts[0]->first_image }}" class="img-fluid home-img"></a>
                        <div class="my-2 text-center">
                            <a href="{{ route('post', $bestViewPosts[0]->slug) }}"
                                class="home-title-img">{{ $bestViewPosts[0]->title }}</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-lg-3 col-xl-3" data-aos="fade-down-left">
                @foreach ($bestViewPosts->slice(3) as $post)
                    <div class="row">
                        <a href="{{ route('post', $post->slug) }}">
                            <img src="{{ $post->first_image }}" class="img-fluid home-img-small"></a>
                        <div class="my-2">
                            <a href="{{ route('post', $post->slug) }}" class="home-title-img">{{ $post->title }}</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="heading mt-3" data-aos="zoom-in-down">
            <h5>BÀI VIẾT MỚI NHẤT</h5>
        </div>
        <div class="row mt-4 mx-1">
            @foreach ($latestPosts->take(3) as $post)
                <div class="col-md-4 col-lg-4 col-xl-4 px-3" data-aos="zoom-in">
                    <a href="{{ route('post', $post->slug) }}">
                        <img src="{{ $post->first_image }}" class="img-fluid home-img"></a>
                    <div class="my-2">
                        <a href="{{ route('post', $post->slug) }}" class="home-title-img">{{ $post->title }}</a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row mt-4 mx-1">
            @foreach ($latestPosts->slice(3) as $key => $post)
                <div class="col-md-4 col-lg-4 col-xl-4 px-3" data-aos="zoom-in">
                    <a href="{{ route('post', $post->slug) }}">
                        <img src="{{ $post->first_image }}" class="img-fluid home-img"></a>
                    <div class="my-2">
                        <a href="{{ route('post', $post->slug) }}" class="home-title-img">{{ $post->title }}</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
