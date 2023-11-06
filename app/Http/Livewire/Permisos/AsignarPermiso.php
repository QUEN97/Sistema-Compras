<?php

namespace App\Http\Livewire\Permisos;

use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Permiso;
use App\Models\PanelPermiso;
use App\Models\Panel;

class AsignarPermiso extends Component
{
    public $AsigPermiso, $name, $le, $check;
    public $permiso_asig_id, $perm, $permiso_asig_name;

    public $leer = [];
    public $crear = [];
    public $editar = [];

    public function mount()
    {
        $this->AsigPermiso = false;
    }

    public function confirmPermisoAsig(int $id)
    {
        $permiso = Permiso::where('id', $id)->first();

        $this->permiso_asig_id = $id;
        $this->permiso_asig_name = $permiso->titulo_permiso;
        $this->titulo_permiso = $permiso->titulo_permiso;
        $this->descripcion = $permiso->descripcion;

        $this->AsigPermiso = true;
    }

    public function AsignarPermiso($id, Request $request)
    {
        $this->validate([
            'titulo_permiso' => ['required', 'string', 'max:30', 'regex:/[a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/'],
            'descripcion' => ['required', 'string', 'max:200', 'regex:/[a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/'],
        ],
        [
            'titulo_permiso.required' => 'El campo Nombre de Rol es obligatorio',
            'titulo_permiso.string' => 'El campo Nombre de Rol debe ser Texto',
            'titulo_permiso.max' => 'El campo Nombre de Rol no debe ser mayor a 30 caracteres',
            'titulo_permiso.regex' => 'El Nombre de Rol solo debe ser Texto y números',
            'descripcion.required' => 'El campo Descripción es obligatorio',
            'descripcion.string' => 'El campo Descripción debe ser Texto',
            'descripcion.max' => 'El campo Descripción no debe ser mayor a 200 caracteres',
            'descripcion.regex' => 'El Nombre de Rol solo debe ser Texto y números',
        ]);

        for ($i=1; $i <= count(Panel::all()); $i++) { 
            foreach ($this->leer as $key => $value) {
                $permi = PanelPermiso::where('permiso_id', $id)->where('panel_id', $i)->first();

                $permi->forceFill([ 
                    're' => $value['valer'],
                ])->save();
            }
        }
            
        $this->AsigPermiso = false;

        Alert::success('Permisos Actualizados', "El Rol". ' '.$this->titulo_permiso. ' '. "ha actualizado sus permisos en el sistema");

        return redirect()->route('roles');
    }

    public function render()
    {
        //$this->permission = Permiso::where('id', $this->permiso_asig_id)->first();

        $this->permission = Panel::all()->take(13);

        $this->perm = PanelPermiso::where('permiso_id', $this->permiso_asig_id)->get();
        
        return view('livewire.permisos.asignar-permiso');
    }
}
