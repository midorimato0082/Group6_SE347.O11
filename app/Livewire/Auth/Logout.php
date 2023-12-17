<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Logout extends Component
{
    public function render()
    {
        return <<<'HTML'
        <a wire:click.prevent="logout" class="dropdown-item"><i class="fa fa-sign-out me-2"></i>Đăng xuất</a>
        HTML;
    }

    public function logout()
    {
        Auth::logout();
        return strpos(url()->previous(), 'email/verify') ? to_route('home') : redirect(url()->previous());
    }
}
