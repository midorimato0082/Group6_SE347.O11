<?php

namespace App\Livewire\User\Post;

use App\Models\Post;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class LatestPosts extends Component
{
    use WithPagination;

    public $postsPerPage = 3;

    public function render()
    {
        return view('livewire.user.post.latest-posts');
    }

    #[Computed]
    public function posts()
    {
        return Post::where('is_active', 1)->latest()->paginate($this->postsPerPage);
    }

    #[On('load-more-latest-posts')]
    public function loadMore() {
        $this->postsPerPage += 3;
    }
}
