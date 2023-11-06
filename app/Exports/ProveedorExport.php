<?php

namespace App\Exports;

use App\Exports\Sheets\ProveedorSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ProveedorExport implements WithMultipleSheets
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($ini,$fin)
    {
        $this->ini = $ini;
        $this->fin = $fin;
    }
    public function sheets(): array
    {
        $sheet=[];
        array_push($sheet,new ProveedorSheet($this->ini,$this->fin));
        return $sheet;
    }
}
