<?php

namespace App\Livewire\Admin\LocationManagement;

use App\Models\Location;
use App\Models\Region;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;

class EditLocation extends Component
{

    use WithFileUploads;

    public Location $location;
    public $title, $region_id, $is_active;
    public $fileId;

    public function mount()
    {
        $this->fill(
            $this->location->only('region_id', 'is_active'),
        );
    }

    #[Layout('admin.managements')]
    #[Title('Cập nhật địa điểm')]
    public function render()
    {

        $regions = Region::all('id', 'name');

        return view('livewire.admin.location-management.edit-location', ['regions' => $regions]);
    }


    // public function updated($propertyName)
    // {
    //     $this->validateOnly($propertyName);
    // }

    public function update()
    {
        $this->authorize('update', $this->location);

        // $this->validate();

        $this->updateLocation();

        $this->dispatch('alert-success', message: 'Cập nhật địa điểm mới thành công.');
    }


    private function updateLocation()
    {
        $this->location->update([
            'region_id' => $this->region_id,
            'is_active' => $this->is_active
        ]);
    }
}
