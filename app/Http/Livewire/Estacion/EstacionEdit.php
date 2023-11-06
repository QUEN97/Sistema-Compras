<?php

namespace App\Http\Livewire\Estacion;

use App\Models\Estacion;
use App\Models\User;
use App\Models\Zona;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class EstacionEdit extends Component
{
    public $EditEstacion, $gerente;
    public $estacion_id, $name, $zona, $supervisor, $status,$isSuper, $isGeren;
    
    public function resetFilters()
    {
        $this->reset(['name', 'zona', 'supervisor', 'status', 'gerente']);
    }

    public function mount()
    {
        $this->resetFilters();

        $this->EditEstacion = false;
    }

    public function confirmEstacionEdit(int $id)
    {
        $estacion = Estacion::where('id', $id)->first();

        $this->estacion_id = $id;
        $this->name = $estacion->name;
        $this->zona = $estacion->zona_id;
        $this->gerente = $estacion->user_id;
        $this->supervisor = $estacion->supervisor_id;
        $this->status = $estacion->status;

        $this->EditEstacion = true;
    }

    public function EditarEstacion($id)
    {
        $esta = Estacion::where('id', $id)->first();

        $this->validate( [
            'name' => ['required', 'max:250'],
            'supervisor' => ['required', 'not_in:0'],
            'gerente' => ['required', 'not_in:0'],
            'zona' => ['required', 'not_in:0'],
            'status' => ['required', 'not_in:0'],
        ],
        [
            'name.required' => 'El Nombre de la Estación es oblogatorio',
            'name.max' => 'El Nombre de la Estación no debe ser mayor a 250 caracteres',
            'supervisor.required' => 'El Supervisor es obligatorio',
            'gerente.required' => 'El Gerente es obligatorio',
            'zona.required' => 'La Zona es obligatoria',
            'status.required' => 'El Status es obligatorio',
        ]);

        $esta->forceFill([
            'name' => $this->name,
            'zona_id' => $this->zona,
            'user_id' => $this->gerente,
            'supervisor_id' => $this->supervisor,
            'status' => $this->status,
        ])->save();

        $this->mount();
        Alert::success('Estacion Actualizada', "La Estacion". ' '.$this->name. ' '. "ha sido actualizada en el sistema");
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
        $zonas = Zona::where('status','Activo')->get();
        return view('livewire.estacion.estacion-edit',compact('zonas'));
    }
}
