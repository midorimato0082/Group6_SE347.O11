<?php

namespace Database\Seeders;

use App\Imports\ProvincesImport;
use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        (new ProvincesImport)->import('provinces.xlsx', 'data', \Maatwebsite\Excel\Excel::XLSX);
    }
}
