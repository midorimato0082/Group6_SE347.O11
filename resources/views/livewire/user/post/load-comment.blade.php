<div class="card-transparent text-dark" x-data="{ edit: false }">
    <div class="card-body p-4">
        <div class="d-flex">
            <img class="rounded-circle shadow-1-strong me-3" src="{{ $comment->user->avatar_url }}" alt="Avatar Review Travel"
                width="60" height="60" />
            <div class="flex-fill">
                <div class="d-flex show-comment">
                    <h6 class="fw-bold text-dark mb-1 me-auto">
                        {{ $comment->user->full_name }}
                        @if ($comment->user->is_admin)
                            <span data-bs-toggle="tooltip" title="Admin">
                                <i class="fa-solid fa-gear fa-sm"></i>
                            </span>
                        @endif
                    </h6>
                    @can('delete', $comment)
                        <a wire:click.prevent="delete">
                            <i class="fa fa-window-close fa-md"></i>
                        </a>
                    @endcan
                </div>
                <p class="text-muted small mb-0">{{ $comment->updated_time }}</p>
                <p class="mt-2">
                    {{ $comment->content }}
                </p>

                <div class="small d-flex justify-content-start cmt">
                    <a wire:click.prevent="like" @class(['d-flex align-items-center me-3', 'comment-liked' => $isLike]) data-bs-toggle="tooltip"
                        title="{{ $isLike ? 'Bỏ thích' : 'Thích' }}">
                        <i class="fa-regular fa-thumbs-up me-2"></i>
                        <p class="mb-0">{{ $comment->likes_count }}</p>
                    </a>
                    <a wire:click.prevent="showComment" @class([
                        'd-flex align-items-center me-3',
                        'comment-replied' => $isReplied,
                    ])>
                        <i class="far fa-comment-dots me-2"></i>
                        <p class="mb-0">Phản hồi</p>
                    </a>
                </div>

                @if ($showCommentForm)
                    <div class="mt-3">
                        <livewire:user.post.comment-form :postId="$comment->post_id" :replyId="$comment->id" />
                    </div>
                @endif

                @if ($repliesCount)
                    <button wire:click="displayReplies" type="button" class="btn btn-link ps-0 mt-2">
                        <i class="fa {{ $showReplies ? 'fa-angle-down' : 'fa-angle-up' }}"></i>
                        Xem {{ $repliesCount }} phản hồi
                    </button>
                @endif

                @if ($showReplies)
                    @forelse($comment->replies as $reply)
                        <livewire:user.post.load-comment :comment="$reply" :key="$reply->id" />
                    @empty
                    @endforelse
                @endif
            </div>
        </div>
    </div>
</div>