<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Location;
use App\Models\Region;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class ReviewsImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, WithUpserts, WithValidation //SkipsOnFailure
{
    use Importable;  //SkipsFailures;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $location = Location::updateOrCreate([
            'name' => $row['Địa điểm'],
            'slug' => Str::slug(Str::limit($row['Địa điểm'], 20)),
            'region_id' => Region::where('name', $row['Vùng'])->first()->id,
        ]);

        return new Review([
            'title' => $row['Tiêu đề'],
            'slug' => Str::slug(Str::limit($row['Tiêu đề'], 30)),
            'desc' => $row['Mô tả'],
            'content' => $row['Nội dung'],
            'tags' => $row['Thẻ'],
            'category_id' => Category::where('name', $row['Danh mục'])->first()->id,
            'location_id' => $location->id,
            'admin_id' => User::where('email', $row['Tác giả'])->first()->id
        ]);
    }

    public function batchSize(): int
    {
        return 20;
    }

    // Khi có tiêu đề bị trùng trong database thì sẽ update dữ liệu dòng đó
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
            'Tiêu đề' => 'required',
            'Danh mục' => 'required|exists:categories,name',
            'Vùng' => 'required|exists:regions,name',
            'Địa điểm' => 'required',
            'Tác giả' => 'required|exists:users,email'
        ];
    }

    public function customValidationMessages()
    {
        return [
            'Tiêu đề.required' => 'Không có tiêu đề.',
            'Danh mục.required' => 'Không có tên danh mục.',
            'Danh mục.exists' => 'Tên danh mục không tồn tại',
            'Vùng.required' => 'Không có tên vùng.',
            'Vùng.exists' => 'Tên vùng không tồn tại.',
            'Địa điểm.required' => 'Không có tên địa điểm.',
            'Tác giả.required' => 'Không có tên tác giả.',
            'Tác giả.exists' => 'Email tác giả không tồn tại'
        ];
    }
}
