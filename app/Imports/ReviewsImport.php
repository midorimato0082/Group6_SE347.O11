<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReviewsImport implements WithMultipleSheets
{
    use Importable, RegistersEventListeners;

    public function sheets(): array
    {
        return [
            'Bài viết' => new PostsImport(),
            'Hình' => new PostImagesImport(),
            'Nơi review' => new PlacesImport()
        ];
    }
}