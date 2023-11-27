<?php

namespace App\Livewire\User;

use App\Models\Review;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class LatestReviews extends Component
{
    use WithPagination;

    public $reviewsPerPage = 3;

    public function render()
    {
        $reviews = Review::where('is_active', 1)->latest()->paginate($this->reviewsPerPage);
        return view('livewire.user.latest-reviews', ['reviews' => $reviews]);
    }

    #[On('load-more')]
    public function loadMore() {
        $this->reviewsPerPage += 3;
    }
}
