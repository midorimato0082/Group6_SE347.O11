<?php

namespace App\Livewire\User;

use App\Models\Post;
use Livewire\Attributes\On;
use Livewire\Component;

class ResultSearch extends Component
{
    public $posts, $search;

    public function render()
    {
        $this->posts = Post::where('is_active', true)->searchPage($this->search)->get();
        return view('livewire.user.result-search');
    }

    #[On('search-page')]
    public function search($search)
    {
        $this->search = $search;
    }
}
