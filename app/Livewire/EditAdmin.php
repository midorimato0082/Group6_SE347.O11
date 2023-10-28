<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class EditAdmin extends Component
{
    use WithFileUploads;

    public $id;
    public User $user;
    public $newPassword;
    public $originalEmail;
    public $originalPhone;
    public $originalAvatar;
    public $newAvatar;
    public $avatarValidity = -1;
    public $rand;

    public function mount()
    {
        $this->getInfo();
    }

    public function render()
    {
        return view('livewire.edit-admin');
    }

    public function getInfo()
    {
        $this->user = User::find($this->id);
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
            'newPassword' => 'bail | nullable | min:6 | max:12',
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
            'newPassword.min' => 'Mật khẩu cần có ít nhất 6 ký tự và tối đa 12 ký tự.',
            'newPassword.max' => 'Mật khẩu cần có ít nhất 6 ký tự và tối đa 12 ký tự.',
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
        $this->avatarValidity = $this->checkAvatarValidity();
        if ($this->avatarValidity != 1)
            $this->rand++;
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

    public function clear()
    {
        $this->clearValidation();
        $this->reset('newAvatar', 'avatarValidity');
        $this->getInfo();
        $this->rand++;
    }

    public function update()
    {
        $this->validate();

        if ($this->newPassword)
            $this->user->password = md5($this->newPassword);

        $this->user->email = Str::lower($this->user->email);
        if ($this->originalEmail != $this->user->email && User::firstWhere('email', $this->user->email))
            return session()->flash('fail', 'Địa chỉ email này đã tồn tại trong dữ liệu.');


        if ($this->originalPhone != $this->user->phone && User::firstWhere('phone', $this->user->phone))
            return session()->flash('fail', 'Số điện thoại này này đã tồn tại trong dữ liệu.');


        if ($this->newAvatar) {
            if ($this->user->avatar != "no-avatar-admin.png" || $this->user->avatar != "no-avatar.png")
                File::delete(public_path('images/user/' . $this->user->avatar));
                
            $avatarName = $this->id . '.' . $this->newAvatar->extension();
            $this->newAvatar->storeAs('user', $avatarName);
            $this->user->avatar = $avatarName;
        }

        $this->user->save();

        $this->clear();

        return redirect('all-users')->with('success', 'Chỉnh sửa thông tin của admin thành công.');
    }
}
