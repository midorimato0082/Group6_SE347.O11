<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('likes')->insert([
            [
                'user_id' => 5,
                'review_id' => 1,
                'is_like' => 1,
                'created_at' => now()
            ],
            [
                'user_id' => 5,
                'review_id' => 2,
                'is_like' => 0,
                'created_at' => now()
            ],
            [
                'user_id' => 5,
                'news_id' => 2,
                'is_like' => 1,
                'created_at' => now()
            ]
        ]);
    }
}
