<?php

namespace App\Livewire;

use App\Models\Comment;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class AllComments extends Component
{
    use WithPagination;

    public $keyword;
    public $filter;
    public $checkedRecords = [];
    public $checkedPage = false;
    public $checkedAllRecords = false;
    public $commentId;

    public function render()
    {
        return view('livewire.all-comments', ['comments' => $this->comments]);
    }

    public function getCommentsQueryProperty()
    {
        $query = Comment::query();

        switch ($this->filter) {
            case ('review'):
                $query->where('news_id', null);
                break;
            case ('news'):
                $query->where('review_id', null);
                break;
            default:
                $query->where('is_active', 'LIKE',  '%' . $this->filter . '%');
                break;
        }

        return $query->search(trim($this->keyword))->orderBy('id', 'DESC');
    }

    public function getCommentsProperty()
    {
        return $this->commentsQuery->paginate(4);
    }

    public function updatedCheckedPage($value)
    {
        if ($value) {
            $this->checkedRecords = $this->comments->pluck('id')->toArray();
            $this->checkedAllRecords = false;
        } else
            $this->checkedRecords = [];
    }

    #[On('reset-checked')]
    public function resetChecked()
    {
        $this->reset('checkedPage', 'checkedAllRecords');
    }

    public function resetPageChecked()
    {
        $this->resetPage();
        $this->resetChecked();
    }

    public function updatedCheckedRecords()
    {
        $this->resetChecked();
    }

    public function checkAllRecords()
    {
        $this->checkedAllRecords = true;
        $this->checkedPage = false;
        $this->checkedRecords = $this->commentsQuery->pluck('id')->toArray();
    }

    public function changeStatus($id)
    {
        $comment = Comment::where('id', $id)->firstOrFail();
        $comment->status ? $comment->update(['status' => 0]) : $comment->update(['status' => 1]);
    }

    public function isChecked($id)
    {
        return in_array($id, $this->checkedRecords);
    }

    private function deleteRecords()
    {
        Comment::whereKey($this->checkedRecords)->delete();

        session()->flash('success', 'Những dòng được chọn đã xóa');
    }

    private function deleteRecord()
    {
        Comment::whereKey($this->commentId)->delete();

        session()->flash('success', 'Xóa bình luận thành công.');
    }

    public function delete()
    {
        if ($this->commentId) {
            $this->deleteRecord();
            $this->reset('commentId');
        } else {
            $this->deleteRecords();
            $this->checkedRecords = [];
            $this->resetChecked();
        }

        $this->dispatch('close-modal');

        $this->resetPage();
    }

    public function closeModal()
    {
        $this->reset('commentId');
    }
}
