<?php

namespace App\Http\Livewire\Productos\Facturas;

use App\Models\ArchivosFactura;
use App\Models\Factura;
use App\Models\ProductosFactura;
use Livewire\Component;

class ShowFactura extends Component
{
    public $facturaID,$factura,$productos,$evidenciaArc;
    public $showFactura=false;
    public function ShowFactura($id){
        $this->factura=Factura::join('proveedors as pr','pr.id','facturas.proveedor_id')
            ->join('estacions as es','es.id','facturas.estacion_id')
            ->where('facturas.deleted_at',null)->where('facturas.id',$id)->orderBy('facturas.id','desc')
            ->select('facturas.*','pr.titulo_proveedor','es.name as estacion')->first();
        $this->productos = ProductosFactura::join('productos as pr','pr.id','productos_facturas.id_producto')
            ->where('id_factura',$id)->select('pr.name')->get();
        $this->evidenciaArc=ArchivosFactura::where('id_factura',$id)->get();
            //dd($this->productos);
        $this->showFactura=true;
    
    }
    public function render()
    {
        return view('livewire.productos.facturas.show-factura');
    }
}
