<?php

namespace App\Exports\Sheets;

use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Models\Repuesto;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RepuestoCostSheet implements WithTitle, FromView, WithStyles, ShouldAutoSize, WithEvents, WithColumnFormatting
{
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

    public function view(): View
    {
        if ($this->repuesSelec == 'Todos') {
            return view('excels.repuesto.RepuestoCostSheet', [
                'repues' => Repuesto::whereBetween('created_at', [$this->ini, $this->fin])->get()
            ]);
        } else {
            return view('excels.repuesto.RepuestoCostSheet', [
                'repues' => Repuesto::whereBetween('created_at', [$this->ini, $this->fin])->where('status', $this->repuesSelec)->get()
            ]);
        }
    }

    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_CURRENCY_USD_SIMPLE,
        ];
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
                $cellRange = 'A5:F5';

                $totalRows = $event->sheet->getHighestRow();

                $celAll = 'A5:F'.$totalRows;

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
                                'borders' => [
                                    'allBorders' => [
                                        'borderStyle' => Border::BORDER_MEDIUM,
                                        'color' => ['argb' => 'ff000000'],
                                    ]
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
        if ($this->repuesSelec == 'Todos') {
            return 'Costos de Repuestos';
        } else {
            return 'Costos de Repuestos - '.$this->repuesSelec;
        }
    }
}
