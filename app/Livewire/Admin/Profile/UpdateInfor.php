<?php

namespace App\Livewire\Admin\Profile;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Livewire\Component;

class UpdateInfor extends Component
{
    public User $user;
    public $last_name, $first_name, $email, $phone;

    public function mount() {
        $this->fill(
            $this->user->only('last_name', 'first_name', 'email', 'phone'),
        );
    }

    public function render()
    {
        return view('livewire.admin.profile.update-infor');
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
            'first_name.regex' => 'Tên chỉ bao gồm các chữ cái Latinh.',
            'first_name.max' => 'Tên tối đa chỉ có 20 ký tự.',
            'email.required' => 'Bạn cần nhập email.',
            'email.email' => 'Không đúng định dạng email.',
            'email.unique' => 'Email đã tồn tại.',
            'phone.digits' => 'Số điện thoại phải gồm 10 chữ số.',
            'phone.unique' => 'Số điện thoại này đã tồn tại.',
        ];
    }

    public function update(Request $request) {
        $this->validate();

        $this->user->last_name = Str::title($this->last_name);
        $this->user->first_name = Str::title($this->first_name);
        
        if($this->user->email !== Str::lower($this->email)) {
            $this->user->email_verified_at = null;
            $request->user()->sendEmailVerificationNotification();
        }

        $this->user->email = Str::lower($this->email);
        
        $this->user->phone = $this->phone;
        
        $this->user->save();

        $this->dispatch('close-modal');
        $this->dispatch('updated');
        $this->dispatch('alert-success', message: 'Cập nhật thông tin hồ sơ thành công.');
    }

    public function clear() {
        $this->clearValidation();
        $this->mount();
    }
}
