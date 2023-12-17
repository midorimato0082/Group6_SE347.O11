<?php

namespace App\Livewire\User;

use App\Models\Comment;
use App\Models\CommentLike;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class LoadComment extends Component
{
    public $comment;
    public $isLike, $isReplied;
    public $repliesCount;
    public $showCommentForm = false;
    public $showReplies = false;

    public function mount()
    {
        $this->isLike = CommentLike::where('user_id', Auth::user()->id)->where('comment_id', $this->comment->id)->first() ? true : false;
        $this->isReplied = Comment::where('user_id', Auth::user()->id)->where('reply_id', $this->comment->id)->first() ? true : false;
        $this->repliesCount = $this->comment->replies->count();
    }

    public function render()
    {
        return view('livewire.user.load-comment');
    }

    public function like()
    {

        if ($this->isLike) {
            Auth::user()->commentlikes->where('pivot.comment_id', $this->comment->id)->first()->pivot->delete();
            $this->isLike = false;
            $this->comment->likes_count--;
        } else {
            CommentLike::create([
                'user_id' => Auth::user()->id,
                'comment_id' => $this->comment->id
            ]);

            $this->isLike = true;
            $this->comment->likes_count++;
        }
    }

    public function showComment()
    {
        $this->showCommentForm = !$this->showCommentForm;
    }

    public function displayReplies()
    {
        $this->showReplies = !$this->showReplies;
    }

    #[On('save-new-reply-comment')]
    public function save()
    {
        $this->isReplied = true;
        $this->repliesCount++;
        $this->showCommentForm = false;
        $this->showReplies = true;
    }

    public function delete()
    {
        foreach ($this->comment->replies as $reply) {
            foreach ($reply->likes as $like)
                $like->pivot->delete();

            $reply->delete();
        }

        foreach ($this->comment->likes as $like)
            $like->pivot->delete();

        $this->comment->delete();
        $this->dispatch('delete-comment', number: $this->repliesCount + 1);
    }
}
