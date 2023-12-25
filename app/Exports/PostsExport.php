<?php

namespace App\Exports;

use App\Models\Post;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class PostsExport implements FromQuery, WithMapping, WithHeadings, WithStrictNullComparison
{
    use Exportable;

    protected $ids;

    public function __construct($ids) {
        $this->ids = $ids;
    }

    public function map($post): array
    {
        return [
            $post->id,
            $post->title,
            $post->desc,
            $post->content,
            $post->tags,
            $post->category->name,
            $post->places_name,
            $post->admin->fullName . ' (' . $post->admin->email . ')',
            $post->created_time,
            $post->updated_time,
            $post->view_count,
            $post->comments_count,
            $post->like_count,
            $post->dislike_count,
            $post->is_active ? 'Hiển thị' : 'Ẩn'
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
            'Địa điểm review',
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
        return Post::whereKey($this->ids)->count();
    }
}