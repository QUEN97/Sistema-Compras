<?php

namespace App\Http\Livewire\Productos\Categorias;

use App\Models\Categoria;
use Livewire\Component;

class CategoriaDelete extends Component
{
    public $catID,$modalDelete=false;
    public $cName;
    public function ConfirmDelete($id){
        $supplier=Categoria::find($id);
        $this->cName=$supplier->name;
        $this->modalDelete=true;
    }
    public function DeleteCategoria($id){
        $supplierDel=Categoria::find($id);
        $supplierDel->status="Inactivo";
        $supplierDel->delete();
        $supplierDel->save();
        return redirect()->route('categorias');
    }
    public function render()
    {
        return view('livewire.productos.categorias.categoria-delete');
    }
}
