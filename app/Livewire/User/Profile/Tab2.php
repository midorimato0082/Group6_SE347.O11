<?php

namespace App\Livewire\User\Profile;

use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Tab2 extends Component
{
    use WithPagination;

    public $perPage = 3;

    public function render()
    {
        return view('livewire.user.profile.tab2');
    }

    #[Computed]
    public function commentLikes()
    {
        return Comment::whereRelation('likes', 'user_id', Auth::user()->id)->latest()->paginate($this->perPage);
    }

    #[On('load-more-tab2')]
    public function loadMore() {
        $this->perPage += 3;
    }
}
