<?php

namespace App\Livewire\Auth\Passwords;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Livewire\Component;

class Reset extends Component
{
    public $token, $email, $password, $password_confirmation;
    
    public function render()
    {
        return view('livewire.auth.passwords.reset');
    }

    protected function rules(): array
    {
        return [
            'email' => 'required',
            'password' => 'required|min:6|max:12|confirmed',
        ];
    }

    protected function messages(): array
    {
        return [
            'email.required' => 'Cần có địa chỉ email.',
            'password.required' => 'Bạn cần nhập mật khẩu.',
            'password.min' => 'Mật khẩu cần ít nhất 6 ký tự.',
            'password.max' => 'Mật khẩu tối đa chỉ có 12 ký tự',
            'password.confirmed' => 'Nhập lại mật khẩu không đúng.'
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function resetPassword()
    {
        $this->validate();

        $status = Password::reset(
            $this->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ]);
     
                $user->save();
     
                event(new PasswordReset($user));
            }
        );

        if($status === Password::PASSWORD_RESET) {
            $this->reset();
            session()->flash('success',  __($status));
            return $this->redirectRoute('login');
        }
     
        $this->reset('password', 'password_confirmation');
        $this->addError('email', __($status));
    }
}
