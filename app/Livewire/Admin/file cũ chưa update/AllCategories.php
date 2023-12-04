<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;

class AllCategories extends Component
{
    use WithPagination;
    public $search;
    public $checkedRecords = [];
    public $checkedAllRecords = false;

    public function render()
    {
        return view('livewire.admin.all-categories',[
            'all_category' => Category::where('id', 'like', "%{$this->search}%")->paginate(3),
        ]);
    }

    public function searching()
    {
        $this->resetPage();
    }

    public function checkAll()
    {
        if ($this->checkedAllRecords) {
            $comments = Category::all();
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
        $comment = Category::where('id', $id)->firstOrFail();
        if ($comment->status) {
            $comment->update(['is_active' => 0]);
        } else {
            $comment->update(['is_active' => 1]);
        }

        $this->resetPage();
    }

    public function editRecord($id)
    {
        $this->redirect('edit-category/' . $id);
    }

    public function deleteRecord($id)
    {
        Category::whereKey($id)->delete();
    }

    public function deleteRecords()
    {
        Category::whereKey($this->checkedRecords)->delete();

        $this->checkedRecords = [];
    }
}
