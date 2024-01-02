@extends('layouts.admin')

@section('content')
    <div class="row dashboard">
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-header">Số lượng user</div>
                <div class="card-body">
                    <h1 class="card-title">{{ $numberUser }}</h1>
                </div>
                <div class="card-footer">
                    User mới trong ngày:
                    <span>{{ $numberNewUser }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-header">Số lượng bài viết</div>
                <div class="card-body">
                    <h1 class="card-title">{{ $numberPost }}</h1>
                </div>
                <div class="card-footer">
                    Bài viết mới trong ngày:
                    <span>{{ $numberNewPost }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-header">Số lượng bình luận</div>
                <div class="card-body">
                    <h1 class="card-title">{{ $numberComment }}</h1>
                </div>
                <div class="card-footer">
                    Bình luận mới trong ngày:
                    <span>{{ $numberNewComment }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-header">Số lượt thích</div>
                <div class="card-body">
                    <h1 class="card-title">{{ $numberLike }}</h1>
                </div>
                <div class="card-footer">
                    Lượt thích mới trong ngày:
                    <span>{{ $numberNewLike }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4 dashboard2">
        <div class="col-xl-6">
            <h2 class="fw-bold text-center">Bình luận mới</h2>
            @foreach ($comments as $comment)
                <div class="card mb-2">
                    <div class="card-body d-flex">
                        <div class="flex-shrink-0">
                            <img class="rounded-circle shadow-1-strong" src="{{ $comment->user->avatar_url }}"
                                alt="Review Travel Group 6 SE347.O11 - Avatar" width="60" height="60" />
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <b>{{ $comment->user->full_name }}</b>
                            @if ($comment->user->is_admin)
                                <span data-bs-toggle="tooltip" title="Admin">
                                    <i class="fa-solid fa-gear fa-sm" style="font-size: 0.7rem"></i>
                                </span>
                            @endif
                            <p class="text-mute small mb-2">{{ $comment->created_time }}</p>
                            <p class="mb-2">{{ $comment->content }}</p>
                            <a href="{{ route('post', $comment->post->slug) }}" class="small fw-bold">
                                {{ $comment->post->title }}
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="col-xl-6">
            <h2 class="fw-bold text-center">Bài viết mới</h2>
            @foreach ($posts as $post)
                <div class="card mb-2">
                    <div class="card-body d-flex">
                        <div class="flex-shrink-0 dashboard-img">
                            <a href="{{ route('post', $post->slug) }}">
                                <img src="{{ $post->first_image }}"
                                alt="{{ 'Review Travel Group 6 SE347.O11 - ' . $post->title }}" />
                            </a>                           
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <a href="{{ route('post', $post->slug) }}" class="fw-bold">
                                {{ $post->title }}
                            </a>
                            <p class="text-mute small mb-2">
                                Đăng bởi: {{ $post->admin->full_name }}
                                <span class="ms-2">
                                    {{ $post->created_time }}
                                </span>
                            </p>
                            <p class="small mb-1">
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
            @endforeach
        </div>
    </div>
@endsection
