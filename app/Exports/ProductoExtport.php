<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Exports\Sheets\ProductoSheet;
use App\Exports\Sheets\ProductoCountsSheet;
use App\Exports\Sheets\ProductosFacturasSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ProductoExtport implements WithMultipleSheets
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($ini, $fin)
    {
        $this->ini = $ini;
        $this->fin = $fin;
    }

    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new ProductoSheet($this->ini, $this->fin);
        $sheets[] = new ProductoCountsSheet($this->ini, $this->fin);
        $sheets[]= new ProductosFacturasSheet($this->ini, $this->fin);

        return $sheets;
    }
}
