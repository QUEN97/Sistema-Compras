<?php

namespace App\Exports\Sheets;

use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Models\EstacionProducto;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class AlmacenSheet implements WithTitle, FromView, WithStyles, ShouldAutoSize, WithEvents
{
    private $ini;
    private $fin;
    private $almaSelec;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($ini, $fin, $almaSelec)
    {
        $this->ini = $ini;
        $this->fin = $fin;
        $this->almaSelec = $almaSelec;
    }

    public function view(): View
    {
        if ($this->almaSelec == 'Todos') {
            return view('excels.almacen.AlmacenSheet', [
                'almac' => DB::table('estacion_producto as ep')
                ->join('estacions as e','e.id','ep.estacion_id')
                ->join('productos as p','p.id','ep.producto_id')
                ->whereBetween('ep.created_at', [$this->ini, $this->fin])
                ->select('ep.*','e.name as estacion','p.name as producto')->get()
            ]);
        } else {
            if($this->almaSelec=="Aprobado"){
                $this->almaSelec = "Activo";
            }
            return view('excels.almacen.AlmacenSheet', [
                'almac' => DB::table('estacion_producto as ep')
                ->join('estacions as e','e.id','ep.estacion_id')
                ->join('productos as p','p.id','ep.producto_id')
                ->whereBetween('ep.created_at', [$this->ini, $this->fin])
                ->select('ep.*','e.name as estacion','p.name as producto')
                ->where('ep.status', $this->almaSelec)->get()
            ]);
        }
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class   => function(AfterSheet $event){
                $cellRange = 'A1:F1';

                $totalRows = $event->sheet->getHighestRow();

                $celAll = 'A1:F'.$totalRows;

                $event->sheet->getDelegate()->getStyle($cellRange)
                            ->applyFromArray([
                                'font' => [
                                    'bold' => true,
                                    'color' => [
                                        'rgb' => 'ffffff'
                                    ],
                                ],
                                'alignment' => [
                                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                                ],
                                'fill' => [
                                    'fillType' => Fill::FILL_SOLID,
                                    'color' => ['argb' => 'ffcc0000'],
                                ],
                            ]);

                $event->sheet->getDelegate()->getStyle($celAll)
                            ->applyFromArray([
                                'font' => [
                                    'name' => 'Arial',
                                    'size' => 12,
                                ],
                                'borders' => [
                                    'allBorders' => [
                                        'borderStyle' => Border::BORDER_MEDIUM,
                                        'color' => ['argb' => 'ff000000'],
                                    ]
                                ]
                            ]);
            }
        ];
    }

    public function title(): string
    {
        if ($this->almaSelec == 'Todos') {
            return 'Almacenes';
        } else {
            return 'Almacenes - '.$this->almaSelec;
        }
    }
}
