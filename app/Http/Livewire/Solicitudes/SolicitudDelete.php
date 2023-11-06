<?php

namespace App\Http\Livewire\Solicitudes;

use App\Models\Solicitud;
use Livewire\Component;

class SolicitudDelete extends Component
{
    public $solicID,$modalDelete=false;
    public $sName, $tName, $eName;

    public function ConfirmDelete($id){
        $supplier=Solicitud::find($id);
        $this->sName=$supplier->id;
        $this->tName= $supplier->tipo_compra;
        $this->eName= $supplier->estacion->name;
        $this->modalDelete=true;
    }
    public function DeleteSolicitud($id){
        $supplierDel=Solicitud::find($id);
        $supplierDel->delete();
        $supplierDel->save();
        return redirect()->route('solicitudes');
    }
    public function render()
    {
        return view('livewire.solicitudes.solicitud-delete');
    }
}
