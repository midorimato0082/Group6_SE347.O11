<?php

namespace App\Exports;

use App\Models\Comment;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class CommentsExport implements FromQuery, WithMapping, WithHeadings, WithStrictNullComparison
{
    use Exportable;

    protected $ids;

    public function __construct($ids) {
        $this->ids = $ids;
    }

    public function map($comment): array
    {
        return [
            $comment->id,
            $comment->content,
            $comment->user->full_name,
            $comment->user->email,
            $comment->user->phone,
            $comment->post->title,
            $comment->likes_count,
            $comment->replies->count(),
            $comment->created_time,
            $comment->is_active ? 'Hiển thị' : 'Ẩn'
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nội dung',
            'Tên user',
            'Email',
            'Số điện thoại',
            'Tiêu đề bài viết',
            'Lượt thích',
            'Lượt trả lời',
            'Thời gian tạo',
            'Trạng thái'
        ];
    }

    public function query() {
        return Comment::whereKey($this->ids);
    }
}
