@extends('layouts.user')

@section('content')
    @include('user.carousel-reviews')

    {{-- Code nội dung tiếp theo ở đây --}}
    @if (! empty($reviews))
        <div class="card mx-auto my-3">
            <div class="card-header">
                <h5 class="card-title text-center">NHIỀU NGƯỜI QUAN TÂM</h5>
            </div>
            <div class="card-body flex-container">
                @foreach ($reviews as $review)
                    <div
                        @class([
                            'row flex-item',
                            'mt-3'
                        ])
                    >
                        <div class="card-desc">
                            <img src="{{ asset('images/reviews/' . $review->id . '/' . explode(' | ', $review->images)[0]) }}" class="image-card-dashboard img-fluid rounded-start">
                            <p title="{{ $review->title }}" class="card-title truncate-text-2">{{ $review->title }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if (! empty($news))
        <div class="card mx-auto my-3">
            <div class="card-header">
                <h5 class="card-title text-center">TIN TỨC MỚI NHẤT</h5>
            </div>
            <div class="card-body flex-container-reverse">
                @foreach ($news as $new)
                    <div
                        @class([
                            'row flex-item',
                            'mt-3'
                        ])
                    >
                        <div class="card-desc">
                            <img src="{{ asset('images/news/' . $new->id . '/' . explode(' | ', $new->images)[0]) }}" class="image-card-dashboard img-fluid rounded-start">
                            <p title="{{ $new->title }}" class="card-title truncate-text-2">{{ $new->title }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection
