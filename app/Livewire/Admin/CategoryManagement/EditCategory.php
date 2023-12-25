<?php

namespace App\Livewire\Admin\CategoryManagement;

use App\Models\Category;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;

class EditCategory extends Component
{
    public $category;
    public $name, $is_place, $is_active;

    public function render()
    {
        return view('livewire.admin.category-management.edit-category');
    }

    #[On('edit-category')]
    public function setEditedId($id)
    {
        $this->category = Category::find($id);

        $this->fill(
            $this->category->only('name', 'is_place', 'is_active'),
        );
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'max:30', Rule::unique('categories')->ignore($this->category->id)],
        ];
    }

    protected function messages(): array
    {
        return [
            'name.required' => 'Bạn cần nhập tên danh mục.',
            'name.max' => 'Tên quá dài, tối đa chỉ 30 ký tự.',
            'name.unique' => 'Tên danh mục này đã tồn tại.',
        ];
    }

    public function update() {
        $this->authorize('update', $this->category);

        $this->validate();
        
        $this->updateCategory();

        $this->closeModal();

        $this->dispatch('close-modal');

        $this->dispatch('alert-success', message: 'Cập nhật danh mục thành công.');
        
        $this->dispatch('updated');
    }

    private function updateCategory()
    {
        $this->category->update([
            'name' => Str::title($this->name),
            'slug' => Str::slug(Str::limit($this->name, 20)),
            'is_place' => $this->is_place,
            'is_active' => $this->is_active
        ]);
    }

    public function closeModal() {
        $this->reset();
        $this->clearValidation();      
    }
}
