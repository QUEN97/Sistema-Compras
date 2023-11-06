<?php

namespace App\Http\Livewire\Zonas;

use App\Models\Zona;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class ZonaEdit extends Component
{
    public $EditZona;
    public $zona_id, $name, $ubicacion, $status;

    public function resetFilters()
    {
        $this->reset(['name', 'ubicacion', 'status']);
    }

    public function mount()
    {
        $this->resetFilters();

        $this->EditZona = false;
    }

    public function confirmZonaEdit(int $id)
    {
        $zona = Zona::where('id', $id)->first();

        $this->zona_id = $id;
        $this->name = $zona->name;
        $this->status = $zona->status;

        $this->EditZona = true;
    }

    public function EditarZona($id)
    {
        $zona = Zona::where('id', $id)->first();

        $this->validate([
            'name' => ['required', 'string', 'max:25', 'regex:/[a-zA-Z-0-9,ñÑáéíóúÁÉÍÓÚ]+$/'],
            'status' => ['required', 'not_in:0'],
        ],
        [
            'name.required' => 'El Nombre de la Zona es obligatorio',
            'name.string' => 'El Nombre de la Zona debe ser solo Texto',
            'name.max' => 'El Nombre de la Zona no debe ser mayor a 25 caracteres',
            'status.required' => 'El Status es obligatorio'
        ]);

        $zona->forceFill([
            'name' => $this->name,
            'status' => $this->status,
        ])->save();

        $this->mount();
        Alert::success('Zona Actualizada', "La Zona". ' '.$this->name. ' '. "ha sido actualizada en el sistema");
        return redirect()->route('zonas');
    }
    public function render()
    {
        return view('livewire.zonas.zona-edit');
    }
}
