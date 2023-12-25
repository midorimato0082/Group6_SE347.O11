<?php

namespace App\Livewire\Admin\Profile;

use App\Models\Post;
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
        return view('livewire.admin.profile.tab2');
    }

    #[Computed]
    public function posts()
    {
        return Post::where('admin_id', Auth::user()->id)->count()->latest()->paginate($this->perPage);
    }

    #[On('load-more-tab2')]
    public function loadMore() {
        $this->perPage += 3;
    }
}
