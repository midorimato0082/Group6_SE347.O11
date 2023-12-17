<div class="btn-group">
    <button wire:click="like" type="button" class="btn {{ $isLike ? 'btn-liked' : 'btn-like' }}" data-bs-toggle="tooltip"
        title="{{ $isLike ? 'Bỏ thích' : 'Thích bài viết' }}">
        <i class="fas fa-lg fa-thumbs-up"></i>
        <span class="ms-1">{{ $likeCount }}</span>
    </button>
    <button wire:click="dislike" type="button" class="btn {{ $isLike === false ? 'btn-liked' : 'btn-like' }}"
        data-bs-toggle="tooltip" title="{{ $isLike === false ? 'Bỏ không thích' : 'Không thích bài viết' }}">
        <i class="fas fa-lg fa-thumbs-down fa-flip-horizontal"></i>
        <span class="ms-1">{{ $dislikeCount }}</span>
    </button>
</div>
