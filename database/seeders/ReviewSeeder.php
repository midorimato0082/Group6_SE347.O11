<?php

namespace Database\Seeders;

use App\Imports\ReviewsImport;
use App\Models\Post;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Seeder các bảng posts, post_images, places, reviews
        (new ReviewsImport)->import('reviews.xlsx', 'data', \Maatwebsite\Excel\Excel::XLSX);

        foreach (Post::all() as $post)
            $post->update(['view_count' => rand(1, 30)]);
    }
}
