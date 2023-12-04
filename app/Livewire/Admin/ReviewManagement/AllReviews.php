<?php

namespace App\Livewire\Admin\ReviewManagement;

use App\Exports\ReviewsExport;
use App\Models\Category;
use App\Models\Location;
use App\Models\Region;
use App\Models\Review;
use App\Models\ReviewImages;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class AllReviews extends Component
{
    use WithPagination;

    public $perPage = 5;    // Chọn số record hiển thị trên mỗi trang

    #[Url(except: '')]  // Hiển thị từ đang tìm trên url. Kiến thức Livewire URL Query Parameters
    public $search = '';

    public $filterCategory, $filterRegion, $filterLocation, $filterAdmin, $filterStatus = '', $createdFrom, $createdTo;
    public $locations;

    public $sortBy = 'created_at';
    public $sortDirection = 'DESC';

    public $checkedRecords = [];
    public $checkedPageRecords = false;
    public $checkedAllRecords = false;

    public $deletedId;

    public function mount()
    {
        $this->locations = Location::all('id', 'name');
        $this->createdFrom = today()->subDays(60)->format('Y-m-d');
        $this->createdTo = today()->format('Y-m-d');
    }

    #[Layout('admin.managements')]  // Search kiến thức Livewire Components phần Layout files
    #[Title('Danh sách bài viết')]  // Search kiến thức Livewire Components phần Setting the page title
    public function render()
    {
        return view('livewire.admin.review-management.all-reviews', [
            'reviews' => $this->reviews,
            'categories' => Category::all('id', 'name'),
            'regions' => Region::all('name'),
            'locations' => $this->locations,
            'admins' => User::getAdmin()->get(),
        ]);
    }

    // Phần lấy list reviews: Vì cần dùng lại truy vấn này cho việc chọn tất cả các record nên viết hàm tách riêng ra với paginate
    #[Computed] // Kiến thức Livewire Computed Properties
    public function reviewsQuery()
    {
        // Các hàm filter, search, count, sort được viết trong model Review
        // Search kiến thức về Eloquent phần Query Scopes > Local Scopes
        return Review::filter($this->filterCategory, $this->filterRegion, $this->filterLocation, $this->filterAdmin, $this->filterStatus, $this->createdFrom, $this->createdTo)
            ->search($this->search)
            ->count()
            ->sort($this->sortBy, $this->sortDirection);
    }

    #[Computed]
    public function reviews()
    {
        return $this->reviewsQuery->paginate($this->perPage);
    }
    // ------------------------------------

    // Phần lọc
    #[On('close-filter')] // Kiến thức Livewire Event phần Listening for events
    public function closeFilter()
    {
        // Nếu tắt chức năng lọc thì phải reset lại tất cả các biến liên quan
        $this->reset('filterCategory', 'filterRegion', 'filterLocation', 'filterAdmin', 'filterStatus');
        $this->mount();
    }

    // Kiến thức Livewire Lifecycle Hooks
    public function updatedFilterRegion($value)
    {
        // Hiển thị các location dựa trên region được chọn
        $this->locations = Location::whereRegion($value)->get(['id', 'name']);

        if ($this->filterLocation)
            $this->reset('filterLocation');
    }

    public function updatedFilterLocation($value)
    {
        // Hiển thị region dựa trên location được chọn
        if ($value)
            $this->filterRegion = Location::where('id', $value)->first()->region->name;
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
            $this->checkedRecords = $this->reviews->pluck('id')->map(fn ($id) => (string) $id)->toArray();
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
        $this->checkedRecords = $this->reviewsQuery->pluck('id')->map(fn ($id) => (string) $id)->toArray();
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
        if (in_array($propertyName, array('perPage', 'search', 'filterCategory', 'filterRegion', 'filterLocation', 'filterAdmin', 'filterStatus', 'createdFrom', 'createdTo'))) {
            $this->resetPage();
            $this->reset('checkedPageRecords');
        }
    }
    // ------------------------------------

    // Phần thay đổi trạng thái
    public function changeStatus($id)
    {
        $review = Review::findOrFail($id);

        // Role Admin chỉ được phép update, delete những bài viết do chính mình viết, Role Super Admin có thể update, delete mọi bài viết. 
        // Search kiến thức Laravel Authorization phần Policies. 
        // Authorize của model Review viết trong app\Policies\ReviewPolicy.php
        $this->authorize('update', $review);

        $review->update(['is_active' => !$review->is_active]);
    }
    // ------------------------------------

    // Phần xóa record: 
    // Hàm destroy() được gọi khi nhấn nút OK trong modal ở resources\views\livewire\admin\delete-confirm.blade.php
    // Hàm closeModal() được gọi khi nhấn button hủy, button x trong modal ở resources\views\livewire\admin\delete-confirm.blade.php và sau khi xóa record
    private function delete($review)
    {
        if ($review->images->isNotEmpty()) {
            $images = ReviewImages::where('review_id', $review->id)->get();
            foreach ($images as $image) {
                // Disk 'images' được khai báo trong config/filesystems.php. Kiến thức Laravel File Storage
                Storage::disk('images')->delete('reviews/' . $image->name);
                $image->delete();
            }
        }

        $review->delete();
    }

    private function deleteRecord()
    {
        $review = Review::findOrFail($this->deletedId);
        $this->authorize('delete', $review);
        $this->delete($review);

        // Sử dụng toastr để hiển thị thông báo. Search Toastr by CodeSeven. Event 'alert-success' viết trong main.js phần View All
        $this->dispatch('alert-success', message: 'Xóa bài viết thành công.');
    }

    private function deleteRecords()
    {
        foreach ($this->checkedRecords as $id)
            $this->authorize('delete', Review::findOrFail($id));

        foreach ($this->checkedRecords as $id)
            $this->delete(Review::findOrFail($id));

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
    // ------------------------------------

    // Phần export, import excel: search kiến thức về Laravel Excel, video hướng dẫn export: https://youtu.be/l686B7yLs8s, tài liệu hướng dẫn import https://docs.laravel-excel.com/3.1/imports/
    // Import viết trong file app/Livewire/Admin/Import.php
    public function export()
    {
        return (new ReviewsExport($this->checkedRecords))->download('reviews.xlsx');
    }
    // ------------------------------------
}
