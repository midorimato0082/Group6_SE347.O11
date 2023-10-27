<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            RegionSeeder::class,
            LocationSeeder::class,  
            ReviewSeeder::class,
            NewsSeeder::class,
            CommentSeeder::class,
            LikeSeeder::class
        ]);
    }
}