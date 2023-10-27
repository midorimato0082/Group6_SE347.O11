<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
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
                'first_name' => 'Name 1',
                'last_name' => 'No',
                'email' => 'user1@gmail.com',
                'phone' => null,
                'password' => 'e10adc3949ba59abbe56e057f20f883e',
                'avatar' => '5.jpg',
                'email_verified_at' => now(),
                'is_admin' => 0
            ],
            [
                'first_name' => 'Name 2',
                'last_name' => 'No',
                'email' => 'user2@gmail.com',
                'phone' => null,
                'password' => 'e10adc3949ba59abbe56e057f20f883e',
                'avatar' => 'no-avatar.png',
                'email_verified_at' => null,
                'is_admin' => 0
            ],
            [
                'first_name' => 'Name 3',
                'last_name' => 'No',
                'email' => 'user3@gmail.com',
                'phone' => null,
                'password' => 'e10adc3949ba59abbe56e057f20f883e',
                'avatar' => '7.jpg',
                'email_verified_at' => now(),
                'is_admin' => 0
            ],
            [
                'first_name' => 'Name 4',
                'last_name' => 'No',
                'email' => 'user4@gmail.com',
                'phone' => null,
                'password' => 'e10adc3949ba59abbe56e057f20f883e',
                'avatar' => '8.jpg',
                'email_verified_at' => now(),
                'is_admin' => 0
            ],
            [
                'first_name' => 'Name 5',
                'last_name' => 'No',
                'email' => 'user5@gmail.com',
                'phone' => null,
                'password' => 'e10adc3949ba59abbe56e057f20f883e',
                'avatar' => 'no-avatar.png',
                'email_verified_at' => now(),
                'is_admin' => 0
            ],
        ]);
    }
}
