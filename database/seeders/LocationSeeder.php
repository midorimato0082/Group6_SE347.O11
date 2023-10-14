<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_location')->insert([
            [
                'name' => 'Đà Lạt',
                'slug' => 'da-lat',
                'region_id' => 2
            ],
            [
                'name' => 'Ninh Bình',
                'slug' => 'ninh-binh',
                'region_id' => 1
            ],
            [
                'name' => 'Huế',
                'slug' => 'hue',
                'region_id' => 3
            ],
            [
                'name' => 'Bến Tre',
                'slug' => 'ben-tre',
                'region_id' => 4
            ],
            [
                'name' => 'Thành phố Nha Trang',
                'slug' => 'thanh-pho-nha-trang',
                'region_id' => 3
            ],
            [
                'name' => 'Khánh Hòa',
                'slug' => 'khanh-hoa',
                'region_id' => 3
            ],
        ]);
    }
}
