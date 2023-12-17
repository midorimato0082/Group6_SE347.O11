<?php

namespace App\Imports;

use App\Models\Post;
use App\Models\PostImage;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsUnknownSheets;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithValidation;

class PostImagesImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, WithValidation, SkipsEmptyRows, WithUpserts, SkipsUnknownSheets
{
    use Importable;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new PostImage([
            'name' => $row['hinh'],
            'post_id' => Post::where('title', $row['bai_viet'])->first()->id
        ]);
    }

    public function uniqueBy()
    {
        return ['name', 'post_id'];
    }

    public function batchSize(): int
    {
        return 20;
    }

    public function chunkSize(): int
    {
        return 500;
    }

    public function rules(): array
    {
        return [
            'hinh' => 'required',
            'bai_viet' => 'required|exists:posts,title'
        ];
    }

    public function customValidationMessages()
    {
        return [
            'hinh.required' => 'Không có tên hình.',
            'bai_viet.required' => 'Không có bài viết này.',
            'bai_viet.exists' => 'Bài viết không tồn tại'
        ];
    }

    public function onUnknownSheet($sheetName)
    {
        // E.g. you can log that a sheet was not found.
        info("Sheet {$sheetName} was skipped");
    }
}