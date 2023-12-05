<?php

namespace App\Livewire\Admin\LocationManagement;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class EditLocation extends Component
{
    #[Layout('admin.managements')]
    #[Title('Cập nhật địa điểm')]
    public function render()
    {
        return view('livewire.admin.location-management.edit-location');
    }
}