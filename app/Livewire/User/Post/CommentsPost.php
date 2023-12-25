<?php

namespace App\Livewire\User\Post;

use App\Models\Comment;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class CommentsPost extends Component
{
    use WithPagination;

    public $post;
    public $commentTotal;
    public $commentsPer = 3;

    public function mount()
    {
        $this->commentTotal = Comment::where('is_active', true)->where('post_id', $this->post->id)->count();
    }

    public function render()
    {
        return view('livewire.user.post.comments-post');
    }

    #[Computed]
    public function comments()
    {
        return Comment::where('is_active', true)->where('post_id', $this->post->id)->where('reply_id', null)->latest()->paginate($this->commentsPer);
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