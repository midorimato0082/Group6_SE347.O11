<?php

namespace App\Livewire\User\Profile;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Tab3 extends Component
{
    use WithPagination;

    public $perPage = 3;

    public function render()
    {
        return view('livewire.user.profile.tab3');
    }

    #[Computed]
    public function postLikes()
    {
        return Post::whereRelation('likes', 'user_id', Auth::user()->id)->latest()->paginate($this->perPage);
    }

    #[On('load-more-tab3')]
    public function loadMore() {
        $this->perPage += 3;
    }
}