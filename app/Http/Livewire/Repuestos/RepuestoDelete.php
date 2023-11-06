<?php

namespace App\Http\Livewire\Repuestos;

use App\Models\Estacion;
use App\Models\Producto;
use App\Models\Repuesto;
use Livewire\Component;

class RepuestoDelete extends Component
{
    public $repuestoID,$modalDelete=false;
    public $rName, $eName;
    public function ConfirmDelete($id){
        $supplier=Repuesto::find($id);
        $this->rName= Producto::where('id',$supplier->producto_id)->first()->name;
        $this->eName= Estacion::where('id',$supplier->estacion_id)->first()->name;
        $this->modalDelete=true;
    }
    public function DeleteRepuesto($id){
        $supplierDel=Repuesto::find($id);
        $supplierDel->flag_trash=1;
        $supplierDel->save();
        return redirect()->route('repuestos');
    }
    public function render()
    {
        return view('livewire.repuestos.repuesto-delete');
    }
}
