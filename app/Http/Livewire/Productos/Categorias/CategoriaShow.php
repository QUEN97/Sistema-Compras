<?php

namespace App\Http\Livewire\Productos\Categorias;

use Livewire\Component;
use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Proveedor;

class CategoriaShow extends Component
{
    public $ShowgCategoria;
    public $categoria_show_id;
    public $titulo_categoria, $productos, $created_at, $status, $proveedores;

    public function mount()
    {
        $this->ShowgCategoria = false;
    }

    public function confirmShowCategoria(int $id){
        $categoria = Categoria::where('id', $id)->first();

        $this->categoria_show_id = $id;
        $this->titulo_categoria = $categoria->name;
        $this->created_at = $categoria->created_at;

        $this->cat_productos = Producto::where('categoria_id', $id)->count();

        $this->cat_proveedores = Proveedor::where('categoria_id', $id)->count();

        if ($this->cat_productos != 0) {
            $this->productos = $this->cat_productos;
        } else {
            $this->productos = "Sin Productos en esta Categoria";
        }

        if ($this->cat_proveedores != 0) {
            $this->proveedores = $this->cat_proveedores;
        } else {
            $this->proveedores = "Sin Proveedores con esta Categoria";
        }

        $this->status = $categoria->status;

        $this->ShowgCategoria=true;
    }

    public function render()
    {
        $this->productos_tabla = Producto::where('categoria_id', $this->categoria_show_id)->get();

        $this->proveedores_tabla = Proveedor::where('categoria_id', $this->categoria_show_id)->get();

        return view('livewire.productos.categorias.categoria-show');
    }
}
