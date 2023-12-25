<?php

namespace App\Livewire\User\MenuPages;

use App\Models\Category;
use App\Models\District;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class DistrictFilter extends Component
{
    use WithPagination;

    public $province;

    public $categoryFilter = [];
    public $minPrice, $maxPrice;
    public $starFilter;

    public function render()
    {
        return view('livewire.user.menu-pages.district-filter');
    }

    #[Computed]
    public function categories()
    {
        return Category::where('is_active', true)->get('name');
    }

    // Phần lọc
    public function updatedCategoryFilter()
    {
        $this->dispatch('filter-category', categoryFilter: $this->categoryFilter);
    }

    public function filterPrice()
    {
        $this->validate(
            [
                'minPrice' => 'required_without:maxPrice',
                'maxPrice' => 'required_without:minPrice',
            ]
        );

        if (!empty($this->minPrice) && !empty($this->maxPrice) && $this->minPrice > $this->maxPrice)
            return $this->addError('minPrice', 'wrong');

        $this->dispatch('filter-price', minPriceFilter: $this->minPrice, maxPriceFilter: $this->maxPrice);
    }

    public function updatedStarFilter()
    {
        $this->dispatch('filter-star', starFilter: $this->starFilter);
    }
    // ------------------------------------

    public function removeFilter() {
        $this->reset();
        $this->clearValidation();
        $this->dispatch('remove-filter');
    }
}
