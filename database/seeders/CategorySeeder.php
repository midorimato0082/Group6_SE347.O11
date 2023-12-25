<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Homestay',
            'slug' => 'homestay'
        ]);

        Category::create([
            'name' => 'Khách sạn',
            'slug' => 'hotel'
        ]);

        Category::create([
            'name' => 'Resort',
            'slug' => 'resort'
        ]);

        Category::create([
            'name' => 'Tin tức',
            'slug' => 'tin-tuc',
            'is_place' => false,
            'is_active' => false
        ]);
    }
}
