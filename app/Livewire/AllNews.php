<?php

namespace App\Livewire;

use App\Models\News;
use Livewire\Component;
use Livewire\WithPagination;

class AllNews extends Component
{
    use WithPagination;

    public $search;
    public $checkedRecords = [];
    public $checkedAllRecords = false;
    public function render()
    {
        return view('livewire.all-news', [
            'news' => News::where('title', 'like', "%{$this->search}%")->paginate(3),
        ]);
    }

    public function searching()
    {
        $this->resetPage();
    }

    public function checkAll()
    {
        if ($this->checkedAllRecords) {
            $comments = News::all();
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
        $comment = News::where('id', $id)->firstOrFail();
        if ($comment->status) {
            $comment->update(['is_active' => 0]);
        } else {
            $comment->update(['is_active' => 1]);
        }

        $this->resetPage();
    }

    public function editRecord($id)
    {
        $this->redirect('edit-news/' . $id);
    }

    public function deleteRecord($id)
    {
        News::whereKey($id)->delete();
    }

    public function deleteRecords()
    {
        News::whereKey($this->checkedRecords)->delete();

        $this->checkedRecords = [];
    }
}
