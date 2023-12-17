<?php

namespace App\Livewire\Auth\Passwords;

use Illuminate\Support\Facades\Password;
use Livewire\Component;

class Email extends Component
{
    public $email;

    public function render()
    {
        return view('livewire.auth.passwords.email');
    }

    protected function rules(): array
    {
        return [
            'email' => 'required|email:rfc,dns|exists:users',
        ];
    }

    protected function messages(): array
    {
        return [
            'email.required' => 'Bạn cần nhập email.',
            'email.email' => 'Không đúng định dạng email.',
            'email.exists' => 'Email đã nhập không có trong hệ thống.',
        ];
    }

    public function sendResetLinkEmail()
    {
        $this->validate();

        $status = Password::sendResetLink(
            $this->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? session()->flash('status', __($status))
            : $this->addError('email', __($status));
    }
}
