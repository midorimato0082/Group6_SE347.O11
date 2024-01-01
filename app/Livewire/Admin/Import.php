<?php

namespace App\Livewire\Admin;

use App\Imports\AdminsImport;
use App\Imports\PlacesImport;
use App\Imports\ReviewsImport;
use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Validators\ValidationException;

class Import extends Component
{
    use WithFileUploads;
    public $data;
    public $file, $id;
    public $failures;

    public function render()
    {
        return view('livewire.admin.import');
    }

    protected function rules(): array
    {
        return [
            'file' => 'required|mimes:xlsx,xls',
        ];
    }

    protected function messages(): array
    {
        return [
            'file.required' => 'Bạn chưa chọn file.',
            'file.mimes' => 'File được chọn phải có đuôi là .xlsx hoặc .xls.'
        ];
    }

    public function import()
    {
        $this->reset('failures');
        
        $this->authorize('create', Post::class);

        $this->validate();

        switch ($this->data) {
            case 'user':
                $import = new AdminsImport();
                break;
            case 'bài viết':
                $import = new ReviewsImport();
                break;
            case 'địa điểm':
                $import = new PlacesImport();
                break;
        }

        try {
            $import->import($this->file);
        } catch (ValidationException $e) {
            foreach ($e->failures() as $failure)
                foreach ($failure->errors() as $error)
                    $this->failures[] = 'Dòng ' . $failure->row() . ': ' . $error;
            return $this->failures;
        };

        $this->closeModal();
        $this->dispatch('close-modal');
        $this->dispatch('alert-success', message: 'Import dữ liệu thành công.');
        $this->dispatch('saved');
    }

    public function closeModal() 
    {
        $this->reset('file', 'failures');
        $this->id++;
        $this->clearValidation();
    }
}
