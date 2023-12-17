<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Homestay',
                'slug' => 'homestay',
                'is_place' => true
            ],
            [
                'name' => 'Khách sạn',
                'slug' => 'hotel',
                'is_place' => true
            ],
            [
                'name' => 'Resort',
                'slug' => 'resort',
                'is_place' => true
            ],
            [
                'name' => 'Tin tức',
                'slug' => 'tin-tuc',
                'is_place' => false
            ]
        ]);
    }
}
