<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class EditAdmin extends Component
{
    public $id;
    public User $user;

    public function render()
    {
        $this->user = User::where('id', $this->id)->first();
        
        return view('livewire.edit-admin');
    }
}
