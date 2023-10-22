@extends('templates.admin')

@section('content')
    <div class="card">
        <div class="card-title pt-5">
            <div class="row px-4 gap-5 justify-content-center">
                @if ($users)
                    <div class="card border-primary mb-3 text-center" style="max-width: 14rem;">
                        <div class="card-header">
                            <h5 class="card-title">Tổng số khách hàng</h5>
                        </div>
                        <div class="card-body text-primary">
                            <h2 class="card-title text-center">{{ count($users) }}</h2>
                        </div>
                    </div>
                @endif

                @if ($reviews)
                    <div class="card border-danger mb-3 text-center" style="max-width: 16rem;">
                        <div class="card-header">
                            <h5 class="card-title">Tổng số bài review</h5>
                        </div>
                        <div class="card-body text-danger">
                            <h2 class="card-title text-center">{{ count($reviews) }}</h2>
                        </div>
                    </div>
                @endif

                @if ($news)
                    <div class="card border-info mb-3 text-center" style="max-width: 16rem;">
                        <div class="card-header">
                            <h5 class="card-title">Tổng số tin tức</h5>
                        </div>
                        <div class="card-body text-info">
                            <h2 class="card-title text-center">{{ count($news) }}</h2>
                        </div>
                    </div>
                @endif

                @if ($comments)
                    <div class="card border-dark-subtle mb-3 text-center" style="max-width: 16rem;">
                        <div class="card-header">
                            <h5 class="card-title">Tổng số bình luận</h5>
                        </div>
                        <div class="card-body text-dark-subtle">
                            <h2 class="card-title text-center">{{ count($comments) }}</h2>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="card-body">
            <div class="row gap-5 justify-content-center">
                @if (! empty($news))
                    <div class="card mb-3" style="max-width: 540px;">
                        <div class="card-header">
                            <h5 class="card-title text-center">Tin tức mới nhất</h5>
                        </div>
                        <div class="card-body">
                            @foreach ($news as $new)
                                <div
                                    @class([
                                        'row post-item',
                                        'mt-3' => ! $loop->first
                                    ])
                                >
                                    <div class="col-md-4">
                                        <img src="images/news/{{ $new->images }}" class="image-card-dashboard img-fluid rounded-start" alt="{{ $new->title }}">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 title="{{ $new->title }}" class="card-title truncate-text-2">{{ $new->title }}</h5>
                                            <p title="{{ $new->desc }}" class="card-text truncate-text-3">{{ $new->desc }}</p>
                                            @php($timeDif = now()->diff($new->created_at))
                                            <p class="card-text">
                                                <small class="text-body-secondary">Last updated {{ $timeDif->d ? "$timeDif->d days" : '' }} {{ $timeDif->h ? "$timeDif->h hours" : '' }} {{ $timeDif->i ? "$timeDif->i minutes" : '' }} ago</small>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if (! empty($reviews))
                    <div class="card mb-3" style="max-width: 540px;">
                        <div class="card-header">
                            <h5 class="card-title text-center">Bài đăng mới nhất</h5>
                        </div>
                        <div class="card-body">
                            @foreach ($reviews as $review)
                                <div
                                    @class([
                                        'row post-item',
                                        'mt-3' => ! $loop->first
                                    ])
                                >
                                    <div class="col-md-4" height="220px">
                                        <img src="images/reviews/{{ $review->images }}" class="image-card-dashboard img-fluid rounded-start" alt="{{ $review->title }}">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 title="{{ $review->title }}" class="card-title truncate-text-2">{{ $review->title }}</h5>
                                            <p title="{{ $review->desc }}" class="card-text truncate-text-3">{{ $review->desc }}</p>
                                            @php($timeDif = now()->diff($review->created_at))
                                            <p class="card-text">
                                                <small class="text-body-secondary">Last updated {{ $timeDif->d ? "$timeDif->d days" : '' }} {{ $timeDif->h ? "$timeDif->h hours" : '' }} {{ $timeDif->i ? "$timeDif->i minutes" : '' }} ago</small>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
