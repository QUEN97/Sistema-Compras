<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Exports\Sheets\ZonaSheet;
use App\Exports\Sheets\ZonaEstacionSheet;
use App\Exports\Sheets\ZonaGerenteSheet;
use App\Exports\Sheets\ZonaProductoSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use \Maatwebsite\Excel\Sheet;

class ZonaExport implements WithMultipleSheets
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($ini, $fin, $zonaSelec)
    {
        $this->ini = $ini;
        $this->fin = $fin;
        $this->zonaSelec = $zonaSelec;
    }

    public function sheets(): array
    {
        $sheets = [];

        if ($this->zonaSelec == 'Todos') {
            $sheets[] = new ZonaSheet($this->ini, $this->fin, $this->zonaSelec);
            $sheets[] = new ZonaEstacionSheet($this->ini, $this->fin, $this->zonaSelec);
            $sheets[] = new ZonaGerenteSheet($this->ini, $this->fin, $this->zonaSelec);
            $sheets[] = new ZonaProductoSheet($this->ini, $this->fin, $this->zonaSelec);
        } elseif ($this->zonaSelec == 'Estaciones') {
            $sheets[] = new ZonaEstacionSheet($this->ini, $this->fin, $this->zonaSelec);
        } elseif ($this->zonaSelec == 'Gerentes') {
            $sheets[] = new ZonaGerenteSheet($this->ini, $this->fin, $this->zonaSelec);
        } elseif ($this->zonaSelec == 'Productos') {
            $sheets[] = new ZonaProductoSheet($this->ini, $this->fin, $this->zonaSelec);
        }

        return $sheets;
    }
}
