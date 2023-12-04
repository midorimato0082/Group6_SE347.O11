<?php

namespace App\Livewire\Admin;

use App\Imports\ReviewsImport;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Validators\ValidationException;

class Import extends Component
{
    use WithFileUploads;
    public $table;
    public $file, $id;
    public $failures;

    #[Layout('livewire.admin.import-modal')]
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
        $this->authorize('create', Review::class);

        $this->validate();

        switch ($this->table) {
            case 'user':
                //
                break;
            case 'location':
                //
                break;
            case 'bài viết':
                $import = new ReviewsImport();
                break;
            case 'tin tức':
                //
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

        $this->reset('file');
        $this->id++;
        $this->dispatch('close-modal');
        $this->dispatch('alert-success', message: 'Import dữ liệu thành công.');
    }
}
