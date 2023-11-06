<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'first_name' => 'Phượng',
                'last_name' => 'Nguyễn Thị Bích',
                'email' => '17520926@gm.uit.edu.vn',
                'phone' => '0789456123',
                'password' => 'e10adc3949ba59abbe56e057f20f883e',
                'avatar' => '1.jpg',
                'email_verified_at' => now(),
                'is_admin' => 1
            ],
            [
                'first_name' => 'Nguyên',
                'last_name' => 'Bùi Lê Anh',
                'email' => '22521718@gm.uit.edu.vn',
                'phone' => '0789456120',
                'password' => 'e10adc3949ba59abbe56e057f20f883e',
                'avatar' => '2.jpg',
                'email_verified_at' => now(),
                'is_admin' => 1
            ],
            [
                'first_name' => 'Trí',
                'last_name' => 'Lê Minh',
                'email' => '22521543@gm.uit.edu.vn',
                'phone' => '0789456121',
                'password' => 'e10adc3949ba59abbe56e057f20f883e',
                'avatar' => '3.jpg',
                'email_verified_at' => now(),
                'is_admin' => 1
            ],
            [
                'first_name' => 'Tính',
                'last_name' => 'Phạm Hoàng',
                'email' => '22521484@gm.uit.edu.vn',
                'phone' => '0789456122',
                'password' => 'e10adc3949ba59abbe56e057f20f883e',
                'avatar' => '4.jpg',
                'email_verified_at' => now(),
                'is_admin' => 1
            ],
            [
                'first_name' => 'Bảo',
                'last_name' => 'Nguyễn Ngọc',
                'email' => 'baonn@gmail.com',
                'phone' => null,
                'password' => 'e10adc3949ba59abbe56e057f20f883e',
                'avatar' => '5.jpg',
                'email_verified_at' => now(),
                'is_admin' => 0
            ],
            [
                'first_name' => 'Thương',
                'last_name' => 'Trần Thị',
                'email' => 'thuongtt@gmail.com',
                'phone' => null,
                'password' => 'e10adc3949ba59abbe56e057f20f883e',
                'avatar' => 'no-avatar.png',
                'email_verified_at' => null,
                'is_admin' => 0
            ],
            [
                'first_name' => 'Phương',
                'last_name' => 'Lê Ngọc',
                'email' => 'midorimato0082@gmail.com',
                'phone' => null,
                'password' => 'e10adc3949ba59abbe56e057f20f883e',
                'avatar' => '7.jpg',
                'email_verified_at' => now(),
                'is_admin' => 0
            ],
            [
                'first_name' => 'Tuấn',
                'last_name' => 'Trần Minh',
                'email' => 'tuantm@gmail.com',
                'phone' => null,
                'password' => 'e10adc3949ba59abbe56e057f20f883e',
                'avatar' => '8.jpg',
                'email_verified_at' => now(),
                'is_admin' => 0
            ],
            [
                'first_name' => 'Hà',
                'last_name' => 'Hồ Ngọc',
                'email' => 'hahn@gmail.com',
                'phone' => null,
                'password' => 'e10adc3949ba59abbe56e057f20f883e',
                'avatar' => 'no-avatar.png',
                'email_verified_at' => now(),
                'is_admin' => 0
            ],
        ]);
    }
}
