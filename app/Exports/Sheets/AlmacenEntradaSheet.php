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

class AlmacenEntradaSheet implements WithTitle, FromView, WithStyles, ShouldAutoSize, WithEvents
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
            return view('excels.almacen.AlmacenEntradaSheet', [
                'almac' => DB::table('estacion_producto as ep')
                            ->join('estacions as es','es.id','ep.estacion_id')
                            ->join('folios_historials as fh', 'ep.id', 'fh.estacion_producto_id')
                            ->join('folios', 'fh.folio_id', 'folios.id')
                            ->whereBetween('ep.created_at', [$this->ini, $this->fin])
                            ->where('ep.flag_trash', 0)
                            ->where('folios.isentrada_issalida', 'Entrada')
                            ->select('es.name as estacion','folios.id as folio','folios.*','fh.*')
                            ->orderBy('fh.id','asc')
                            ->get()
            ]);
        } else {
            /* if($this->almaSelec=="Activo"){
                $this->almaSelec = "Aprobado";
            } */
            return view('excels.almacen.AlmacenEntradaSheet', [
                'almac' => DB::table('estacion_producto as ep')
                ->join('estacions as es','es.id','ep.estacion_id')
                ->join('folios_historials as fh', 'ep.id', 'fh.estacion_producto_id')
                ->join('folios', 'fh.folio_id', 'folios.id')
                ->whereBetween('ep.created_at', [$this->ini, $this->fin])
                ->where('ep.flag_trash', 0)
                ->where('folios.isentrada_issalida', 'Entrada')
                ->where('fh.status', $this->almaSelec)
                ->select('es.name as estacion','folios.id as folio','folios.*','fh.*')
                ->orderBy('fh.id','asc')
                ->get()
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
                $cellRange = 'A5:H5';

                $totalRows = $event->sheet->getHighestRow();

                $celAll = 'A5:H'.$totalRows;

                $event->sheet->getDelegate()->getStyle('A1')
                            ->applyFromArray([
                                'font' => [
                                    'bold' => true,
                                    'name' => 'Arial',
                                    'size' => 14,
                                    'color' => [
                                        'rgb' => 'ffffff'
                                    ],
                                ],
                                'borders' => [
                                    'allBorders' => [
                                        'borderStyle' => Border::BORDER_MEDIUM,
                                        'color' => ['argb' => 'ff000000'],
                                    ]
                                ],
                                'alignment' => [
                                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                                    'vertical' => Alignment::VERTICAL_CENTER,
                                ],
                                'fill' => [
                                    'fillType' => Fill::FILL_SOLID,
                                    'color' => ['argb' => 'ffcc0000'],
                                ],
                            ]);

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
            return 'Entradas';
        } else {
            return 'Entradas - '.$this->almaSelec;
        }
    }
}
