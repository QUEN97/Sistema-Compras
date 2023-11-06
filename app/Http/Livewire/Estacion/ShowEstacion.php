<?php

namespace App\Http\Livewire\Estacion;

use Livewire\Component;
use App\Models\Zona;
use App\Models\User;
use App\Models\Estacion;
use Carbon\Carbon;

class ShowEstacion extends Component
{
    public $ShowgEstacion;
    public $estacion_show_id, $producto, $zonastat, $gerentestat, $supervisorstat;
    public $titulo_estacion, $zonas, $ubicacion, $created_at, $gerente, $supervisor, $status;

    public function mount()
    {
        $this->ShowgEstacion = false;
    }

    public function confirmShowEstacion(int $id){
        $estacion = Estacion::where('id', $id)->first();

        $this->estacion_show_id = $id;
        $this->titulo_estacion = $estacion->name;
        $this->zonas = $estacion->zona->name;
        $this->created_at = Carbon::parse($estacion['created_at'])->isoFormat('D MMMM Y  h:mm:ss ');

        $this->user_gerentes = $estacion->user;

        if ($this->user_gerentes != null) {
            $this->gerente = $estacion->user->name;

            $this->gerentestat = $estacion->user->flag_trash;
        } else {
            $this->gerente = "Sin Gerente en esta Estación";
        }

        $this->user_supervisores = $estacion->supervisor;

        if ($this->user_supervisores != null) {
            $this->supervisor = $estacion->supervisor->name;

            $this->supervisorstat = $estacion->supervisor->flag_trash;
        } else {
            $this->supervisor = "Sin Supervisor en esta Estación";
        }

        $this->productos = $estacion->productos->count();

        if ($this->productos != 0) {
            $this->producto = $this->productos;
        } else {
            $this->producto = "Sin Producto en esta Estación";
        }

        $this->status = $estacion->status;

        $this->ShowgEstacion=true;
    }

    public function render()
    {
        $this->estaciones = Estacion::where('id', $this->estacion_show_id)->first();

        return view('livewire.estacion.show-estacion');
    }
}
