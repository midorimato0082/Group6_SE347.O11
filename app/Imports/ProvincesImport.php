<?php

namespace App\Imports;

use App\Models\District;
use App\Models\Province;
use App\Models\Region;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class ProvincesImport implements ToModel, WithHeadingRow, WithUpserts
{
    use Importable;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Province([
                'name' => $row['tinh_thanh'],
                'slug' => Str::slug(Str::limit($row['tinh_thanh'], 20)),
                'region_id' => Region::where('name', $row['vung'])->first()->id
        ]);
    }

    public function uniqueBy()
    {
        return 'name';
    }
}