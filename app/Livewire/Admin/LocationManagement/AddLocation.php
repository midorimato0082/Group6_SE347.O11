<?php

namespace App\Livewire\Admin\LocationManagement;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

class AddLocation extends Component
{
    #[Layout('admin.managements')]
    #[Title('Thêm địa điểm')]
    public function render()
    {
        return view('livewire.admin.location-management.add-location');
    }
}