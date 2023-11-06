<?php

namespace App\Http\Livewire\Productos\Existencias;

use App\Models\Producto;
use Livewire\Component;

class ProductoDelete extends Component
{
    public $prodID,$modalDelete=false;
    public $pName;
    public function ConfirmDelete($id){
        $supplier=Producto::find($id);
        $this->pName=$supplier->name;
        $this->modalDelete=true;
    }
    public function DeleteProducto($id){
        $supplierDel=Producto::find($id);
        $supplierDel->status="Inactivo";
        $supplierDel->delete();
        $supplierDel->save();
        return redirect()->route('productos');
    }
    public function render()
    {
        return view('livewire.productos.existencias.producto-delete');
    }
}
