<?php

namespace App\Livewire\Auth;

use Illuminate\Http\Request;
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

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return $this->redirectRoute('home');
    }
}
