<?php

namespace App\Livewire\Admin\PlaceManagement;

use App\Models\Category;
use App\Models\District;
use App\Models\Place;
use App\Models\Province;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class AddPlace extends Component
{
    public $name, $categoryId, $address, $districtId, $minPrice, $maxPrice, $isActive = true;
    public $provinceId;
    public $newDistrict;

    public function mount()
    {
        $this->categoryId = $this->categories[0]->id ?? null;
        $this->provinceId = $this->provinces[0]->id;
        $this->districtId = $this->districts[0]->id ?? null;
    }

    public function render()
    {
        return view('livewire.admin.place-management.add-place');
    }

    #[Computed]
    public function categories()
    {
        return Category::where('is_active', true)->where('is_place', true)->get(['id', 'name']);
    }

    #[Computed]
    public function provinces()
    {
        return Province::all(['id', 'name']);
    }

    #[Computed]
    public function districts()
    {
        return District::where('province_id', $this->provinceId)->get(['id', 'name']);
    }

    protected function rules(): array
    {
        return [
            'name' => 'required|max:30',
            'districtId' => 'required_without:newDistrict',
            'newDistrict' => 'required_without:districtId'
        ];
    }

    protected function messages(): array
    {
        return [
            'name.required' => 'Bạn cần nhập tên địa điểm.',
            'name.max' => 'Tên quá dài, tối đa chỉ 30 ký tự.'
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    #[On('get-province')]
    public function setProvince($province)
    {
        $this->provinceId = $province;
        $district = District::where('province_id', $this->provinceId)->pluck('name', 'id');
        $this->dispatch('set-districts', districts: $district);
        $this->clearValidation('districtId');
    }

    #[On('get-district')]
    public function setDistrict($district)
    {
        $this->districtId = $district;
    }

    public function save()
    {
        $this->authorize('create', Place::class);

        $this->validate();

        if (!empty($this->minPrice) && !empty($this->maxPrice) && $this->minPrice > $this->maxPrice)
            return $this->addError('minPrice', 'Vui lòng nhập khoảng giá phù hợp.');

        $place = $this->createPlace();

        $this->dispatch('new-place', place: $place->category_id);

        $this->closeModal();

        $this->dispatch('close-modal');

        $this->dispatch('alert-success', message: 'Thêm địa điểm mới thành công.');

        $this->dispatch('saved');
    }

    private function createPlace()
    {
        if ($this->newDistrict)
            $this->districtId = District::create([
                'name' => Str::title($this->newDistrict),
                'slug' => Str::slug(Str::limit($this->newDistrict, 20)),
                'province_id' => $this->provinceId
            ])->id;

        return Place::create([
            'name' => $this->name,
            'slug' => Str::slug(Str::limit($this->name, 30)),
            'category_id' => $this->categoryId,
            'address' => $this->address,
            'district_id' => $this->districtId,
            'min_price' => $this->minPrice ?? $this->maxPrice ?? 0,
            'max_price' => $this->maxPrice ?? $this->minPrice ?? 0,
            'is_active' => $this->isActive
        ]);
    }

    public function closeModal()
    {
        $this->reset();
        $this->clearValidation();
        $this->mount();
    }
}
