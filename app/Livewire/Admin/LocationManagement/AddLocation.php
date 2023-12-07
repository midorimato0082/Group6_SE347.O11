<?php

namespace App\Livewire\Admin\LocationManagement;

use App\Models\Location;
use App\Models\Region;
use App\Models\ReviewImages;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

class AddLocation extends Component
{
    use WithFileUploads;
    public $name, $slug, $regionId, $isActive = true, $fileId;

    #[Layout('admin.managements')]
    #[Title('Thêm địa điểm')]

    public function render()
    {
        $regions = Region::all('id', 'name');
        $this->regionId = $regions->first()->id;
        return view('livewire.admin.location-management.add-location', [
            'regions'   =>    $regions,
        ]);
    }

    public function updated($propertyName)
    {
        // $this->validateOnly($propertyName);
    }

    public function clear()
    {
        $this->clearValidation();
        $this->reset();
        $this->fileId++;
    }

    public function save()
    {
        $this->authorize('create', Location::class);

        // $this->validate();

        $location = $this->createLocation();

        $this->reset();

        $this->dispatch('alert-success', message: 'Thêm địa điểm mới thành công.');

        //return $this->redirectRoute('edit.location', $location);
    }

    private function createLocation()
    {
        $location = Location::create([
            'name' => $this->name,
            'slug' => Str::slug(Str::limit($this->name, 30)),
            'region_id' => $this->regionId,
            'is_active' => $this->isActive
        ]);

        return $location;
    }
}
