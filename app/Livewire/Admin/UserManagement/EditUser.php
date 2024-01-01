<?php

namespace App\Livewire\Admin\UserManagement;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditUser extends Component
{
    use WithFileUploads;

    public $user;
    public $last_name, $first_name, $email, $phone, $avatar, $role_id, $is_active;
    public $newAvatar;
    public $fileId;

    public function render()
    {
        return view('livewire.admin.user-management.edit-user');
    }

    #[Computed]
    public function roles()
    {
        return Role::all(['id', 'name']);
    }

    #[On('edit-user')]
    public function setEditedId($id)
    {
        $this->user = User::find($id);

        $this->fill(
            $this->user->only('last_name', 'first_name', 'email', 'phone', 'role_id', 'is_active'),
        );

        $this->avatar = $this->user->avatar_url;
    }

    protected function rules(): array
    {
        return [
            'last_name' => 'required|regex:/^[\pL\s\-]+$/u|max:40',
            'first_name' => 'required|regex:/^[\pL\s\-]+$/u|max:20',
            'email' => ['required', 'email:rfc,dns', Rule::unique('users')->ignore($this->user->id)],
            'phone' => ['nullable', 'digits:10', Rule::unique('users')->ignore($this->user->id)],
        ];
    }

    protected function messages(): array
    {
        return [
            'last_name.required' => 'Bạn cần nhập họ.',
            'last_name.regex' => 'Họ chỉ bao gồm các chữ cái.',
            'last_name.max' => 'Họ tối đa chỉ có 40 ký tự.',
            'first_name.required' => 'Bạn cần nhập tên.',
            'first_name.regex' => 'Tên chỉ bao gồm các chữ cái.',
            'first_name.max' => 'Tên tối đa chỉ có 20 ký tự.',
            'email.required' => 'Bạn cần nhập email.',
            'email.email' => 'Không đúng định dạng email.',
            'email.unique' => 'Email đã tồn tại.',
            'phone.digits' => 'Số điện thoại phải gồm 10 chữ số.',
            'phone.unique' => 'Số điện thoại này đã tồn tại.',
        ];
    }


    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updatedNewAvatar()
    {
        $validator = Validator::make(
            ['newAvatar' => $this->newAvatar],
            ['newAvatar' => 'image|mimes:jpg,jpeg,png|max:1024'],
            [
                'newAvatar.image' => 'File được chọn phải là ảnh .jpg, .jpeg hoặc .png.',
                'newAvatar.mimes' => 'Ảnh được chọn phải có đuôi là .jpg, .jpeg hoặc .png.',
                'newAvatar.max' => 'Kích thước ảnh phải nhỏ hơn 1 MB'
            ]
        );

        if ($validator->fails())
            $this->removeNewAvatar();

        $validator->validate();
    }

    public function removeNewAvatar()
    {
        $this->reset('newAvatar');
        $this->fileId++;
    }

    public function update(Request $request) {
        $this->authorize('update', $this->user);

        $this->validate();

        $this->updateUser($request);
        $this->closeModal();
        $this->dispatch('close-modal');
        $this->dispatch('alert-success', message: 'Cập nhật user thành công.');
        $this->dispatch('updated');
    }

    public function updateUser(Request $request) {
        $this->user->last_name = Str::title($this->last_name);
        $this->user->first_name = Str::title($this->first_name);
        
        if($this->user->email !== Str::lower($this->email)) {
            $this->user->email_verified_at = null;
            $request->user()->sendEmailVerificationNotification();
        }

        $this->user->email = Str::lower($this->email);
        
        $this->user->phone = $this->phone;

        $this->user->role_id = $this->role_id;
        $this->user->is_active = $this->is_active;

        if ($this->newAvatar) {
            Storage::disk('images')->delete('avatars/' . $this->user->avatar);
            $this->user->avatar = basename($this->newAvatar->store('avatars', 'images'));
        }
        
        $this->user->save();
    }

    public function closeModal() {
        $this->reset();
        $this->clearValidation();
    }
}
