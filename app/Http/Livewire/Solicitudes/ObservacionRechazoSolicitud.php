<?php

namespace App\Http\Livewire\Solicitudes;

use Livewire\Component;
use App\Models\Solicitud;
use App\Models\Observacion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Notification;
use App\Notifications\NotifiAcepRechaSolicitud;

class ObservacionRechazoSolicitud extends Component
{
    public $rechazarSoli;
    public $solicitud_obser_id;
    public $observacion;

    public function resetFilters()
    {
        $this->reset(['observacion']);
    }

    public function mount()
    {
        $this->resetFilters();

        $this->rechazarSoli = false;
    }

    public function confirmSolicitudRechazo(int $id)
    {
        $solici = Solicitud::where('id', $id)->first();

        $this->solicitud_obser_id = $id;

        $this->resetFilters();

        $this->rechazarSoli=true;
    }

    public function rechazarSolici($id)
    {
        $this->validate([
            'observacion' => ['required', 'not_in:0', 'regex:/[a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/'],
        ],
        [
            'observacion.required' => 'El campo Descripción es obligatorio',
            'observacion.regex' => 'La Descripción solo debe ser Texto, números y guiones medios',
        ]);

        $solici = Solicitud::where('id', $id)->first();

        DB::transaction(function () {
            return tap(Observacion::create([
                'solicitud_id' => $this->solicitud_obser_id,
                'observacion' => $this->observacion,
            ]));
        });

        $solici->forceFill([
            'status' => 'Solicitud Rechazada',
        ])->save();

        if (Auth::user()->permiso_id == 2) {
            Notification::send($solici->estacion->user, new NotifiAcepRechaSolicitud($solici));
        } elseif (Auth::user()->permiso_id != 2 && Auth::user()->permiso_id != 3) {
            Notification::send($solici->estacion->supervisor, new NotifiAcepRechaSolicitud($solici));
        }

        $this->resetFilters();

        Alert::warning('Solicitud Rechazada', "Se ha rechazado la solicitud y se ha enviado la observación");

        //return redirect()->route('solicitudes');
		return redirect(request()->header('Referer'));
    }

    public function render()
    {
        return view('livewire.solicitudes.observacion-rechazo-solicitud');
    }
}
