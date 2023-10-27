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
                'user_id' => 3,
                'news_id' => 1,
                'created_at' => now()
            ],
            [
                'content' => 'Bài viết thật hay, nơi đây rất đẹp',
                'user_id' => 4,
                'news_id' => 2,
                'created_at' => now()
            ],
            [
                'content' => 'Đọc bài này xong lại làm mình muốn đi lần nữa!',
                'user_id' => 3,
                'news_id' => 2,
                'created_at' => now()
            ],
            [
                'content' => 'Những trải nghiệm ở đây sẽ không bao giờ quên được.',
                'user_id' => 2,
                'news_id' => 1,
                'created_at' => now()
            ],
            [
                'content' => 'Đúng thật, rất đề cử nơi này luôn!',
                'user_id' => 2,
                'news_id' => 2,
                'created_at' => now()
            ]
        ]);
    }
}
