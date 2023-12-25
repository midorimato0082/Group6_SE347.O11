<?php

namespace App\Exports;

use App\Models\Place;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class PlacesExport implements FromQuery, WithMapping, WithHeadings, WithStrictNullComparison
{
    use Exportable;
    
    protected $ids;

    public function __construct($ids) {
        $this->ids = $ids;
    }

    public function map($place): array
    {
        return [
            $place->id,
            $place->name,
            $place->category->name,
            $place->address,
            $place->district->name,
            $place->district->province->name,
            $place->district->province->region->name,
            number_format($place->min_price, 0, '.', ','),
            number_format($place->max_price, 0, '.', ','),
            $place->star,
            $place->posts_title,
            $place->created_time,
            $place->updated_time,
            $place->is_active ? 'Hiển thị' : 'Ẩn'
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tên',
            'Danh mục',
            'Địa chỉ',
            'Quận huyện',
            'Tỉnh thành',
            'Vùng miền',
            'Giá thấp nhất',
            'Giá cao nhất',
            'Rating',
            'Các bài viết',
            'Thời gian tạo',
            'Thời gian cập nhật gần nhất',
            'Trạng thái'
        ];
    }

    public function query() {
        return Place::whereKey($this->ids);
    }
}
