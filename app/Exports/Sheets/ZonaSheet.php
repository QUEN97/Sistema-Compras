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
use App\Models\Zona;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ZonaSheet implements WithTitle, FromView, WithStyles, ShouldAutoSize, WithEvents
{
    private $ini;
    private $fin;
    private $zonaSelec;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($ini, $fin, $zonaSelec)
    {
        $this->ini = $ini;
        $this->fin = $fin;
        $this->zonaSelec = $zonaSelec;
    }

    public function view(): View
    {
        return view('excels.zona.ZonaSheet', [
            'zonas' => Zona::whereBetween('zonas.created_at', [$this->ini, $this->fin])->get(),
            'productos'=>Zona::join('producto_zona as pz','pz.zona_id','zonas.id')
                        ->selectRaw('COUNT(pz.id) AS total_productos, zonas.name')
                        ->groupBy('zonas.name')
                        ->whereBetween('zonas.created_at', [$this->ini, $this->fin])->get()
        ]);
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
        if ($this->zonaSelec == 'Todos') {
            return 'Zonas';
        } else {
            return 'Zonas - '.$this->zonaSelec;
        }
    }
}
