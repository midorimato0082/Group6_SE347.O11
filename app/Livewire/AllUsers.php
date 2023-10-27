<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\File;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class AllUsers extends Component
{
    use WithPagination;

    public $keyword;
    public $role;
    public $checkedUser = [];
    public $checkedPage = false;
    public $checkedAll = false;
    public $userId;                     //Id của user được deleteUser

    public function render()
    {
        return view('livewire.all-users', ['users' => $this->users]);
    }

    public function getUsersQueryProperty()
    {
        return User::where('is_admin', 'LIKE',  '%' . $this->role . '%')->search(trim($this->keyword))->latest('updated_at');
    }

    public function getUsersProperty()
    {
        return $this->usersQuery->paginate(3);
    }

    public function updatedCheckedPage($value)
    {
        // Vì có liên quan đến tài khoản đang đăng nhập nên khác biệt chút
        $this->checkedUser = $value ? array_diff($this->users->pluck('id')->toArray(), [session('user.id')]) : [];

        // Cách dùng cho các management bình thường
        // $this->checkedUser = $value ? $this->users->pluck('id')->toArray() : [];

        if (!$this->checkedUser)
            $this->checkedAll = false;
    }

    #[On('reset-checked')]
    public function resetChecked()
    {
        $this->reset('checkedPage', 'checkedAll');
    }

    public function resetPageChecked()
    {
        $this->resetPage();
        $this->resetChecked();
    }

    public function updatedCheckedUser()
    {
        $this->resetChecked();
    }

    public function checkAll()
    {
        $this->checkedAll = true;
        $this->checkedPage = false;
        // Vì có liên quan đến tài khoản đang đăng nhập nên khác biệt chút
        $this->checkedUser = array_diff($this->usersQuery->pluck('id')->toArray(), [session('user.id')]);

        // Cách dùng cho các management bình thường
        // $this->checkedUser = $this->usersQuery->pluck('id')->toArray();
    }

    public function isChecked($id)
    {
        return in_array($id, $this->checkedUser);
    }

    private function deleteRecords()
    {
        foreach ($this->checkedUser as $userId) {
            $this->deleteSingleRecords($userId);
        }

        // User::whereKey($this->checkedUser)->delete();

        session()->flash('success', 'Những dòng được chọn đã xóa');
    }

    private function deleteSingleRecords($id)
    {
        $user = User::find($id);
        if ($user->avatar != "no-avatar-admin.png" || $user->avatar != "no-avatar.png")
            File::delete(public_path('images/user/' . $user->avatar));

        $user->delete();

        session()->flash('success', 'Xóa user thành công.');
    }

    public function delete()
    {
        if ($this->userId) {
            $this->deleteSingleRecords($this->userId);
            $this->reset('userId');
        } else {
            $this->deleteRecords();
            $this->checkedUser = [];
            $this->resetChecked();
        }

        $this->dispatch('close-modal');

        $this->resetPage();
    }

    public function closeModal()
    {
        $this->reset('userId');
    }
}
