<?php

namespace App\Livewire\Admin\CategoryManagement;

use App\Models\Category;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class AllCategories extends Component
{
    use WithPagination;

    public $perPage = 5;

    #[Url(except: '')]
    public $search = '';

    public $filterStatus = '', $createdFrom, $createdTo;

    public $sortBy = 'updated_at';
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
    #[Title('Danh sách danh mục')]
    public function render()
    {
        return view('livewire.admin.category-management.all-categories');
    }

    #[Computed]
    public function categoriesQuery()
    {
        return Category::withCount(['posts', 'places'])
            ->filter($this->filterStatus, $this->createdFrom, $this->createdTo)
            ->search($this->search)
            ->orderBy($this->sortBy, $this->sortDirection);
    }

    #[Computed]
    public function categories()
    {
        return $this->categoriesQuery->paginate($this->perPage);
    }
    // ------------------------------------

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
            $this->checkedRecords = $this->categories->pluck('id')->map(fn ($id) => (string) $id)->toArray();
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
        $this->checkedRecords = $this->categoriesQuery->pluck('id')->map(fn ($id) => (string) $id)->toArray();
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
    // ------------------------------------

    // Phần thay đổi trạng thái
    public function changeStatus($id)
    {
        Category::withoutTimestamps(function () use ($id) {
            $category = Category::findOrFail($id);

            $this->authorize('update', $category);

            $category->is_active = !$category->is_active;
            $category->save();
        });
    }
    // ------------------------------------

    // Phần xóa record: 
    private function deleteRecord()
    {
        $category = Category::findOrFail($this->deletedId);
        $this->authorize('delete', $category);
        $category->delete();

        $this->dispatch('alert-success', message: 'Xóa danh mục thành công.');
    }

    private function deleteRecords()
    {
        foreach ($this->checkedRecords as $id)
            $this->authorize('delete', Category::findOrFail($id));

        foreach ($this->checkedRecords as $id)
            Category::findOrFail($id)->delete();

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
}
