<?php

namespace App\Http\Livewire\Zonas;

use App\Models\Zona;
use Livewire\Component;

class ZonaDelete extends Component
{
    public $zonaID,$modalDelete=false;
    public $zName;
    public function ConfirmDelete($id){
        $supplier=Zona::find($id);
        $this->zName=$supplier->name;
        $this->modalDelete=true;
    }
    public function DeleteZona($id){
        $supplierDel=Zona::find($id);
        $supplierDel->status="Inactivo";
        $supplierDel->save();
        return redirect()->route('zonas');
    }
    public function render()
    {
        return view('livewire.zonas.zona-delete');
    }
}
