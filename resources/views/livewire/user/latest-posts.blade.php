<div class="col mt-4 page-content-right latest-posts">
    <h4 class="mb-4 fw-bold">Bài viết gần đây</h4>
    @foreach ($posts as $post)
        <a href="{{ route('post', $post->slug) }}" class="text-black">
            <img src="{{ $post->first_image }}">
            <h5 class="mt-3 fw-bold">{{ $post->title }}</h5>
        </a>
        <p>{{ $post->desc }}</p>
    @endforeach
</div>
