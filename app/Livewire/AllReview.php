<?php

namespace App\Livewire;

use App\Models\Review;
use Livewire\Component;
use Livewire\WithPagination;

class AllReview extends Component
{
    use WithPagination;

    public $search;
    public $checkedRecords = [];
    public $checkedAllRecords = false;
    public function render()
    {
        return view('livewire.all-review', [
            'reviews' => Review::where('title', 'like', "%{$this->search}%")->paginate(3),
        ]);
    }

    public function searching()
    {
        $this->resetPage();
    }

    public function checkAll()
    {
        if ($this->checkedAllRecords) {
            $comments = Review::all();
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
        $comment = Review::where('id', $id)->firstOrFail();
        if ($comment->status) {
            $comment->update(['status' => 0]);
        } else {
            $comment->update(['status' => 1]);
        }

        $this->resetPage();
    }

    public function editRecord($id)
    {
        $this->redirect('edit-review/' . $id);
    }

    public function deleteRecord($id)
    {
        Review::whereKey($id)->delete();
    }

    public function deleteRecords()
    {
        Review::whereKey($this->checkedRecords)->delete();

        $this->checkedRecords = [];
    }
}
