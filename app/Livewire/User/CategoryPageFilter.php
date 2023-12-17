<?php

namespace App\Livewire\User;

use App\Models\District;
use App\Models\Province;
use App\Models\Region;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryPageFilter extends Component
{
    use WithPagination;

    public $category;
    public $provincesPerPage = 10;
    public $districtsPerPage = 10;

    public $regionFilter = [];
    public $provinceFilter = [];
    public $districtFilter = [];
    public $minPrice, $maxPrice;
    public $starFilter;


    public function render()
    {
        $regions = Region::select('name')->hasProvinces($this->provinceFilter)->hasDistricts($this->districtFilter)->get();
        $provinces = Province::select('name')->hasRegions($this->regionFilter)->hasDistricts($this->districtFilter)->paginate($this->provincesPerPage);
        $districts = District::select('name')->hasProvinces($this->provinceFilter)->paginate($this->districtsPerPage);

        return view('livewire.user.category-page-filter', ['provinces' => $provinces, 'regions' => $regions, 'districts' => $districts]);
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
