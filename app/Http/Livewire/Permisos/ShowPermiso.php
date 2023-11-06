<?php

namespace App\Http\Livewire\Permisos;

use Livewire\Component;
use App\Models\Permiso;
use App\Models\PanelPermiso;
use App\Models\Panel;

class ShowPermiso extends Component
{
    public $ShowgPermiso;
    public $permiso_show_id, $perm;
    public $titulo_permiso, $created_format, $user, $descripcion;

    public function mount()
    {
        $this->ShowgPermiso = false;
    }

    public function confirmShowPermiso(int $id){
        $permiso = Permiso::where('id', $id)->first();

        $this->permiso_show_id = $id;
        $this->titulo_permiso = $permiso->titulo_permiso;
        $this->descripcion = $permiso->descripcion;
        $this->created_format = $permiso->created_format;

        $this->users = $permiso->users->count();

        if ($this->users != 0) {
            $this->user = $this->users;
        } else {
            $this->user = "Sin Usuarios con este Permiso";
        }
        
        $this->ShowgPermiso=true;
    }

    public function render()
    {
        //$this->permisos = Permiso::where('id', $this->permiso_show_id)->first();

        $this->permisos = Panel::all()->take(13);

        $this->perm = PanelPermiso::where('permiso_id', $this->permiso_show_id)->get();

        return view('livewire.permisos.show-permiso');
    }
}
