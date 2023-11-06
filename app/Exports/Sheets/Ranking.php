<?php

namespace App\Exports\Sheets;

use App\Models\ProductoSolicitud;
use App\Models\Solicitud;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class Ranking implements FromView,ShouldAutoSize,WithTitle,WithStyles,WithEvents,WithColumnFormatting
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $ini;
    private $fin;
    public function __construct($ini,$fin)
    {
        $this->ini = $ini;
        $this->fin = $fin;
    }
    public function view(): View
    {
        /* $datos=ProductoSolicitud::join('solicituds as s','s.id','producto_solicitud.solicitud_id')
        ->join('estacions as e','e.id','s.estacion_id')
        ->groupBy('e.name')
        ->where('s.status','Solicitud Aprobada')
        ->whereBetween('s.created_at',[$this->ini,$this->fin])
        ->select(DB::raw('SUM(total) as total,e.name'))->get(); */
        $datos=Solicitud::join('estacions as e','e.id','solicituds.estacion_id')
        ->leftJoin('producto_solicitud as ps','ps.solicitud_id','solicituds.id')
        ->leftJoin('producto_extraordinario as ex','ex.solicitud_id','solicituds.id')
        ->groupBy('e.name')
        ->where('solicituds.status','Solicitud Aprobada')
        ->whereBetween('solicituds.created_at',[$this->ini,$this->fin])
        ->select(DB::raw('SUM(ps.total) as total,SUM(ex.total) as totalex,SUM(IF(ex.tipo="Servicio",((ex.total -(ex.total*0.16))*0.0125),0)) as isr,e.name'))->get();
        //dd($datos);
        return view('excels.gastos.rank',compact('datos'));
    }
    public function styles(Worksheet $sheet)
    {
        return [
            1=>['font'=>['bold'=>true]],
        ];
    }
    public function columnFormats(): array
    {
        return [
            'B'=>NumberFormat::FORMAT_CURRENCY_USD,
            'C'=>NumberFormat::FORMAT_CURRENCY_USD,
            'D'=>NumberFormat::FORMAT_CURRENCY_USD,
            'E'=>NumberFormat::FORMAT_CURRENCY_USD
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class=>function(AfterSheet $event){
                $cabecera='A1:E1';
                $totalRows = $event->sheet->getHighestRow();
                $general='A1:E'.$totalRows;
                $event->sheet->getDelegate()->getStyle($cabecera)
                            ->applyFromArray([
                                'font' => [
                                    'size'=>12,
                                    'bold' => true,
                                    'color' => ['rgb' => 'ffffff'],
                                ],
                                'alignment' => [
                                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                                    'vertical' => Alignment::VERTICAL_CENTER
                                ],
                                'fill' => [
                                    'fillType' => Fill::FILL_SOLID,
                                    'color' => ['argb' => 'ffcc0000'],
                                ],
                            ]);
                $event->sheet->getDelegate()->getStyle($general)
                ->applyFromArray([
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER
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
        return "Ranking por Estación";
    }
}