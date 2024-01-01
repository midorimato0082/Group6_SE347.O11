<?php

namespace App\Imports;

use App\Models\Role;
use App\Models\User;
use App\Rules\HasRightCreateSuperAdmin;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithValidation;

class AdminsImport implements ToModel, WithHeadingRow, WithUpserts, WithBatchInserts, WithChunkReading, WithValidation
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            'last_name' => $row['ho'],
            'first_name' => $row['ten'],
            'email' => $row['email'],
            'password' => Hash::make('123456'),
            'phone' => $row['so_dien_thoai'],
            'role_id' => Role::where('name', $row['vai_tro'])->first()->id
        ]);
    }

    public function uniqueBy()
    {
        return 'email';
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
            'ho' => 'required|regex:/^[\pL\s\-]+$/u|max:40',
            'ten' => 'required|regex:/^[\pL\s\-]+$/u|max:20',
            'email' => 'required|email:rfc,dns|unique:users',
            'so_dien_thoai' => 'nullable|digits:10|unique:users,phone',
            'vai_tro' => ['required', 'not_in:User', 'exists:roles,name', new HasRightCreateSuperAdmin]           
        ];
    }

    public function customValidationMessages()
    {
        return [
            'ho.required' => 'Không có họ.',
            'ho.regex' => 'Họ chứa ký tự không là chữ cái.',
            'ho.max' => 'Họ vượt quá 40 ký tự.',
            'ten.required' => 'Không có tên.',
            'ten.regex' => 'Tên chứa ký tự không là chữ cái.',
            'ten.max' => 'Tên vượt quá 20 ký tự.',
            'email.required' => 'Không có email.',
            'email.email' => 'Không đúng định dạng email.',
            'email.unique' => 'Email đã tồn tại.',
            'so_dien_thoai.digits' => 'Số điện thoại vượt quá 10 chữ số.',
            'so_dien_thoai.unique' => 'Số điện thoại đã tồn tại.',
            'vai_tro.not_in' => 'Không thể import vai trò user.',
            'vai_tro.exists' => 'Tên vai trò không tồn tại.'
        ];
    }
}
