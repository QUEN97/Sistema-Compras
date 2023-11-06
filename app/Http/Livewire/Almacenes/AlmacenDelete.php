<?php

namespace App\Http\Livewire\Almacenes;

use App\Models\EstacionProducto;
use App\Models\Producto;
use Livewire\Component;

class AlmacenDelete extends Component
{
    public $almaID,$modalDelete=false;
    public $allName, $eName;
    public function ConfirmDelete($id){
        $supplier=EstacionProducto::find($id);
        $this->allName= Producto::where('id',$supplier->producto_id)->first()->name;
        $this->eName = $supplier->estacion->name;
        $this->modalDelete=true;
    }
    public function DeleteSolicitud($id){
        $supplierDel=EstacionProducto::find($id);
        $supplierDel->flag_trash=1;
        $supplierDel->save();
        return redirect()->route('solicitudes');
    }
    
    public function DeleteAlmacen($id){
        $supplierDel=EstacionProducto::find($id);
        $supplierDel->flag_trash=1;
        $supplierDel->save();
        return redirect()->route('almacenes');
    }
    public function render()
    {
        return view('livewire.almacenes.almacen-delete');
    }
}
