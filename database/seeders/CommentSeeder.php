<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $comments = Comment::factory()->count(30)->create();

        foreach ($comments->slice(15) as $comment)
            $comment->update(['reply_id' => $comments->slice(0, 15)->where('post_id', $comment->post_id)->first()->id ?? null]);
    }
}
