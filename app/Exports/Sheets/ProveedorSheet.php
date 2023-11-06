<?php

namespace App\Exports\Sheets;

use App\Models\Proveedor;
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

class ProveedorSheet implements FromView,ShouldAutoSize,WithTitle,WithStyles,WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($ini,$fin)
    {
        $this->ini = $ini;
        $this->fin = $fin;    
    }
    public function view(): View
    {
        $proveedores=Proveedor::all()->whereBetween('created_at',[$this->ini,$this->fin]);
        //dd($proveedores);
        return view('excels.proveedor.ProveedorSheets',compact('proveedores'));
    }
    public function styles(Worksheet $sheet)
    {
        return [
            1=>['font'=>['bold'=>true]],
            2=>['font'=>['bold'=>true]],
        ];
    }
    public function registerEvents(): array
    {
        return[
            AfterSheet::class =>function(AfterSheet $event){
                $cabecera='A1:I2';
                $totalRows = $event->sheet->getHighestRow();
                $general='A1:I'.$totalRows;
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
        return 'Proveedores';
    }
}
