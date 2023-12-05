<?php

namespace App\Livewire\Admin\LocationManagement;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class AllLocations extends Component
{
    #[Layout('admin.managements')]
    #[Title('Danh sách địa điểm')]
    public function render()
    {
        return view('livewire.admin.location-management.all-locations');
    }

    // Không cần làm Import, Export. Authorize chỉ cần xác định đó là admin là được
}