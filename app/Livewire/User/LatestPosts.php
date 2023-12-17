<?php

namespace App\Livewire\User;

use App\Models\Post;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class LatestPosts extends Component
{
    use WithPagination;

    public $postsPerPage = 3;

    public function render()
    {
        $posts = Post::where('is_active', 1)->latest()->paginate($this->postsPerPage);
        return view('livewire.user.latest-posts', ['posts' => $posts]);
    }

    #[On('load-more-latest-posts')]
    public function loadMore() {
        $this->postsPerPage += 3;
    }
}
