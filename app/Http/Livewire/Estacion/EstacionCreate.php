<?php

namespace App\Http\Livewire\Estacion;

use Livewire\Component;
use App\Models\User;
use App\Models\Zona;
use App\Models\Estacion;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class EstacionCreate extends Component
{
    public $newgEstacion;
    public $supervisor, $gerente, $zona, $itsTrue;
    public $name, $zonas, $users, $isSuper, $isGeren;

    public function resetFilters()
    {
        $this->reset(['name', 'zona', 'supervisor', 'gerente', 'isSuper', 'isGeren']);
    }

    public function mount()
    {
        
        $this->resetFilters();

        $this->newgEstacion = false;
    }

    public function showModalFormEstacion()
    {
        $this->resetFilters();

        $this->newgEstacion=true;
    }

    public function addEstacion()
    {
        $this->validate( [
            'name' => ['required', 'max:250'],
            'supervisor' => ['required', 'not_in:0'],
            'gerente' => ['required', 'not_in:0'],
            'zona' => ['required', 'not_in:0']
        ],
        [
            'name.required' => 'El Nombre de la Estación es oblogatorio',
            'name.max' => 'El Nombre de la Estación no debe ser mayor a 250 caracteres',
            'supervisor.required' => 'El Supervisor es obligatorio',
            'gerente.required' => 'El Gerente es obligatorio',
            'zona.required' => 'La Zona es obligatoria'
        ]);

        // if ($this->depaId == '' || $this->depaId == null) {
            DB::transaction(function () {
                return tap(Estacion::create([
                    'name' => $this->name,
                    'zona_id' => $this->zona,
                    'user_id' => $this->gerente,
                    'supervisor_id' => $this->supervisor,
                ]));
            });

        $this->mount();

        Alert::success('Nueva Estacion', "La Estacion". ' '.$this->name. ' '. "ha sido agregada al sistema");
        
        return redirect()->route('estaciones');
    }

    public function updatedZona($id)
    {
        $this->isSuper = User::join('user_zona', 'users.id', 'user_zona.user_id')
        ->where('user_zona.zona_id', $id)->where('permiso_id',2)->select('users.*')->get();

    $this->isGeren = User::join('user_zona', 'users.id', 'user_zona.user_id')
        ->where('user_zona.zona_id', $id)->where('permiso_id',3)->select('users.*')->get();
    }

    public function render()
    {
        $this->zonas = Zona::where('status', 'Activo')->get();
        return view('livewire.estacion.estacion-create');
    }
}
