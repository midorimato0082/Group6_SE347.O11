<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            RegionSeeder::class,
            ProvinceSeeder::class,
            ReviewSeeder::class,
            CommentSeeder::class,
            CommentLikeSeeder::class,
            PostLikeSeeder::class,
            RatingSeeder::class
        ]);
    }
}