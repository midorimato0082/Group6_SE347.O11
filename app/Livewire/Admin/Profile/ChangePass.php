<?php

namespace App\Livewire\Admin\Profile;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ChangePass extends Component
{
    public $old;
    public $new;
    public $new_confirmation;

    public function render()
    {
        return view('livewire.admin.profile.change-pass');
    }

    protected function rules(): array
    {
        return [
            'old' => 'required|min:6|max:12',
            'new' => 'required|min:6|max:12|confirmed',
        ];
    }

    protected function messages(): array
    {
        return [
            'old.required' => 'Bạn cần nhập mật khẩu cũ.',
            'old.min' => 'Mật khẩu cần có ít nhất 6 ký tự và tối đa 12 ký tự.',
            'old.max' => 'Mật khẩu cần có ít nhất 6 ký tự và tối đa 12 ký tự.',
            'new.required' => 'Bạn cần nhập mật khẩu mới.',
            'new.min' => 'Mật khẩu cần có ít nhất 6 ký tự và tối đa 12 ký tự.',
            'new.max' => 'Mật khẩu cần có ít nhất 6 ký tự và tối đa 12 ký tự.',
            'new.confirmed' => 'Nhập lại mật khẩu mới không đúng.'
        ];
    }

    public function update()
    {
        $this->validate();

        $user = Auth::user();
        if (!Hash::check($this->old, $user->password))
            return $this->addError('old', 'Nhập lại mật khẩu cũ không đúng.');


        User::whereId($user->id)->update([
            'password' => Hash::make($this->new)
        ]);

        $this->reset();
        $this->dispatch('close-modal');
        $this->dispatch('alert-success', message: 'Thay đổi mật khẩu thành công.');
    }

    public function clear()
    {
        $this->clearValidation();
        $this->reset();
    }
}
