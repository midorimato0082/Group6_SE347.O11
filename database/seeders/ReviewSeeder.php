<?php

namespace Database\Seeders;

use App\Imports\ReviewsImport;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        (new ReviewsImport)->import('reviews.xlsx', 'data', \Maatwebsite\Excel\Excel::XLSX);
    }
}
