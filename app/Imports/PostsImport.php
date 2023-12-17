<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithValidation;

class PostsImport implements ToModel, WithHeadingRow, WithUpserts, WithBatchInserts, WithChunkReading, WithValidation
{
    use Importable;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Post([
            'title' => $row['tieu_de'],
            'slug' => Str::slug(Str::limit($row['tieu_de'], 30)),
            'desc' => $row['mo_ta'],
            'content' => $row['noi_dung'],
            'tags' => $row['the'],
            'category_id' => Category::where('name', $row['danh_muc'])->first()->id,
            'admin_id' => User::where('email', $row['tac_gia'])->first()->id
        ]);
    }

    public function batchSize(): int
    {
        return 20;
    }

    public function uniqueBy()
    {
        return 'title';
    }

    public function chunkSize(): int
    {
        return 500;
    }

    public function rules(): array
    {
        return [
            'tieu_de' => 'required',
            'danh_muc' => 'required|exists:categories,name',
            'tac_gia' => 'required|exists:users,email'
        ];
    }

    public function customValidationMessages()
    {
        return [
            'tieu_de.required' => 'Không có tiêu đề.',
            'danh_muc.required' => 'Không có tên danh mục.',
            'danh_muc.exists' => 'Tên danh mục không tồn tại',
            'tac_gia.required' => 'Không có tên tác giả.',
            'tac_gia.exists' => 'Email tác giả không tồn tại'
        ];
    }
}
