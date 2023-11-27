<div class="col mt-4 latest-reviews">
    <h4 class="mb-4 fw-bold">Bài viết gần đây</h4>
    @foreach ($reviews as $review)
        <a href="{{ url('/review/' . $review->slug) }}" class="text-black">
            <img src="{{ asset('images/reviews/' . $review->id . '/' . explode(' | ', $review->images)[0]) }}">
            <h5 class="mt-3 fw-bold">{{ $review->title }}</h5>
        </a>
        <p>{{ $review->desc }}</p>
    @endforeach
</div>
