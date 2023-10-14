<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LikeDislikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_like_dislike')->insert([
            [
                'user_id' => 5,
                'review_id' => 1,
                'status' => 1,
                'created_at' => now()
            ],
            [
                'user_id' => 5,
                'review_id' => 2,
                'status' => 0,
                'created_at' => now()
            ],
            [
                'user_id' => 5,
                'news_id' => 2,
                'status' => 1,
                'created_at' => now()
            ]
        ]);
    }
}
