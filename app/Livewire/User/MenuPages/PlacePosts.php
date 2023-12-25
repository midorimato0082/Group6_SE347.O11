<?php

namespace App\Livewire\User\MenuPages;

use App\Models\Post;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class PlacePosts extends Component
{
    use WithPagination;

    public $place;
    public $postsPerPage = 3;

    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    public function render()
    {
        return view('livewire.user.menu-pages.place-posts');
    }

    #[Computed]
    public function posts()
    {
        return Post::where('is_active', true)
            ->whereRelation('places', 'name', $this->place)
            ->count()
            ->sort($this->sortBy, $this->sortDirection)
            ->paginate($this->postsPerPage);
    }

    // Phần load thêm bài viết
    public function loadMore()
    {
        $this->postsPerPage += 3;
    }
    // ------------------------------------

    // Phần sort
    public function setSortBy($field)
    {
        if ($field !== 'created_at' && $this->sortBy === $field) {
            $this->sortDirection = ($this->sortDirection == 'asc') ? 'desc' : 'asc';
            return;
        }

        $this->sortBy = $field;
        $this->reset('sortDirection');
    }
    // ------------------------------------
}
