<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class AddAdmin extends Component
{
    use WithFileUploads;

    public $lastName, $firstName, $email, $phone, $password, $avatar;

    public $avatarValidity = -1;
    public $rand;

    public function render()
    {
        return view('livewire.admin.add-admin');
    }

    protected function rules(): array
    {
        return [
            'lastName' => 'bail | required | regex:/^[\pL\s\-]+$/u | max:40',
            'firstName' => 'bail | required | regex:/^[\pL\s\-]+$/u | max:20',
            'email' => 'bail | required | email:rfc,dns | max:30 | unique:users',
            'phone' => 'bail | required | digits:10 | unique:users',
            'password' => 'bail | required | min:6 | max:12',
        ];
    }

    protected function messages(): array
    {
        return [
            'lastName.required' => 'Bạn cần nhập họ.',
            'lastName.regex' => 'Họ chỉ bao gồm các chữ cái.',
            'last_name.max' => 'Họ tối đa chỉ có 40 ký tự.',
            'firstName.required' => 'Bạn cần nhập tên.',
            'firstName.regex' => 'Tên chỉ bao gồm các chữ cái Latinh.',
            'firstName.max' => 'Tên tối đa chỉ có 20 ký tự.',
            'email.required' => 'Bạn cần nhập email.',
            'email.email' => 'Không đúng định dạng email.',
            'email.max' => 'Email tối đa chỉ có 30 ký tự.',
            'email.unique' => 'Email đã tồn tại.',
            'phone.required' => 'Bạn cần nhập số điện thoại.',
            'phone.digits' => 'Số điện thoại phải gồm 10 chữ số.',
            'phone.unique' => 'Số điện thoại đã tồn tại trong hệ thống.',
            'password.required' => 'Bạn cần nhập mật khẩu.',
            'password.min' => 'Mật khẩu cần có ít nhất 6 ký tự và tối đa 12 ký tự.',
            'password.max' => 'Mật khẩu cần có ít nhất 6 ký tự và tối đa 12 ký tự.',
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
        if ($this->avatar) {
            $extension = strtolower($this->avatar->extension());
            $size = $this->avatar->getSize();

            if (in_array($extension, array('png', 'gif', 'jpeg')) && $size <= 1000000)
                return 1;
            else {
                $this->reset('avatar');
                return 0;
            }
        } 
        return -1;
    }

    public function clear()
    {
        $this->clearValidation();
        $this->reset();
        $this->rand++;
    }

    public function save()
    {
        $this->validate();

        $user = User::create([
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => Str::lower($this->email),
            'phone' => $this->phone,
            'password' => md5($this->password),
            'avatar' => "no-avatar-admin.png",
            'is_admin' => 1,
            'email_verified_at' => now()
        ]);

        if ($this->avatar) {
            $avatarName = $user->id . '.' . $this->avatar->extension();
            $this->avatar->storeAs('users', $avatarName);
            $user->update(['avatar' => $avatarName]);
        }

        $this->reset();

        return redirect('all-users')->with('success', 'Thêm admin thành công.');
    }
}
