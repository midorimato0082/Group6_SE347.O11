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
    public $userId;

    public function render()
    {
        return view('livewire.all-users', ['users' => $this->users]);
    }

    public function getUsersQueryProperty()
    {
        return User::where('is_admin', 'LIKE',  '%' . $this->role . '%')->search(trim($this->keyword))->orderBy('updated_at', 'desc');
    }

    public function getUsersProperty()
    {
        return $this->usersQuery->paginate(3);
    }

    public function resetPageChecked()
    {
        $this->resetPage();
        $this->reset('checkedPage');
    }

    public function updatedCheckedPage($value)
    {
        if ($value) {
            $this->checkedUser =  array_merge(array_diff($this->users->pluck('id')->toArray(), [session('user.id')]));
            $this->checkedAll = false;
        } else
            $this->checkedUser = [];

        // Cách dùng cho các management bình thường
        // $this->checkedUser = $value ? $this->users->pluck('id')->map(fn ($item) => (string)$item)->toArray() : [];
    }

    public function updatedCheckedUser()
    {
        $this->reset('checkedPage', 'checkedAll');
    }

    #[On('reset-checked')]
    public function resetChecked()
    {
        $this->reset('checkedPage');
    }

    public function checkAll()
    {
        $this->checkedAll = true;
        $this->checkedPage = false;
        $this->checkedUser = array_merge(array_diff($this->usersQuery->pluck('id')->toArray(), [session('user.id')]));

        // Cách dùng cho các management bình thường
        // $this->checkedUser = $this->usersQuery->pluck('id')->toArray();
    }

    public function isChecked($id)
    {
        return in_array($id, $this->checkedUser);
    }

    private function deleteRecords()
    {
        foreach ($this->checkedUser as $userId)
            $this->deleteSingleRecords($userId);

        // User::whereKey($this->checkedUser)->delete();  
    }

    private function deleteSingleRecords($id)
    {
        $user = User::find($id);

        foreach ($user->reviews as $review)
            $review->update(['user_id' => 0]);


        foreach ($user->news as $news)
            $news->update(['user_id' => 0]);


        foreach ($user->comments as $comment)
            $comment->update(['user_id' => 0]);


        foreach ($user->likes as $like)
            $like->update(['user_id' => 0]);

        if ($user->avatar != "no-avatar-admin.png" || $user->avatar != "no-avatar.png")
            File::delete(public_path('images/user/' . $user->avatar));

        $user->delete();
    }

    public function delete()
    {
        if ($this->userId) {
            $this->deleteSingleRecords($this->userId);
            $this->reset('userId');
            session()->flash('success', 'Xóa user thành công.');
        } else {
            $this->deleteRecords();
            $this->checkedUser = [];
            $this->resetChecked();
            session()->flash('success', 'Những dòng được chọn đã xóa');
        }

        $this->dispatch('close-modal');

        $this->resetPage();
    }

    public function closeModal()
    {
        $this->reset('userId');
    }
}
