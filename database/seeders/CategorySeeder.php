<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_category')->insert([
            [
                'name' => 'Homestay',
                'slug' => 'homestay'
            ],
            [
                'name' => 'Khách sạn',
                'slug' => 'hotel'
            ],
            [
                'name' => 'Resort',
                'slug' => 'resort'
            ],
            [
                'name' => 'Motel',
                'slug' => 'motel'
            ],
        ]);
    }
}
