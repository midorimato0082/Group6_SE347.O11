<?php

namespace App\Livewire\User\MenuPages;

use App\Models\Post;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class DistrictPosts extends Component
{
    use WithPagination;

    public $district;
    public $postsPerPage = 3;

    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    public $categoryFilter = [];
    public $minPriceFilter = 0, $maxPriceFilter;
    public $starFilter;

    public function render()
    {
        return view('livewire.user.menu-pages.district-posts');
    }

    #[Computed]
    public function posts()
    {
        return Post::where('is_active', true)
            ->whereRelation('places.district', 'name', $this->district)
            ->count()
            ->rangePrice()
            ->filter($this->categoryFilter, null, null, null, $this->minPriceFilter, $this->maxPriceFilter, $this->starFilter)
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

    // Phần lọc
    #[On('filter-category')]
    public function filterCategory($categoryFilter)
    {
        $this->categoryFilter = $categoryFilter;
    }

    #[On('filter-price')]
    public function filterPrice($minPriceFilter, $maxPriceFilter)
    {
        $this->minPriceFilter = $minPriceFilter;
        $this->maxPriceFilter = $maxPriceFilter;
    }

    #[On('filter-star')]
    public function filterStar($starFilter)
    {
        $this->starFilter = $starFilter;
    }
    // ------------------------------------

    #[On('remove-filter')]
    public function removeFilter()
    {
        $this->reset('categoryFilter', 'minPriceFilter', 'maxPriceFilter', 'starFilter');
    }
}
