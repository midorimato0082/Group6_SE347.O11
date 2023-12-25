<?php

namespace App\Livewire\User\MenuPages;

use App\Models\District;
use App\Models\Province;
use App\Models\Region;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryFilter extends Component
{
    use WithPagination;

    public $provincesPerPage = 10;
    public $districtsPerPage = 10;

    public $regionFilter = [];
    public $provinceFilter = [];
    public $districtFilter = [];
    public $minPrice, $maxPrice;
    public $starFilter;

    public function render()
    {
        return view('livewire.user.menu-pages.category-filter');
    }

    #[Computed]
    public function regions()
    {
        return Region::select('name')->hasProvinces($this->provinceFilter)->hasDistricts($this->districtFilter)->get();
    }

    #[Computed]
    public function provinces()
    {
        return Province::select('name')->hasRegions($this->regionFilter)->hasDistricts($this->districtFilter)->paginate($this->provincesPerPage);
    }

    #[Computed]
    public function districts()
    {
        return District::select('name')->hasProvinces($this->provinceFilter)->paginate($this->districtsPerPage);
    }

    // Phần load thêm
    #[On('load-more-provinces')]
    public function loadMoreProvinces()
    {
        $this->provincesPerPage += 4;
    }

    #[On('load-more-districts')]
    public function loadMoreDistricts()
    {
        $this->districtsPerPage += 4;
    }
    // ------------------------------------

    // Phần lọc
    public function updatedRegionFilter()
    {
        $this->dispatch('filter-region', regionFilter: $this->regionFilter);
    }

    public function updatedProvinceFilter()
    {
        $this->dispatch('filter-province', provinceFilter: $this->provinceFilter);
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