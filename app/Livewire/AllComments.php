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
                $query->whereNull('news_id');
                break;
            case ('news'):
                $query->whereNull('review_id');
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

    public function resetPageChecked()
    {
        $this->resetPage();
        $this->reset('checkedPage');
    }

    public function updatedCheckedPage($value)
    {
        if ($value) {
            $this->checkedRecords = $this->comments->pluck('id')->toArray();
            $this->checkedAllRecords = false;
        } else
            $this->checkedRecords = [];
    }

    public function updatedCheckedRecords()
    {
        $this->reset('checkedPage', 'checkedAllRecords');
    }

    #[On('reset-checked')]
    public function resetChecked()
    {
        $this->reset('checkedPage');
    }

    public function checkAllRecords()
    {
        $this->checkedAllRecords = true;
        $this->checkedPage = false;
        $this->checkedRecords = $this->commentsQuery->pluck('id')->toArray();
    }

    public function isChecked($id)
    {
        return in_array($id, $this->checkedRecords);
    }

    public function changeStatus($id)
    {
        $comment = Comment::where('id', $id)->firstOrFail();
        $comment->is_active ? $comment->update(['is_active' => 0]) : $comment->update(['is_active' => 1]);
    }

    private function deleteRecords()
    {
        foreach ($this->checkedRecords as $commentId)
            $this->deleteRecord($commentId);
    }

    private function deleteRecord($id)
    {
        $comment = Comment::find($id);
        $comment->review_id ? $comment->review->decrement('comment_count', 1) : $comment->news->decrement('comment_count', 1);
        $comment->delete();
    }

    public function delete()
    {
        if ($this->commentId) {
            $this->deleteRecord($this->commentId);
            $this->reset('commentId');
            session()->flash('success', 'Xóa bình luận thành công.');
        } else {
            $this->deleteRecords();
            $this->checkedRecords = [];
            $this->resetChecked();
            session()->flash('success', 'Những dòng được chọn đã xóa');
        }

        $this->dispatch('close-modal');

        $this->resetPage();
    }

    public function closeModal()
    {
        $this->reset('commentId');
    }
}
