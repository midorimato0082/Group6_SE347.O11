<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostLike;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostLikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('is_active', true)->get();
        $posts = Post::all();

        for ($i = 0; $i <= 30; $i++)
            PostLike::firstOrCreate(
                [
                    'user_id' => $users->random()->id,
                    'post_id' => $posts->random()->id
                ],
                [
                    'is_like' => mt_rand(0, 1)
                ]
            );
    }
}
