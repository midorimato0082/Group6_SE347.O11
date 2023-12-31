<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\CommentLike;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentLikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('is_active', true)->get();
        $comments = Comment::all();

        for ($i = 0; $i <= 30; $i++)
            CommentLike::firstOrCreate([
                'user_id' => $users->random()->id,
                'comment_id' => $comments->random()->id,
            ]);
    }
}