<?php

namespace App\Livewire\Admin\UserManagement;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Component;

class AddAdmin extends Component
{
    public $lastName, $firstName, $email, $phone, $roleId, $isActive = true;

    public function mount() {
        $this->roleId = $this->roles[0]->id;
    }

    public function render()
    {
        return view('livewire.admin.user-management.add-admin');
    }

    #[Computed]
    public function roles()
    {
        return Role::where('name', '!=', 'User')->get(['id', 'name']);
    }

    protected function rules(): array
    {
        return [
            'lastName' => 'required|regex:/^[\pL\s\-]+$/u|max:40',
            'firstName' => 'required|regex:/^[\pL\s\-]+$/u|max:20',
            'email' => 'required|email:rfc,dns|unique:users',
            'phone' => 'nullable|digits:10|unique:users'
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
            'phone.digits' => 'Số điện thoại phải gồm 10 chữ số.',
            'phone.unique' => 'Số điện thoại đã tồn tại trong hệ thống.'
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save() {
        $this->authorize('create', User::class);

        $this->validate();

        $this->createAdmin();

        $this->closeModal();

        $this->dispatch('close-modal');

        $this->dispatch('alert-success', message: 'Thêm admin mới thành công.');
        
        $this->dispatch('saved');
    }

    public function createAdmin() {
        $user = User::create([
            'last_name' => Str::title($this->lastName),
            'first_name' => Str::title($this->firstName),            
            'email' => Str::lower($this->email),
            'phone' => $this->phone,
            'password' => Hash::make('123456')
        ]);

        $user->role_id = $this->roleId;
        $user->is_active = $this->isActive;
        $user->save();

    }

    public function closeModal() {
        $this->reset();
        $this->clearValidation();
        $this->mount();
    }
}
