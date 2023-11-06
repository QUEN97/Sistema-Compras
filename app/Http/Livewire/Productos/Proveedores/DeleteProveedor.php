<?php

namespace App\Http\Livewire\Productos\Proveedores;

use App\Models\Proveedor;
use Livewire\Component;

class DeleteProveedor extends Component
{
    public $proveedorID,$modalDelete=false;
    public $pName;
    public function ConfirmDelete($id){
        $supplier=Proveedor::find($id);
        $this->pName=$supplier->titulo_proveedor;
        $this->modalDelete=true;
    }
    public function DeleteProveedor($id){
        $supplierDel=Proveedor::find($id);
        $supplierDel->flag_trash=1;
        $supplierDel->save();
        return redirect()->route('proveedores');
    }
    public function render()
    {
        return view('livewire.productos.proveedores.delete-proveedor');
    }
}
