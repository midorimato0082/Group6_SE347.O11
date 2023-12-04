<?php

namespace App\Exports;

use App\Models\Review;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class ReviewsExport implements FromQuery, WithMapping, WithHeadings, WithStrictNullComparison
{
    use Exportable;

    protected $ids;

    public function __construct($ids) {
        $this->ids = $ids;
    }

    public function map($review): array
    {
        return [
            $review->id,
            $review->title,
            $review->desc,
            $review->content,
            $review->tags,
            $review->category->name,
            $review->location->region->name,
            $review->location->name,
            $review->admin->fullName . ' (' . $review->admin->email . ')',
            $review->created_at,
            $review->updated_at,
            $review->view_count,
            $review->comments_count,
            $review->like_count,
            $review->dislike_count,
            $review->is_active ? 'Hiển thị' : 'Ẩn'
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tiêu đề',
            'Mô tả',
            'Nội dung',
            'Thẻ',
            'Danh mục',
            'Vùng',
            'Địa điểm',
            'Tác giả',
            'Thời gian tạo',
            'Thời gian cập nhật gần nhất',
            'Lượt xem',
            'Lượt bình luận',
            'Lượt like',
            'Lượt dislike',
            'Trạng thái'
        ];
    }

    public function query() {
        return Review::whereKey($this->ids)->count();
    }
}