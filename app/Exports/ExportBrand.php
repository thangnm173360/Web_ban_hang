<?php

namespace App\Exports;

use App\Brand;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportBrand implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Brand::all();
    }
}