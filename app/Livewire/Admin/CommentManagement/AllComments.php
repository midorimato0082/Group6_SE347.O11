<?php

namespace App\Livewire\Admin\CommentManagement;

use App\Exports\CommentsExport;
use App\Models\Comment;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class AllComments extends Component
{
    use WithPagination;

    public $perPage = 5;

    #[Url(except: '')]
    public $search = '';

    public $filterStatus, $createdFrom, $createdTo;

    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    public $checkedRecords = [];
    public $checkedPageRecords = false;
    public $checkedAllRecords = false;

    public $deletedId;

    public function mount()
    {
        $this->createdFrom = today()->subDays(60)->format('Y-m-d');
        $this->createdTo = today()->format('Y-m-d');
    }

    #[Layout('admin.managements')]
    #[Title('Danh sách bình luận')]
    public function render()
    {
        return view('livewire.admin.comment-management.all-comments');
    }

    #[Computed()]
    public function commentsQuery()
    {
        return Comment::filter($this->filterStatus, $this->createdFrom, $this->createdTo)
            ->search($this->search)->sort($this->sortBy, $this->sortDirection);
    }

    #[Computed]
    public function comments()
    {
        return $this->commentsQuery->paginate($this->perPage);
    }

    // Phần lọc
    #[On('close-filter')]
    public function closeFilter()
    {
        $this->reset('filterStatus');
        $this->mount();
    }

    #[On('set-createdFrom')]
    public function setCreatedFrom($value)
    {
        $this->createdFrom = $value;
    }

    #[On('set-createdTo')]
    public function setCreatedTo($value)
    {
        $this->createdTo = $value;
    }
    // ------------------------------------

    // Phần sort
    public function setSortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = ($this->sortDirection == 'asc') ? 'desc' : 'asc';
            return;
        }

        $this->sortBy = $field;
        $this->reset('sortDirection');
    }
    // ------------------------------------

    // Phần checkbox
    public function updatedCheckedPageRecords($value)
    {
        if ($value) {
            $this->checkedRecords = $this->comments->pluck('id')->map(fn ($id) => (string) $id)->toArray();
            $this->reset('checkedAllRecords');
        } else
            $this->reset('checkedRecords');
    }

    public function updatedCheckedRecords()
    {
        $this->reset('checkedPageRecords', 'checkedAllRecords');
    }

    public function checkAllRecords()
    {
        $this->checkedAllRecords = true;
        $this->reset('checkedPageRecords');
        $this->checkedRecords = $this->commentsQuery->pluck('id')->map(fn ($id) => (string) $id)->toArray();
    }

    public function isChecked($id)
    {
        return in_array($id, $this->checkedRecords);
    }

    #[On('reset-checked-page')]
    public function resetCheckedPage()
    {
        $this->reset('checkedPageRecords');
    }
    // ------------------------------------

    // Về trang 1 khi thực hiện search, lọc nếu đang ở trang khác và bỏ chọn checkbox 'chọn tất cả record trên trang'
    public function updated($propertyName)
    {
        if (in_array($propertyName, array('perPage', 'search', 'filterStatus', 'createdFrom', 'createdTo'))) {
            $this->resetPage();
            $this->reset('checkedPageRecords');
        }
    }

    // Phần thay đổi trạng thái
    public function changeStatus($id)
    {
        Comment::withoutTimestamps(function () use ($id) {
            $comment = Comment::findOrFail($id);

            $this->authorize('update', $comment);

            $comment->is_active = !$comment->is_active;
            $comment->save();
        });
    }
    // ------------------------------------

    // Phần xóa record
    private function deleteRecord()
    {
        $comment = Comment::findOrFail($this->deletedId);
        $this->authorize('delete', $comment);
        $comment->delete();

        $this->dispatch('alert-success', message: 'Xóa bình luận thành công.');
    }

    private function deleteRecords()
    {
        foreach ($this->checkedRecords as $id)
            $this->authorize('delete', Comment::findOrFail($id));

        foreach ($this->checkedRecords as $id)
            Comment::findOrFail($id)->delete();

        $this->dispatch('alert-success', message: count($this->checkedRecords) . ' dòng được chọn đã xóa');
    }

    public function destroy()
    {
        if ($this->deletedId) {
            $this->deleteRecord();

            if ($this->checkedRecords)
                $this->checkedRecords = array_merge(array_diff($this->checkedRecords, [$this->deletedId]));
        } else {
            $this->deleteRecords();
        }

        $this->closeModal();
        $this->dispatch('close-modal');

        $this->resetPage();
        $this->reset('checkedPageRecords');
    }

    public function closeModal()
    {
        if ($this->deletedId)
            return $this->reset('deletedId');

        $this->reset('checkedRecords');
        $this->reset('checkedPageRecords');
    }
    // ------------------------------------

    // Phần export
    public function export()
    {
        return (new CommentsExport($this->checkedRecords))->download('comments.xlsx');
    }
    // ------------------------------------
}
