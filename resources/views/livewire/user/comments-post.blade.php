<div class="mt-4 me-3">
    <h5 class="fw-bold">{{ $commentTotal }} bình luận</h5>

    {{-- Nhập comment --}}
    <div class="card mt-3">
        <div class="card-body">
            <livewire:user.comment-form :postId="$post->id" />
        </div>
    </div>

    @auth
        {{-- Hiển thị tất cả comments --}}
        @foreach ($comments as $comment)
            <livewire:user.load-comment :$comment :key="$comment->id" />
        @endforeach

        {{-- Nút tải thêm comment --}}
        @if ($comments->count() != $comments->total())
            <div class="text-center mt-3">
                <button wire:click="loadMore" class="btn btn-long w-100"><b>Tải thêm bình luận</b></button>
            </div>
        @endif
    @else
        <div class="text-center mt-3">
            <a href="{{ route('login') }}" class="text-center">Đăng nhập </a>
            để xem bình luận
        </div>

    @endauth
</div>
