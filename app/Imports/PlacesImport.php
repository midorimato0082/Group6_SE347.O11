<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\District;
use App\Models\Place;
use App\Models\Post;
use App\Models\Province;
use App\Models\Review;
use App\Rules\InCategoryRelatedPlace;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsUnknownSheets;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithUpserts;

class PlacesImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, WithUpserts, SkipsUnknownSheets
{
    use Importable;

    public function model(array $row)
    {
        $place = Place::updateOrCreate(
            [
                'name' => $row['dia_diem'],
                'slug' => Str::slug(Str::limit($row['dia_diem'], 30)),
                'category_id' => isset($row['bai_viet']) ? Post::where('title', $row['bai_viet'])->value('category_id') : Category::where('name', $row['danh_muc'])->value('id'),
                'address' => $row['dia_chi'],
                'district_id' => District::updateOrCreate([
                    'name' => $row['quan_huyen'],
                    'slug' => Str::slug(Str::limit($row['quan_huyen'], 20)),
                    'province_id' => Province::where('name', $row['tinh_thanh'])->first()->id
                ])->id
            ],
            [
                'min_price' => $row['gia_thap_nhat'] ?? $row['gia_cao_nhat'] ?? 0,
                'max_price' => ($row['gia_cao_nhat'] >= $row['gia_thap_nhat'] ? $row['gia_cao_nhat'] : $row['gia_thap_nhat']) ?? 0
            ]
        );
        if (isset($row['bai_viet'])) {
            return new Review([
                        'post_id' => Post::where('title', $row['bai_viet'])->value('id'),
                        'place_id' => $place->id,
                    ]);
        }
    }

    public function uniqueBy()
    {
        return ['post_id', 'place_id'];
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
            'dia_diem' => 'required',
            'danh_muc' => ['required_without:bai_viet', 'exists:categories,name', new InCategoryRelatedPlace],
            'bai_viet' => 'required_without:danh_muc|exists:posts,title',
            'quan_huyen' => 'required',
            'tinh_thanh' => 'required|exists:provinces,name',
            'gia_thap_nhat' => 'nullable|numeric',
            'gia_cao_nhat' => 'nullable|numeric'
        ];
    }

    public function customValidationMessages()
    {
        return [
            'dia_diem.required' => 'Không có tên nơi cần import.',
            'danh_muc.required_without' => 'Không có tên danh mục hay tên bài viết.',
            'danh_muc.exists' => 'Tên danh mục không tồn tại.',
            'bai_viet.required_without' => 'Không có tên danh mục hay tên bài viết.',
            'bai_viet.exists' => 'Bài viết không tồn tại.',
            'quan_huyen.required' => 'Không có tên quận huyện.',
            'tinh_thanh.required' => 'Không có tên tỉnh thành.',
            'tinh_thanh.exists' => 'Tỉnh thành không tồn tại.',
            'gia_thap_nhat.numeric' => 'Giá trị của cột giá thấp nhất phải là số.',
            'gia_cao_nhat.numeric' => 'Giá trị của cột giá cao nhất phải là số.'
        ];
    }

    public function onUnknownSheet($sheetName)
    {
        // E.g. you can log that a sheet was not found.
        info("Sheet {$sheetName} was skipped");
    }
}
