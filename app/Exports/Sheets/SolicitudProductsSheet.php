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
use App\Models\ProductoSolicitud;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

// class SolicitudProductsSheet implements FromQuery, WithTitle, WithHeadings, WithMapping, WithColumnFormatting, ShouldAutoSize, WithStyles, WithEvents
class SolicitudProductsSheet implements WithTitle, FromView, WithStyles, ShouldAutoSize, WithEvents, WithColumnFormatting
{
    private $ini;
    private $fin;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($ini, $fin, $statSelec)
    {
        $this->ini = $ini;
        $this->fin = $fin;
        $this->statSelec = $statSelec;
    }

    public function view(): View
    {
        if ($this->statSelec == 'Todos') {
            return view('excels.solicitudProductsSheet', [
                'solici' => ProductoSolicitud::join('solicituds', 'producto_solicitud.solicitud_id', '=', 'solicituds.id')
                            ->join('estacions', 'solicituds.estacion_id', '=', 'estacions.id')
                            ->selectRaw('estacions.name as titulo_estacion, solicituds.id, COUNT(producto_solicitud.producto_id) as products, SUM(producto_solicitud.cantidad) as cant, SUM(producto_solicitud.total) as tot')
                            ->whereBetween('solicituds.created_at', [$this->ini, $this->fin])
                            ->where('solicituds.deleted_at', null)
                            ->where('producto_solicitud.flag_trash', 0)
                            ->groupBy('solicituds.id')
                            ->groupBy('estacions.name')
                            ->get()
            ]);
        } else {
            return view('excels.solicitudProductsSheet', [
                'solici' => ProductoSolicitud::join('solicituds', 'producto_solicitud.solicitud_id', '=', 'solicituds.id')
                            ->join('estacions', 'solicituds.estacion_id', '=', 'estacions.id')
                            ->selectRaw('estacions.name as titulo_estacion, solicituds.status, solicituds.id, COUNT(producto_solicitud.producto_id) as products, SUM(producto_solicitud.cantidad) as cant, SUM(producto_solicitud.total) as tot')
                            ->whereBetween('solicituds.created_at', [$this->ini, $this->fin])
                            ->where('solicituds.status', $this->statSelec)
                            ->where('solicituds.deleted_at', null)
                            ->where('producto_solicitud.flag_trash', 0)
                            ->groupBy('solicituds.id')
                            ->groupBy('estacions.name')
                            ->groupBy('solicituds.status')
                            ->get()
            ]);
        }
    }

    
    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_CURRENCY_USD_SIMPLE,
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
                $cellRange = 'A1:E1';

                $totalRows = $event->sheet->getHighestRow();

                $cel = 'A'.$totalRows.':E'.$totalRows;

                $celAll = 'A1:E'.$totalRows;

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

                $event->sheet->getDelegate()->getStyle($cel)
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
            },
        ];
    }

    public function title(): string
    {
        return 'Cantidad de Productos';
    }
}
