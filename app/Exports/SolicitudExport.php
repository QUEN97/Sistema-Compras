<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Exports\Sheets\SolicitudSheet;
use App\Exports\Sheets\SolicitudContsSheet;
use App\Exports\Sheets\SolicitudProductsSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use \Maatwebsite\Excel\Sheet;

class SolicitudExport implements WithMultipleSheets
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($ini, $fin, $statSelec)
    {
        $this->ini = $ini;
        $this->fin = $fin;
        $this->statSelec = $statSelec;
    }

    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new SolicitudSheet($this->ini, $this->fin, $this->statSelec);
        $sheets[] = new SolicitudContsSheet($this->ini, $this->fin, $this->statSelec);
        $sheets[] = new SolicitudProductsSheet($this->ini, $this->fin, $this->statSelec);

        return $sheets;
    }
}
