<?php

namespace App\Livewire\Auth;

use Illuminate\Http\Request;
use Livewire\Component;

class Resend extends Component
{
    public function render()
    {
        return view('livewire.auth.resend');
    }

    public function resend(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        session()->flash('resent',  true);
    }
}
