<?php

namespace App\Livewire\User\MenuPages;

use App\Models\Category;
use App\Models\District;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ProvinceFilter extends Component
{
    use WithPagination;

    public $province;

    public $districtsPerPage = 10;

    public $categoryFilter = [];
    public $districtFilter = [];
    public $minPrice, $maxPrice;
    public $starFilter;

    public function render()
    {
        return view('livewire.user.menu-pages.province-filter');
    }

    #[Computed]
    public function categories()
    {
        return Category::where('is_active', true)->get('name');
    }

    #[Computed]
    public function districts()
    {
        return District::select('name')->where('province_id', $this->province)->paginate($this->districtsPerPage);
    }

    // Phần load thêm
    #[On('load-more-districts')]
    public function loadMoreDistricts()
    {
        $this->districtsPerPage += 4;
    }
    // ------------------------------------

    // Phần lọc
    public function updatedCategoryFilter()
    {
        $this->dispatch('filter-category', categoryFilter: $this->categoryFilter);
    }
    
    public function updatedDistrictFilter()
    {
        $this->dispatch('filter-district', districtFilter: $this->districtFilter);
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
