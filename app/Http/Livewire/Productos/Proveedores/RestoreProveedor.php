<?php

namespace App\Http\Livewire\Productos\Proveedores;

use App\Models\Proveedor;
use Livewire\Component;

class RestoreProveedor extends Component
{
    public $proveedorID,$modalRestore=false;
    public $pName;
    public function ConfirmRestore($id){
        $supplier=Proveedor::find($id);
        $this->pName=$supplier->titulo_proveedor;
        $this->modalRestore=true;
    }
    public function RestoreProveedor($id){
        $supplierDel=Proveedor::find($id);
        $supplierDel->flag_trash=0;
        $supplierDel->save();
        return redirect()->route('proveedores.trash');
    }
    public function render()
    {
        return view('livewire.productos.proveedores.restore-proveedor');
    }
}
