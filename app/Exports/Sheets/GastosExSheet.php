<?php

namespace App\Exports\Sheets;

use App\Models\ProductoExtraordinario;
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

class GastosExSheet implements FromView,ShouldAutoSize,WithTitle,WithStyles,WithColumnFormatting,WithEvents
{
    private $ini;
    private $fin;
    public function __construct($ini,$fin)
    {
        $this->ini = $ini;
        $this->fin = $fin;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $datos=Solicitud::where('tipo_compra','Extraordinario')
        ->where('solicituds.status','Solicitud Aprobada')
        ->whereBetween('created_at',[$this->ini,$this->fin])->get();
        $total=ProductoExtraordinario::join('solicituds as s','s.id','producto_extraordinario.solicitud_id')
        ->where('tipo_compra','Extraordinario')
        ->where('s.status','Solicitud Aprobada')
        ->whereBetween('s.created_at',[$this->ini,$this->fin])
        ->select(DB::raw('SUM(producto_extraordinario.total) as total,SUM(IF(producto_extraordinario.tipo="Servicio",((producto_extraordinario.total -(producto_extraordinario.total*0.16))*0.0125),0)) as isr'))->get();
        //->sum('producto_extraordinario.total');
        //dd($total);
        return view('excels.gastos.gastosEX',compact('datos','total'));
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
            'C'=>NumberFormat::FORMAT_CURRENCY_USD,
            'D'=>NumberFormat::FORMAT_CURRENCY_USD,
            'E'=>NumberFormat::FORMAT_CURRENCY_USD,
            'F'=>NumberFormat::FORMAT_CURRENCY_USD
        ];
    }

    public function registerEvents(): array
    {
        return[
            AfterSheet::class=>function(AfterSheet $event){
                $cabecera='A1:G1';
                $totalRows = $event->sheet->getHighestRow();
                $general='A1:G'.$totalRows;
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
        return "Compras extraordinarias";
    }
}