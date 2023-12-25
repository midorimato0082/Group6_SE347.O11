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

class EditPlace extends Component
{
    public $place;
    public $name, $category_id, $address, $district_id, $min_price, $max_price, $is_active = true;
    public $provinceId;
    public $newDistrict;

    public function render()
    {
        return view('livewire.admin.place-management.edit-place');
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

    #[On('edit-place')]
    public function setEditedId($id)
    {
        $this->place = Place::find($id);

        $this->fill(
            $this->place->only('name', 'category_id', 'address', 'district_id', 'min_price', 'max_price', 'is_active'),
        );
 
        $this->provinceId = District::find($this->district_id)->province_id;
        $this->dispatch('set-province-edit', province: $this->provinceId);
        
        $districts = District::where('province_id', $this->provinceId)->get(['id', 'name']);
        $this->dispatch('set-districts-edit', districts: $districts->pluck('name', 'id'));
    }

    protected function rules(): array
    {
        return [
            'name' => 'required|max:30', 
            'district_id' => 'required_without:newDistrict',
            'newDistrict' => 'required_without:district_id'
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

    #[On('get-province-edit')]
    public function setProvince($province)
    {
        $this->provinceId = $province;
        $district = District::where('province_id', $this->provinceId)->pluck('name', 'id');
        $this->dispatch('set-districts-edit', districts: $district);
    }

    #[On('get-district-edit')]
    public function setDistrict($district)
    {
        $this->district_id = $district;
    }

    public function update() {
        $this->authorize('update', $this->place);

        $this->validate();
        
        if ($this->min_price >= 0 && $this->max_price >= 0 && $this->min_price > $this->max_price)
            return $this->addError('min_price', 'Vui lòng nhập khoảng giá phù hợp.');

        $this->updatePlace();

        $this->closeModal();

        $this->dispatch('close-modal');

        $this->dispatch('alert-success', message: 'Cập nhật địa điểm thành công.');
        
        $this->dispatch('updated');
    }

    private function updatePlace()
    {
        if ($this->newDistrict)
            $this->district_id = District::create([
                'name' => Str::title($this->newDistrict),
                'slug' => Str::slug(Str::limit($this->newDistrict, 20)),
                'province_id' => $this->provinceId
            ])->id;

        $this->place->update([
            'name' => $this->name,
            'slug' => Str::slug(Str::limit($this->name, 30)),
            'category_id' => $this->category_id,
            'address' => $this->address,
            'district_id' => $this->district_id,
            'min_price' => $this->min_price === '' ? ($this->max_price !== '' ? $this->max_price : 0) : $this->min_price,
            'max_price' => $this->max_price === '' ? ($this->min_price !== '' ? $this->min_price : 0) : $this->max_price,
            'is_active' => $this->is_active
        ]);
    }

    public function closeModal() {
        $this->dispatch('clear-edit');
        $this->reset();
        $this->clearValidation();      
    }
}
