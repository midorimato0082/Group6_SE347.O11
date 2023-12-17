<?php

namespace App\Livewire\User;

use App\Models\Post;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryPosts extends Component
{
    use WithPagination;

    public $category;
    public $postsPerPage = 3;

    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    public $regionFilter = [];
    public $provinceFilter = [];
    public $districtFilter = [];
    public $minPriceFilter = 0, $maxPriceFilter;
    public $starFilter;

    public function render()
    {
        $posts = Post::where('category_id', $this->category->id)
            ->count()
            ->rangePrice()
            ->filter($this->regionFilter, $this->provinceFilter, $this->districtFilter, $this->minPriceFilter, $this->maxPriceFilter, $this->starFilter)
            ->sort($this->sortBy, $this->sortDirection)
            ->paginate($this->postsPerPage);

        return view('livewire.user.category-posts', ['posts' => $posts]);
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
    #[On('filter-region')]
    public function filterRegion($regionFilter)
    {
        $this->regionFilter = $regionFilter;
    }

    #[On('filter-province')]
    public function filterProvince($provinceFilter)
    {
        $this->provinceFilter = $provinceFilter;
    }

    #[On('filter-district')]
    public function filterDistrict($districtFilter)
    {
        $this->districtFilter = $districtFilter;
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
        $this->reset('regionFilter', 'provinceFilter', 'districtFilter', 'minPriceFilter', 'maxPriceFilter', 'starFilter');
    }

}
