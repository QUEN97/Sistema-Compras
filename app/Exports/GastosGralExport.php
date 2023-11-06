<?php

namespace App\Exports;

use App\Exports\Sheets\GastosExSheet;
use App\Exports\Sheets\GastosGralSheet;
use App\Exports\Sheets\Ranking;
use App\Exports\Sheets\RankingCategoriasSheet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class GastosGralExport implements WithMultipleSheets
{
    private $ini;
    private $fin;
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
        array_push($sheet,new GastosGralSheet($this->ini,$this->fin));
        array_push($sheet,new GastosExSheet($this->ini,$this->fin));
        array_push($sheet,new Ranking($this->ini,$this->fin));
        array_push($sheet, new RankingCategoriasSheet($this->ini,$this->fin));
        return$sheet;
    }
}