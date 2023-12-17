<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->count(5)->create();
        
        DB::table('users')->insert([
            [
                'last_name' => 'Nguyễn Thị Bích',
                'first_name' => 'Phượng', 
                'email' => 'superadmin@gmail.com',
                'password' => Hash::make('123456'),
                'phone' => '0123456789',
                'avatar' => '1.jpg',
                'role_id' => 3,
                'is_active' => true,
                'email_verified_at' => '2023-10-13 01:48:00',
                'created_at' => '2023-10-13 01:48:00',
                'updated_at' => '2023-10-13 01:48:00'
            ],
            [
                'last_name' => 'Bùi Lê Anh',
                'first_name' => 'Nguyên',               
                'email' => '22521718@gm.uit.edu.vn',
                'password' => Hash::make('123456'),
                'phone' => '1123456789',
                'avatar' => '2.jpg',
                'role_id' => 2,
                'is_active' => true,
                'email_verified_at' => '2023-10-15 01:48:00',
                'created_at' => '2023-10-15 01:48:00',
                'updated_at' => '2023-10-15 01:48:00'
            ],
            [
                'last_name' => 'Trần Thị',
                'first_name' => 'Thương',               
                'email' => 'user@gmail.com',
                'password' => Hash::make('123456'),
                'phone' => null,
                'avatar' => '3.jpg',
                'role_id' => 1,
                'is_active' => true,
                'email_verified_at' => '2023-10-18 02:48:00',
                'created_at' => '2023-10-16 01:48:00',
                'updated_at' => '2023-10-16 01:48:00'
            ],
            [
                'last_name' => 'Lê Ngọc',
                'first_name' => 'Phương',               
                'email' => 'midorimato0082@gmail.com',
                'password' => Hash::make('123456'),
                'phone' => null,
                'avatar' => '4.jpg',
                'role_id' => 1,
                'is_active' => true,
                'email_verified_at' => null,
                'created_at' => '2023-10-18 01:48:00',
                'updated_at' => '2023-10-18 01:48:00'
            ],
            [
                'last_name' => 'Lê Minh',
                'first_name' => 'Trí',               
                'email' => '22521543@gm.uit.edu.vn',
                'password' => Hash::make('123456'),
                'phone' => '2123456789',
                'avatar' => '5.jpg',
                'role_id' => 2,
                'is_active' => true,
                'email_verified_at' => '2023-10-19 01:48:00',
                'created_at' => '2023-10-19 01:48:00',
                'updated_at' => '2023-10-19 01:48:00'
            ],
            [
                'last_name' => 'Trần Minh',
                'first_name' => 'Tuấn',               
                'email' => 'noactive@gmail.com',
                'password' => Hash::make('123456'),
                'phone' => null,
                'avatar' => null,
                'role_id' => 1,
                'is_active' => false,
                'email_verified_at' => '2023-10-20 02:48:00',
                'created_at' => '2023-10-20 01:48:00',
                'updated_at' => '2023-10-20 01:48:00'
            ],
            [
                'last_name' => 'Phạm Hoàng',
                'first_name' => 'Tính',               
                'email' => '22521484@gm.uit.edu.vn',
                'password' => Hash::make('123456'),
                'phone' => '3123456789',
                'avatar' => '7.jpg',
                'role_id' => 2,
                'is_active' => true,
                'email_verified_at' => '2023-10-21 01:48:00',
                'created_at' => '2023-10-21 01:48:00',
                'updated_at' => '2023-10-21 01:48:00'
            ],
            [
                'last_name' => 'Hồ Ngọc',
                'first_name' => 'Hà',               
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123456'),
                'phone' => 4123456789,
                'avatar' => null,
                'role_id' => 1,
                'is_active' => true,
                'email_verified_at' => '2023-11-5 02:48:00',
                'created_at' => '2023-11-5 01:48:00',
                'updated_at' => '2023-11-5 01:48:00'
            ],
        ]);
    }
}
