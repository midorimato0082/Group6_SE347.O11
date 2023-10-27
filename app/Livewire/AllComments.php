<?php

namespace App\Livewire;

use App\Models\Comment;
use Livewire\Component;
use Livewire\WithPagination;

class AllComments extends Component
{
    use WithPagination;

    public $search;
    public $checkedRecords = [];
    public $checkedAllRecords = false;
    public function render()
    {
        return view('livewire.all-comments', [
            'comments' => Comment::where('content', 'like', "%{$this->search}%")->paginate(3),
        ]);
    }

    public function searching()
    {
        $this->resetPage();
    }

    public function checkAll()
    {
        if ($this->checkedAllRecords) {
            $comments = Comment::all();
            foreach ($comments as $comment) {
                $this->checkedRecords[] = $comment->id;
            }
        } else {
            $this->checkedRecords = [];
        }

        $this->resetPage();
    }

    public function changeStatus($id)
    {
        $comment = Comment::where('id', $id)->firstOrFail();
        if ($comment->status) {
            $comment->update(['is_active' => 0]);
        } else {
            $comment->update(['is_active' => 1]);
        }

        $this->resetPage();
    }

    public function deleteRecord($id)
    {
        Comment::whereKey($id)->delete();
    }

    public function deleteRecords()
    {
        Comment::whereKey($this->checkedRecords)->delete();

        $this->checkedRecords = [];
    }
}
