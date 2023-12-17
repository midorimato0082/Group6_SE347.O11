<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class Register extends Component
{
    use WithFileUploads;

    public $lastName, $firstName, $email, $password, $password_confirmation, $avatar, $id;

    public function render()
    {
        return view('livewire.auth.register');
    }

    public function generateName()
    {
        $this->lastName = Str::title($this->lastName);
        $this->firstName = Str::title($this->firstName);
    }

    protected function rules(): array
    {
        return [
            'lastName' => 'required|regex:/^[\pL\s\-]+$/u|max:40',
            'firstName' => 'required|regex:/^[\pL\s\-]+$/u|max:20',
            'email' => 'required|email:rfc,dns|unique:users',
            'password' => 'required|min:6|max:12|confirmed',
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
            'email.unique' => 'Email đã tồn tại.',
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

    public function updatedAvatar()
    {
        $validator = Validator::make(
            ['avatar' => $this->avatar],
            ['avatar' => 'image|mimes:jpg,jpeg,png|max:1024'],
            [
                'avatar.image' => 'File được chọn phải là ảnh .jpg, .jpeg hoặc .png.',
                'avatar.mimes' => 'Ảnh được chọn phải có đuôi là .jpg, .jpeg hoặc .png.',
                'avatar.max' => 'Kích thước ảnh phải nhỏ hơn 1 MB'
            ]
        );

        if ($validator->fails())
            $this->removeAvatar();

        $validator->validate();
    }

    public function removeAvatar()
    {
        $this->reset('avatar');
        $this->id++;
    }

    public function register()
    {
        $this->validate();

        event(new Registered($user = $this->createUser()));

        $this->reset();

        Auth::login($user);

        return $this->redirectRoute('verification.notice');
    }

    private function createUser()
    {
        return User::create([
            'last_name' => $this->lastName,
            'first_name' => $this->firstName,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'avatar' => $this->avatar ? basename($this->avatar->store('avatars', 'images')) : null
        ]);
    }
}
