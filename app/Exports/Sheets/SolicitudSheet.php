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

//class SolicitudSheet implements FromQuery, WithTitle, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithEvents
class SolicitudSheet implements WithTitle, FromView, WithStyles, ShouldAutoSize, WithEvents
{
    private $ini;
    private $fin;
    private $statSelec;
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
            return view('excels.solicitudSheet', [
                'solici' => Solicitud::whereBetween('created_at', [$this->ini, $this->fin])->get()
            ]);
        } else {
            return view('excels.solicitudSheet', [
                'solici' => Solicitud::whereBetween('created_at', [$this->ini, $this->fin])->where('status', $this->statSelec)->get()
            ]);
        }
    }
    // public function query()
    // {
    //     return Solicitud::query()->whereBetween('created_at', [$this->ini, $this->fin]);
    // }

    // public function headings(): array
    // {
    //     return [
    //         'No. Registro',
    //         'Estación',
    //         'Categoria',
    //         'Archivo PDF',
    //         'Status',
    //         'Creado',
    //     ];
    // }

    // public function map($solicitud): array
    // {
    //     return [
    //         $solicitud->id,
    //         $solicitud->estacion->titulo_estacion,
    //         $solicitud->categoria->titulo_categoria,
    //         $solicitud->pdf,
    //         $solicitud->status,
    //         $solicitud->created_format,
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
        return 'Solicitudes';
    }
}
