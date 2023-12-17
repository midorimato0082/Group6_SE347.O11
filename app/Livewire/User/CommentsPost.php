<?php

namespace App\Livewire\User;

use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class CommentsPost extends Component
{
    use WithPagination;

    public $post;
    public $commentTotal;
    public $commentsPer = 3;

    // public $newComment;
    // public $replyId;

    public function mount()
    {
        $this->commentTotal = Comment::where('post_id', $this->post->id)->where('is_active', 1)->count();
    }

    public function render()
    {
        $comments = Comment::where('post_id', $this->post->id)->where('reply_id', null)->latest()->paginate($this->commentsPer);

        return view('livewire.user.comments-post', ['comments' => $comments]);
    }

    #[On('save-new-comment')]
    public function save()
    {
        $this->commentTotal++;
        $this->commentsPer++;
    }

    #[On('delete-comment')]
    public function delete($number)
    {
        $this->commentTotal -= $number;
    }

    public function loadMore()
    {
        $this->commentsPer += 3;
    }
}
