<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_comment')->insert([
            [
                'content' => 'Cảm ơn HomeStay Review. Bài viết của các bạn rất bổ ích cho tôi.',
                'user_id' => 5,
                'review_id' => 1,
                'created_at' => now()
            ],
            [
                'content' => 'Viết quá chuẩn luôn. Đã từng đến đây rồi và thiệt sự tuyệt vời lắm đó.',
                'user_id' => 5,
                'review_id' => 1,
                'created_at' => now()
            ],
            [
                'content' => 'Viết quá chuẩn luôn. Đã từng đến đây rồi.',
                'user_id' => 5,
                'news_id' => 2,
                'created_at' => now()
            ]
        ]);
    }
}
