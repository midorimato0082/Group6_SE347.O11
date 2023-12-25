<?php

namespace App\Livewire\User\Profile;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class Infor extends Component
{
    use WithFileUploads;

    public $user;
    public $avatar;

    public function mount()
    {
        $this->user = Auth::user();
        $this->avatar = $this->user->avatar_url;
    }

    public function render()
    {
        return view('livewire.user.profile.infor');
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
            $this->avatar = $this->user->avatar_url;

        $validator->validate();

        $this->clearValidation();

        if ($this->user->avatar)
            Storage::disk('images')->delete('avatars/' . $this->user->avatar);

        $this->user->update(['avatar' => basename($this->avatar->store('avatars', 'images'))]);

        $this->avatar = $this->user->avatar_url;
    }
}
