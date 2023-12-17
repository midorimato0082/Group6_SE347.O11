<?php

namespace App\Livewire\User;

use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CommentForm extends Component
{
    public $postId;
    public $newComment;
    public $replyId;

    public function render()
    {
        return view('livewire.user.comment-form');
    }

    public function save()
    {
        if ($this->newComment) {
            Comment::create([
                'content' => $this->newComment,
                'user_id' => Auth::user()->id,
                'post_id' => $this->postId,
                'reply_id' => $this->replyId
            ]);

            if($this->replyId) {
                $this->dispatch('save-new-reply-comment');
            }

            $this->dispatch('save-new-comment');

        } else $this->addError('comment', 'Bạn chưa nhập bình luận.');

        $this->reset('newComment');
    }

    public function clear() {
        $this->reset('newComment');
        $this->clearValidation();
    }
}
