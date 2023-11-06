<?php

namespace App\Http\Livewire\Productos\Categorias;

use App\Models\Categoria;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class CategoriaEdit extends Component
{
    public $EditCategoria;
    public $categoria_id, $name, $status;

    public function mount()
    {
        $this->EditCategoria = false;
    }

    public function confirmCategoriaEdit(int $id)
    {
        $categoria = Categoria::where('id', $id)->first();

        $this->categoria_id = $id;
        $this->name = $categoria->name;
        $this->status = $categoria->status;

        $this->EditCategoria = true;
    }

    public function EditarCategoria($id)
    {
        $categoria = Categoria::where('id', $id)->first();

        $this->validate([
            'name' => ['required','max:15'],
            'status' => ['required', 'not_in:0'],
        ],
        [
            'name.required' => 'El Nombre de la Categoria es obligatorio',
            'name.max' => 'El Nombre de la Categoria no debe ser mayor a 250 caracteres',
            'status.required' => 'El Status es obligatorio'
        ]);

        $categoria->forceFill([
            'name' => $this->name,
            'status' => $this->status,
        ])->save();

        $this->EditCategoria = false;
        Alert::success('Categoria Actualizada', "La Categoria". ' '.$this->name. ' '. "ha sido actualizada en el sistema");
        return redirect()->route('categorias');
    }

    public function render()
    {
        return view('livewire.productos.categorias.categoria-edit');
    }
}
