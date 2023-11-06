<?php

namespace App\Http\Livewire\Estacion;

use App\Models\Estacion;
use Livewire\Component;

class EstacionDelete extends Component
{
    public $estaID,$modalDelete=false;
    public $eName;
    public function ConfirmDelete($id){
        $supplier=Estacion::find($id);
        $this->eName=$supplier->name;
        $this->modalDelete=true;
    }
    public function DeleteEstacion($id){
        $supplierDel=Estacion::find($id);
        $supplierDel->status="Inactivo";
        $supplierDel->delete();
        $supplierDel->save();
        return redirect()->route('estaciones');
    }
    public function render()
    {
        return view('livewire.estacion.estacion-delete');
    }
}
