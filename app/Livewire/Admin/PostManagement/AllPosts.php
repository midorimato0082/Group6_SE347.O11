<?php

namespace App\Livewire\Admin\PostManagement;

use App\Exports\PostsExport;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostImage;
use App\Models\Region;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class AllPosts extends Component
{
    use WithPagination;

    public $perPage = 5;

    #[Url(except: '')]
    public $search = '';

    public $filterCategory, $filterRegion, $filterAdmin, $filterStatus = '', $createdFrom, $createdTo;

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
    #[Title('Danh sách bài viết')]
    public function render()
    {
        return view('livewire.admin.post-management.all-posts');
    }

    #[Computed]
    public function postsQuery()
    {
        return Post::filter2($this->filterCategory, $this->filterRegion, $this->filterAdmin, $this->filterStatus, $this->createdFrom, $this->createdTo)
            ->search($this->search)
            ->count()
            ->sort($this->sortBy, $this->sortDirection);
    }

    #[Computed]
    public function posts()
    {
        return $this->postsQuery->paginate($this->perPage);
    }

    #[Computed]
    public function categories()
    {
        return Category::all('id', 'name');
    }

    #[Computed]
    public function regions()
    {
        return Region::all('id', 'name');
    }

    #[Computed]
    public function admins()
    {
        return User::getAdmin()->get();
    }
    // ------------------------------------

    // Phần lọc
    #[On('close-filter')]
    public function closeFilter()
    {
        $this->reset('filterCategory', 'filterRegion', 'filterAdmin', 'filterStatus');
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
            $this->checkedRecords = $this->posts->pluck('id')->map(fn ($id) => (string) $id)->toArray();
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
        $this->checkedRecords = $this->postsQuery->pluck('id')->map(fn ($id) => (string) $id)->toArray();
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
        if (in_array($propertyName, array('perPage', 'search', 'filterCategory', 'filterRegion', 'filterAdmin', 'filterStatus', 'createdFrom', 'createdTo'))) {
            $this->resetPage();
            $this->reset('checkedPageRecords');
        }
    }
    // ------------------------------------

    // Phần thay đổi trạng thái
    public function changeStatus($id)
    {
        Post::withoutTimestamps(function () use ($id) {
            $post = Post::findOrFail($id);

            // Role Admin chỉ được phép update, delete những bài viết do chính mình viết, Role Super Admin có thể update, delete mọi bài viết. 
            $this->authorize('update', $post);

            $post->is_active = !$post->is_active;
            $post->save();
        });
    }
    // ------------------------------------

    // Phần xóa record: 
    // Hàm destroy() được gọi khi nhấn nút OK trong modal ở resources\views\livewire\admin\delete-confirm.blade.php
    // Hàm closeModal() được gọi khi nhấn button hủy, button x trong modal ở resources\views\livewire\admin\delete-confirm.blade.php và sau khi xóa record
    private function delete($post)
    {
        if ($post->images->isNotEmpty()) {
            $images = PostImage::where('post_id', $post->id)->get();
            foreach ($images as $image) {
                // Disk 'images' được khai báo trong config/filesystems.php. Kiến thức Laravel File Storage
                Storage::disk('images')->delete('posts/' . $image->name);
                $image->delete();
            }
        }

        $post->delete();
    }

    private function deleteRecord()
    {
        $post = Post::findOrFail($this->deletedId);
        $this->authorize('delete', $post);
        $this->delete($post);

        // Sử dụng toastr để hiển thị thông báo. Search Toastr by CodeSeven. Event 'alert-success' viết trong main.js phần View All
        $this->dispatch('alert-success', message: 'Xóa bài viết thành công.');
    }

    private function deleteRecords()
    {
        $countDeleted = 0;
        $hasCanNotDeleted = false;
        
        foreach ($this->checkedRecords as $id) {
            $post = Post::findOrFail($id);
            if (Auth::user()->role->name !== 'Super Admin' && $post->admin_id !== Auth::user()->id)
                $hasCanNotDeleted = true;
            else {
                $this->delete($post);
                $countDeleted++;
            }
        }

        if ($hasCanNotDeleted)
            $this->dispatch('alert-warning', message: 'Bạn không có quyền xóa bài viết của các admin khác.');

        if ($countDeleted > 0)
            $this->dispatch('alert-success', message: 'Đã xóa ' . $countDeleted . ' bài viết trong số ' . count($this->checkedRecords) . ' bài viết được chọn.');
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
        return (new PostsExport($this->checkedRecords))->download('posts.xlsx');
    }
    // ------------------------------------
}
