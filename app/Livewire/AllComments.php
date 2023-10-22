<?php

namespace App\Livewire;

use App\Models\Comment;
use Livewire\Component;

class AllComments extends Component
{
    public $comments = [];

    public function render()
    {
        $this->comments = Comment::all();
        return view('livewire.all-comments', ['comments' => $this->comments]);
    }

    public function getCommentsProperty()
    {
        return $this->commentsQuery->paginate(3);
    }

}
