<?php

namespace App\Livewire\Admin\CategoryManagement;

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Component;

class AddCategory extends Component
{
    public $name, $isPlace = true, $isActive = true;

    public function render()
    {
        return view('livewire.admin.category-management.add-category');
    }

    protected function rules(): array
    {
        return [
            'name' => 'required|max:30|unique:categories',
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

    public function save()
    {
        $this->authorize('create', Category::class);

        $this->validate();

        $this->createCategory();

        $this->closeModal();

        $this->dispatch('close-modal');

        $this->dispatch('alert-success', message: 'Thêm danh mục mới thành công.');
        
        $this->dispatch('saved');
    }

    private function createCategory()
    {
        return Category::create([
            'name' => Str::title($this->name),
            'slug' => Str::slug(Str::limit($this->name, 20)),
            'is_place' => $this->isPlace,
            'is_active' => $this->isActive
        ]);
    }

    public function closeModal()
    {
        $this->reset();
        $this->clearValidation();
    }
}
