<?php

namespace Database\Seeders;

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
            LocationSeeder::class,  
            ReviewSeeder::class,
            ReviewImagesSeeder::class,
            NewsSeeder::class,
            CommentSeeder::class,
            LikeSeeder::class
        ]);
    }
}