<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Exports\Sheets\AlmacenSheet;
use App\Exports\Sheets\AlmacenEntradaSheet;
use App\Exports\Sheets\AlmacenSalidaSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use \Maatwebsite\Excel\Sheet;


class AlmacenExpot implements WithMultipleSheets
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($ini, $fin, $almaSelec)
    {
        $this->ini = $ini;
        $this->fin = $fin;
        $this->almaSelec = $almaSelec;
    }
    public function sheets(): array
    {
        $sheets = [];
        $sheets[] = new AlmacenSheet($this->ini, $this->fin, $this->almaSelec);
        $sheets[] = new AlmacenEntradaSheet($this->ini, $this->fin, $this->almaSelec);
        $sheets[] = new AlmacenSalidaSheet($this->ini, $this->fin, $this->almaSelec);

        return $sheets;
    }
}
