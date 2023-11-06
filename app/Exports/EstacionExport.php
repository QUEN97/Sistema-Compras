<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Exports\Sheets\EstacionSheet;
use App\Exports\Sheets\EstacionProductoSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use \Maatwebsite\Excel\Sheet;

class EstacionExport implements WithMultipleSheets
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

        $sheets[] = new EstacionSheet($this->ini, $this->fin);
        $sheets[] = new EstacionProductoSheet($this->ini, $this->fin);

        return $sheets;
    }
}
