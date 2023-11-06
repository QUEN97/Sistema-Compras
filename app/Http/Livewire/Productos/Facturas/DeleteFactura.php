<?php

namespace App\Http\Livewire\Productos\Facturas;

use App\Models\Factura;
use Livewire\Component;

class DeleteFactura extends Component
{
    public $facturaID,$modalDelete=false;
    /* public $pName;
    public function ConfirmDelete($id){
        $supplier=Factura::find($id);
        $this->pName=$supplier->titulo_proveedor;
        $this->modalDelete=true;
    } */
    public function DeleteFactura($id){
        $factura=Factura::find($id);
        $factura->delete();
        return redirect()->route('facturas');
    }
    public function render()
    {
        return view('livewire.productos.facturas.delete-factura');
    }
}
