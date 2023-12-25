<?php

namespace App\Livewire\User;

use App\Models\Post;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class ResultSearch extends Component
{
    public $search;

    public function render()
    {
        return view('livewire.user.result-search');
    }

    #[Computed]
    public function posts()
    {
        return Post::where('is_active', true)->searchPage($this->search)->get();
    }

    #[On('search-page')]
    public function search($search)
    {
        $this->search = $search;
    }
}
