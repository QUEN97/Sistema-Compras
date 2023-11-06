<?php

namespace App\Http\Livewire\Productos\Categorias;

use App\Models\Categoria;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class CategoriaCreate extends Component
{
    public $newgCategoria;
    public $name;

    public function mount()
    {
        $this->newgCategoria = false;
    }

    public function showModalFormCategoria(){
        $this->newgCategoria = true;
    }

    public function addCategoria()
    {
        $this->validate( [
            'name' => ['required', 'max:250',],
        ],
        [
            'name.required' => 'El Nombre de la Categoria es obligatorio',
            'name.max' => 'El Nombre de la Categoria no debe ser mayor a 250 caracteres',
        ]);

        DB::transaction(function () {
            return tap(Categoria::create([
                'name' => $this->name,
            ]));
        });

        $this->mount();

        Alert::success('Nueva Categoria', "La Categoria". ' '.$this->name. ' '. "ha sido agregada al sistema");

        return redirect()->route('categorias');
    }
    public function render()
    {
        return view('livewire.productos.categorias.categoria-create');
    }
}
