<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Location;
use Livewire\WithPagination;

class AllLocations extends Component
{
    use WithPagination;
    public $search;
    public $checkedRecords = [];
    public $checkedAllRecords = false;

    public function render()
    {
        return view('livewire.all-locations',[
            'all_location' => location::where('id', 'like', "%{$this->search}%")->paginate(3),
        ]);
    }

    public function searching()
    {
        $this->resetPage();
    }

    public function checkAll()
    {
        if ($this->checkedAllRecords) {
            $comments = location::all();
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
        $comment = location::where('id', $id)->firstOrFail();
        if ($comment->status) {
            $comment->update(['is_active' => 0]);
        } else {
            $comment->update(['is_active' => 1]);
        }

        $this->resetPage();
    }

    public function editRecord($id)
    {
        $this->redirect('edit-location/' . $id);
    }

    public function deleteRecord($id)
    {
        location::whereKey($id)->delete();
    }

    public function deleteRecords()
    {
        location::whereKey($this->checkedRecords)->delete();

        $this->checkedRecords = [];
    }
}
