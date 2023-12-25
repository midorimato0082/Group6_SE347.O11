<?php

namespace App\Livewire\Admin\UserManagement;

use App\Exports\UsersExport;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class AllUsers extends Component
{
    use WithPagination;

    public $perPage = 5;

    #[Url(except: '')]
    public $search = '';

    public $filterRole, $filterStatus = '', $createdFrom, $createdTo;

    public $sortBy = 'updated_at';
    public $sortDirection = 'desc';

    public $checkedRecords = [];
    public $checkedPageRecords = false;
    public $checkedAllRecords = false;

    public $deletedId;

    public function mount()
    {
        $this->createdFrom = today()->subDays(90)->format('Y-m-d');
        $this->createdTo = today()->format('Y-m-d');
    }

    #[Layout('admin.managements')]
    #[Title('Danh sách user')]
    public function render()
    {
        return view('livewire.admin.user-management.all-users');
    }

    #[Computed()]
    public function usersQuery()
    {
        return User::filter($this->filterRole, $this->filterStatus, $this->createdFrom, $this->createdTo)
            ->search($this->search)->sort($this->sortBy, $this->sortDirection);
    }

    #[Computed]
    public function users()
    {
        return $this->usersQuery->paginate($this->perPage);
    }

    #[Computed]
    public function roles()
    {
        return Role::all('id', 'name');
    }

    // Phần lọc
    #[On('close-filter')]
    public function closeFilter()
    {
        $this->reset('filterRole', 'filterStatus');
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
            $this->checkedRecords = $this->users->pluck('id')->map(fn ($id) => (string) $id)->toArray();
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
        $this->checkedRecords = $this->usersQuery->pluck('id')->map(fn ($id) => (string) $id)->toArray();
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
        if (in_array($propertyName, array('perPage', 'search', 'filterRole', 'filterStatus', 'createdFrom', 'createdTo'))) {
            $this->resetPage();
            $this->reset('checkedPageRecords');
        }
    }

    // Phần thay đổi trạng thái
    public function changeStatus($id)
    {
        User::withoutTimestamps(function () use ($id) {
            $user = User::findOrFail($id);

            $this->authorize('update', $user);

            $user->is_active = !$user->is_active;
            $user->save();
        });
    }
    // ------------------------------------

    // Phần xóa record
    private function delete($user)
    {
        if ($user->avatar)
            Storage::disk('images')->delete('avatars/' . $user->avatar);

        $user->delete();
    }

    private function deleteRecord()
    {
        $user = User::findOrFail($this->deletedId);
        $this->authorize('delete', $user);
        $this->delete($user);

        $this->dispatch('alert-success', message: 'Xóa user thành công.');
    }

    private function deleteRecords()
    {
        foreach ($this->checkedRecords as $id)
            $this->authorize('delete', User::findOrFail($id));

        foreach ($this->checkedRecords as $id)
            $this->delete(User::findOrFail($id));

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
        return (new UsersExport($this->checkedRecords))->download('users.xlsx');
    }
    // ------------------------------------

}
