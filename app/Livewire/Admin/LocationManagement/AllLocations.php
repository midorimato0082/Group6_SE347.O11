<?php

namespace App\Livewire\Admin\LocationManagement;

use App\Models\Location;
use App\Models\Region;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
class AllLocations extends Component
{

    use WithPagination;

    public $perPage = 5;    // Chọn số record hiển thị trên mỗi trang

    #[Url(except: '')]  // Hiển thị từ đang tìm trên url. Kiến thức Livewire URL Query Parameters
    public $search = '';

    public $filterRegion, $filterStatus = '', $createdFrom, $createdTo;
    public $regions;

    public $sortBy = 'created_at';
    public $sortDirection = 'DESC';

    public $checkedRecords = [];
    public $checkedPageRecords = false;
    public $checkedAllRecords = false;

    public $deletedId;

    public function mount()
    {
        $this->regions = Region::all('id', 'name');
        $this->createdFrom = today()->subDays(60)->format('Y-m-d');
        $this->createdTo = today()->format('Y-m-d');
    }

    #[Layout('admin.managements')]
    #[Title('Danh sách địa điểm')]

    public function render()
    {
        return view('livewire.admin.location-management.all-locations', [
            'locations' => $this->locations,
            'regions' => $this->regions,
        ]);
    }

    #[Computed] // Kiến thức Livewire Computed Properties
    public function locationsQuery()
    {
        // Các hàm filter, search, count, sort được viết trong model location
        // Search kiến thức về Eloquent phần Query Scopes > Local Scopes
        return Location::filter($this->filterRegion, $this->filterStatus, $this->createdFrom, $this->createdTo)
            ->search($this->search)
            ->sort($this->sortBy, $this->sortDirection);
    }

    #[Computed]
    public function locations()
    {
        return $this->locationsQuery->paginate($this->perPage);
    }

    // ------------------------------------
    // Phần lọc
    #[On('close-filter')] // Kiến thức Livewire Event phần Listening for events
    public function closeFilter()
    {
        // Nếu tắt chức năng lọc thì phải reset lại tất cả các biến liên quan
        $this->reset('filterRegion', 'filterStatus');
        $this->mount();
    }
    // Không cần làm Import, Export. Authorize chỉ cần xác định đó là admin là được
    // Kiến thức Livewire Lifecycle Hooks
    // public function updatedFilterRegion($value)
    // {
    //     $this->regions = Location::whereRegion($value)->get(['id', 'name']);

    //     if ($this->filterRegion)
    //         $this->reset('filterRegion');
    // }

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
            $this->sortDirection = ($this->sortDirection == 'ASC') ? 'DESC' : 'ASC';
            return;
        }

        $this->sortBy = $field;
        $this->reset('sortDirection');
    }
    // ------------------------------------

    // Phần checkbox: video hướng dẫn https://youtu.be/pyiTprcM-kE
    public function updatedCheckedPageRecords($value)
    {
        if ($value) {
            $this->checkedRecords = $this->locations->pluck('id')->map(fn ($id) => (string) $id)->toArray();
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
        $this->checkedRecords = $this->locationsQuery->pluck('id')->map(fn ($id) => (string) $id)->toArray();
    }

    public function isChecked($id)
    {
        // Kiểm tra đây có phải dòng được chọn không? Nếu đúng thì cho dòng đó hiển thị nền màu xanh
        return in_array($id, $this->checkedRecords);
    }

    #[On('reset-checked-page')]  // Vì nút chọn trang không hiển thị trong blade view nên cần viết event trong main.js
    public function resetCheckedPage()
    {
        // Khi chuyển sang trang khác thì checkbox chọn tất cả dòng trên trang cũ phải reset lại
        $this->reset('checkedPageRecords');
    }
    // ------------------------------------

    // Về trang 1 khi thực hiện search, lọc nếu đang ở trang khác và bỏ chọn checkbox 'chọn tất cả record trên trang'
    public function updated($propertyName)
    {
        if (in_array($propertyName, array('perPage', 'search', 'filterRegion', 'filterStatus', 'createdFrom', 'createdTo'))) {
            $this->resetPage();
            $this->reset('checkedPageRecords');
        }
    }
    // ------------------------------------
    private function delete($location)
    {

        $location->delete();
    }

    public function changeStatus($id)
    {
        $location = Location::findOrFail($id);

        // Role Admin chỉ được phép update, delete những bài viết do chính mình viết, Role Super Admin có thể update, delete mọi bài viết.
        // Search kiến thức Laravel Authorization phần Policies.
        // Authorize của model location viết trong app\Policies\locationPolicy.php
        $this->authorize('update', $location);

        $location->update(['is_active' => !$location->is_active]);
    }

    private function deleteRecord()
    {
        $location = Location::findOrFail($this->deletedId);
        $this->authorize('delete', $location);
        $this->delete($location);

        // Sử dụng toastr để hiển thị thông báo. Search Toastr by CodeSeven. Event 'alert-success' viết trong main.js phần View All
        $this->dispatch('alert-success', message: 'Xóa địa điểm thành công.');
    }

    private function deleteRecords()
    {
        foreach ($this->checkedRecords as $id)
            $this->authorize('delete', Location::findOrFail($id));

        foreach ($this->checkedRecords as $id)
            $this->delete(Location::findOrFail($id));

        $this->dispatch('alert-success', message: count($this->checkedRecords) . ' dòng được chọn đã xóa');
    }

    public function destroy()
    {
        if ($this->deletedId) {
            $this->deleteRecord();

            // Trong khi đang chọn các checkbox mà thực hiện xóa một dòng bất kỳ nào đó thì loại bỏ dòng bị xóa đó ra khỏi các checkbox được chọn
            if ($this->checkedRecords)
                $this->checkedRecords = array_merge(array_diff($this->checkedRecords, [$this->deletedId]));
        } else {
            $this->deleteRecords();
        }

        $this->closeModal();
        $this->dispatch('close-modal');     // Ẩn modal, event 'close-modal' được viết trong main.js phần View All

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
}
