<?php

namespace App\Http\Livewire\Permisos;

use Livewire\Component;
use App\Models\Permiso;
use Illuminate\Support\Facades\Auth;

class TablePermisos extends Component
{
    public function render()
    {
        $this->permisos = Permiso::all();

        $this->valid = Auth::user()->permiso->panels->where('id', 5)->first();
        
        return view('livewire.permisos.table-permisos');
    }
}
