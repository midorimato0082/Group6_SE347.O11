<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class UsersExport implements FromQuery, WithMapping, WithHeadings, WithStrictNullComparison
{
    use Exportable;
    
    protected $ids;

    public function __construct($ids) {
        $this->ids = $ids;
    }

    public function map($user): array
    {
        return [
            $user->id,
            $user->last_name,
            $user->first_name,
            $user->email,
            $user->phone,
            $user->role->name,
            $user->email_verified_at,
            $user->created_time,
            $user->updated_time,
            $user->is_active ? 'Hiển thị' : 'Ẩn'
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Họ',
            'Tên',
            'Email',
            'Số điện thoại',
            'Vai trò',
            'Xác nhận email',
            'Thời gian tạo',
            'Thời gian cập nhật gần nhất',
            'Trạng thái'
        ];
    }

    public function query() {
        return User::whereKey($this->ids);
    }
}
