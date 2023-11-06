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
use App\Models\Solicitud;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

// class SolicitudContsSheet implements FromQuery, WithTitle, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithEvents
class SolicitudContsSheet implements WithTitle, FromView, WithStyles, ShouldAutoSize, WithEvents
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
            return view('excels.solicitudContsSheet', [
                'solici' => Solicitud::selectRaw('estacion_id, COUNT(categoria_id) as cantidad')
                            ->whereBetween('created_at', [$this->ini, $this->fin])
                            ->groupBy('estacion_id')
                            ->get()
            ]);
        } else {
            return view('excels.solicitudContsSheet', [
                'solici' => Solicitud::selectRaw('estacion_id, COUNT(categoria_id) as cantidad')
                            ->whereBetween('created_at', [$this->ini, $this->fin])
                            ->where('status', $this->statSelec)
                            ->groupBy('estacion_id')
                            ->get()
            ]);
        }
    }

    // public function query()
    // {
    //     return Solicitud::query()
    //             ->selectRaw('estacion_id, COUNT(categoria_id) as cantidad')
    //             ->whereBetween('created_at', [$this->ini, $this->fin])
    //             ->groupBy('estacion_id');
    // }

    // public function headings(): array
    // {
    //     return [
    //         'Estación',
    //         'Cant. Categorias',
    //     ];
    // }

    // public function map($solicitud): array
    // {
    //     return [
    //         $solicitud->estacion->titulo_estacion,
    //         $solicitud->cantidad
    //     ];
    // }

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
                $cellRange = 'A1:B1';

                $totalRows = $event->sheet->getHighestRow();

                $celAll = 'A1:B'.$totalRows;

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
        return 'Cantidad de Categorias';
    }
}
