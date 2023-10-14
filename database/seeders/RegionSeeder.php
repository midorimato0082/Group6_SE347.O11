<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_region')->insert([
            [
                'name' => 'Miền Bắc',
                'slug' => 'mien-bac'
            ],
            [
                'name' => 'Miền Nam',
                'slug' => 'mien-nam'
            ],
            [
                'name' => 'Miền Trung',
                'slug' => 'mien-trung'
            ],
            [
                'name' => 'Miền Tây',
                'slug' => 'mien-tay'
            ],
        ]);
    }
}
