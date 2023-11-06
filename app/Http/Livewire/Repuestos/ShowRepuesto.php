<?php

namespace App\Http\Livewire\Repuestos;

use Livewire\Component;
use App\Models\Repuesto;

class ShowRepuesto extends Component
{
    public $ShowgRepuesto;
    public $repuesto_show_id, $archivo, $observaciones;
    public $name, $titulo_estacion, $cantidad, $descripcion, $created_at;

    public function mount()
    {
        $this->ShowgRepuesto = false;
    }

    public function confirmShowRepuesto(int $id){
        $repuest = Repuesto::where('id', $id)->first();

        $this->repuesto_show_id = $id;
        $this->name = $repuest->producto->name;
        $this->titulo_estacion = $repuest->estacion->name;
        $this->observaciones = $repuest->observarepuestos->sortByDesc('created_at');
        $this->cantidad = $repuest->cantidad;
        $this->descripcion = $repuest->descripcion;
        $this->created_at = $repuest->created_format;

        foreach ($repuest->archivos as $alue) {
            $this->archivo = $alue->archivo_path;
        }

        $this->ShowgRepuesto=true;
    }

    public function render()
    {
        $this->repuestos = Repuesto::where('id', $this->repuesto_show_id)->first();

        return view('livewire.repuestos.show-repuesto');
    }
}
