<?php

namespace App\Livewire\Admin\Profile;

use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Tab5 extends Component
{
    use WithPagination;

    public $perPage = 3;

    public function render()
    {
        return view('livewire.admin.profile.tab5');
    }

    #[Computed]
    public function comments()
    {
        return Comment::whereRelation('post', 'admin_id', Auth::user()->id)->latest()->paginate($this->perPage);
    }

    #[On('load-more-tab5')]
    public function loadMore() {
        $this->perPage += 3;
    }
}
