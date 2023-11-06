<?php

namespace App\Exports;

use App\Models\Categoria;
use App\Models\Solicitud;
use App\Models\Zona;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GeneralExport implements WithTitle,FromView,ShouldAutoSize
{
    use Exportable;
    
    private $ini;
    private $fin;

    private $solici;
    private $categori;
    private $zona;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($ini, $fin)
    {
        $this->ini = $ini;
        $this->fin = $fin;

        $this->solici = Solicitud::join('estacions as e', 'e.id', 'solicituds.estacion_id')
                                ->join('producto_solicitud as ps', 'ps.solicitud_id', 'solicituds.id')
                                ->join('categorias as c', 'c.id', 'solicituds.categoria_id')
                                ->join('zonas as z', 'z.id', 'e.zona_id')
                                ->whereBetween('solicituds.created_at', [$this->ini, $this->fin])
                                ->selectRaw('e.id as estID, c.id as catID, SUM(ps.total) as total,SUM(ps.cantidad) as cantidad, e.zona_id')
                                ->groupBy('e.id')
                                ->groupBy('c.id')
                                ->groupBy('z.name')
                                ->groupBy('e.zona_id')
                                ->get();

        $this->categori = Categoria::select('id', 'name')
                                    ->get();

        $this->zona = Zona::select('id', 'name')
                            ->get();
                            //dd($this->solici);
    }

    public function view(): View
    {
        return view('excels.general.GeneralSheet', [
                'soliTot' => $this->solici,
                'categ' => $this->categori,
                'zonas' => $this->zona,
        ]);
    }

    /* public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class   => function(AfterSheet $event){

                $sum = 10;

                for ($i=7; $i <= 87;) { 
                    for ($j=13; $j <= 93;) { 
                        $event->sheet->getDelegate()->getStyle('A'.$i.':A'.$j)
                            ->applyFromArray([
                                'font' => [
                                    'bold' => true,
                                    'color' => [
                                        'rgb' => 'ffffff'
                                    ],
                                    'name' => 'Arial',
                                    'size' => 12,
                                ],
                                'alignment' => [
                                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                                ],
                                'fill' => [
                                    'fillType' => Fill::FILL_SOLID,
                                    'color' => ['argb' => 'ffcc0000'],
                                ],
                                'borders' => [
                                    'allBorders' => [
                                        'borderStyle' => Border::BORDER_MEDIUM,
                                        'color' => ['argb' => 'ff000000'],
                                    ]
                                    ],
                            ]);

                        $event->sheet->getDelegate()->getStyle('B'.$i.':E'.$j)
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
                                ],
                            ]);

                        $event->sheet->getDelegate()->getStyle('B'.$i.':E'.$j)->getNumberFormat()
                                        ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

                        $i += $sum;
		                $j += $sum;
                    }
                }

                for ($i=5; $i <= 85;) { 
                    $event->sheet->getDelegate()->getStyle('B'.$i)
                    ->applyFromArray([
                        'font' => [
                            'bold' => true,
                            'name' => 'Arial',
                            'size' => 12,
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

                    $i += $sum;
                }

                for ($i=6; $i <= 86;) { 
                    $event->sheet->getDelegate()->getStyle('B'.$i.':E'.$i)
                    ->applyFromArray([
                        'font' => [
                            'bold' => true,
                            'name' => 'Arial',
                            'size' => 12,
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
                            'color' => ['argb' => 'ff989898'],
                        ],
                    ]);

                    $i += $sum;
                }

                $cellRange = 'A1:G1';

                $event->sheet->getDelegate()->getStyle($cellRange)
                            ->applyFromArray([
                                'font' => [
                                    'bold' => true,
                                    'color' => [
                                        'rgb' => 'ffffff'
                                    ],
                                    'name' => 'Arial',
                                    'size' => 12,
                                ],
                                'alignment' => [
                                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                                    'vertical' => Alignment::VERTICAL_CENTER,
                                ],
                                'fill' => [
                                    'fillType' => Fill::FILL_SOLID,
                                    'color' => ['argb' => 'ffcc0000'],
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
    } */

    public function title(): string
    {
        return 'Reporte General';
    }
}
