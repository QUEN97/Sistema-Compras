<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Exports\Sheets\RepuestoSheet;
use App\Exports\Sheets\RepuestoCostSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RepuestoExtport implements WithMultipleSheets
{
    use Exportable;
    private $ini;
    private $fin;
    private $repuesSelec;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($ini, $fin, $repuesSelec)
    {
        $this->ini = $ini;
        $this->fin = $fin;
        $this->repuesSelec = $repuesSelec;
    }

    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new RepuestoSheet($this->ini, $this->fin, $this->repuesSelec);
        $sheets[] = new RepuestoCostSheet($this->ini, $this->fin, $this->repuesSelec);

        return $sheets;
    }
}
