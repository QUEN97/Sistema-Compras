<?php

namespace App\Exports\Sheets;

use App\Models\ArchivosFactura;
use App\Models\Factura;
use Illuminate\Contracts\View\View;
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


class ProductosFacturasSheet implements WithTitle,FromView,WithStyles,ShouldAutoSize,WithEvents
{
    private $ini,$fin;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($ini,$fin){
        $this->ini = $ini;
        $this->fin = $fin;
    }
    public function view():View
    {
        $facturas=Factura::join('archivos_facturas as af','af.id_factura','facturas.id')
            ->join('estacions as e','e.id','facturas.estacion_id')
            ->join('proveedors as p','p.id','facturas.proveedor_id')
            /* ->join('productos_facturas as pf', 'pf.id_factura','facturas.id')
            ->join('productos as ps','ps.id','pf.id_producto') */
            ->select('af.nombre_archivo','facturas.*','e.name as estacion','p.titulo_proveedor as proveedor')
            ->get();
            $rows=ArchivosFactura::selectRaw('COUNT(id_factura) AS nrow, id_factura')->groupBy('id_factura')->get();
            //dd($rows);
        return view('excels.producto.ProductosFacturasSheet',compact('facturas','rows'));
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
                $cellFact= 'A2:A'.$totalRows;

                $celAll = 'A1:E'.$totalRows;


                $event->sheet->getDelegate()->getStyle($cellRange)
                            ->applyFromArray([
                                'font' => [
                                    'bold' => true,
                                    'size'=>12,
                                    'color' => [
                                        'rgb' => 'ffffff'
                                    ],
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


                $event->sheet->getDelegate()->getStyle($cellFact)
                ->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size'=>12,
                        'color' => [
                            'rgb' => 'ffffff'
                        ],
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
                $event->sheet->getDelegate()->getStyle($celAll)
                            ->applyFromArray([
                                'font' => [
                                    'name' => 'Arial',
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
    public function title():string{
        return 'Facturas de Productos';
    }
}
