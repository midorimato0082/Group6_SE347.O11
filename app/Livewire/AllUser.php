<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class AllUser extends Component
{
    use WithPagination;
    protected $listeners = ['resetCheckedAll' => 'resetCheckedAll'];

    public $keyword;
    public $role;
    public $checkedUser = [];
    public $checkedPage = false;
    public $checkedAll = false;


    public function render()
    {
        return view('livewire.all-user', ['users' => $this->users]);
    }

    public function getUsersProperty()
    {
        return $this->usersQuery->paginate(3);
    }

    public function getUsersQueryProperty()
    {
        return User::search($this->keyword)->where('is_admin', 'LIKE',  '%' . $this->role . '%')->orderBy('id', 'DESC');
    }

    public function updatedCheckedPage($value)
    {
        // Vì có liên quan đến tài khoản đang đăng nhập nên khác biệt chút
        $this->checkedUser = $value ? array_diff($this->users->pluck('id')->toArray(), [session('user.id')]) : [];

        // Cách dùng cho các management bình thường
        // $this->checkedUser = $value ? $this->users->pluck('id')->toArray() : [];

    }

    public function updatedCheckedUser()
    {
        $this->checkedPage = false;
    }

    public function checkAll()
    {
        
        $this->checkedAll = true;
        // Vì có liên quan đến tài khoản đang đăng nhập nên khác biệt chút
        $this->checkedUser = array_diff($this->usersQuery->pluck('id')->toArray(), [session('user.id')]);

        // Cách dùng cho các management bình thường
        // $this->checkedUser = $this->usersQuery->pluck('id')->toArray();
    }

    public function isChecked($id)
    {
        return in_array($id, $this->checkedUser);
    }

    public function resetCheckedAll()
    {
        $this->checkedPage = false;
    }

    public function deleteRecords()
    {
        User::whereKey($this->checkedUser)->delete();

        $this->checkedUser = [];
        $this->checkedPage = false;
        $this->checkedAll = false;

        session()->flash('success', 'Những dòng được chọn đã xóa');
    }


    public function deleteSingleRecord($id)
    {
        $user = User::find($id);
        $user->delete();

        session()->flash('success', 'Xóa user thành công.');
    }
}
