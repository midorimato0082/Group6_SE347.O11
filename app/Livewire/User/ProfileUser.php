<?php

namespace App\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class ProfileUser extends Component
{
    use WithFileUploads;

    public User $user;
    public $originalEmail;
    public $originalPhone;
    public $originalAvatar;
    public $newAvatar;
    public $successAvatar = -1;

    public function mount()
    {
        $this->getInfo();
    }

    public function render()
    {
        return view('livewire.user.profile-user');
    }

    public function getInfo()
    {
        $this->user = User::find(session('user.id'));
        $this->originalEmail = $this->user->email;
        $this->originalPhone = $this->user->phone;
        $this->originalAvatar = $this->user->avatar;
    }

    protected function rules(): array
    {
        return [
            'user.last_name' => 'bail | required | regex:/^[\pL\s\-]+$/u | max:40',
            'user.first_name' => 'bail | required | regex:/^[\pL\s\-]+$/u | max:20',
            'user.email' => 'bail | required | email:rfc,dns | max:30 ',
            'user.phone' => 'bail | required | digits:10',
        ];
    }

    protected function messages(): array
    {
        return [
            'user.last_name.required' => 'Bạn cần nhập họ.',
            'user.last_name.regex' => 'Họ chỉ bao gồm các chữ cái.',
            'user.last_name.max' => 'Họ tối đa chỉ có 40 ký tự.',
            'user.first_name.required' => 'Bạn cần nhập tên.',
            'user.first_name.regex' => 'Tên chỉ bao gồm các chữ cái Latinh.',
            'user.first_name.max' => 'Tên tối đa chỉ có 20 ký tự.',
            'user.email.required' => 'Bạn cần nhập email.',
            'user.email.email' => 'Không đúng định dạng email.',
            'user.email.max' => 'Email tối đa chỉ có 30 ký tự.',
            'user.phone.required' => 'Bạn cần nhập số điện thoại.',
            'user.phone.digits' => 'Số điện thoại phải gồm 10 chữ số.',
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
        $this->updateAvatar();
    }

    public function clear()
    {
        $this->clearValidation();
        $this->getInfo();
    }

    public function updateInfor()
    {
        $this->validate();

        $this->user->email = Str::lower($this->user->email);

        if ($this->originalEmail != $this->user->email && User::where('email', $this->user->email)->first())
            return session()->flash('fail', 'Địa chỉ email này đã tồn tại trong dữ liệu.');

        if ($this->originalPhone != $this->user->phone && User::where('phone', $this->user->phone)->first())
            return session()->flash('fail', 'Số điện thoại này này đã tồn tại trong dữ liệu.');

        $this->user->save();

        session()->put('user.first_name', $this->user->first_name);
        session()->put('user.name', $this->user->fullName);

        $this->clear();

        $this->dispatch('close-modal');
    }

    public function checkAvatarValidity()
    {
        if ($this->newAvatar) {
            $extension = strtolower($this->newAvatar->extension());
            $size = $this->newAvatar->getSize();

            if (in_array($extension, array('png', 'jpg', 'jpeg')) && $size <= 1000000)
                return 1;
            else {
                $this->reset('newAvatar');
                return 0;
            }
        }
        return -1;
    }

    public function updateAvatar() {
        $this->successAvatar = $this->checkAvatarValidity();

        if ($this->successAvatar == 1) {
            if ($this->user->avatar != "no-avatar-admin.png" || $this->user->avatar != "no-avatar.png")
                File::delete(public_path('images/users/' . $this->user->avatar));

            $avatarName = $this->user->id . '.' . $this->newAvatar->extension();
            $this->newAvatar->storeAs('users', $avatarName);

            $this->user->avatar = $avatarName;
            $this->user->save();

            session()->put('user.avatar', $this->user->avatar);

            $this->clear();
        }
    }
}
