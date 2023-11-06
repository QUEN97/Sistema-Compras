<?php

namespace App\Http\Livewire\Repuestos;

use Livewire\Component;
use App\Models\Repuesto;
use App\Models\Observarepuesto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Notifications\NotifiAcepRechaRepuesto;
use Illuminate\Support\Facades\Notification;

class ObservacionRechazoRpuesto extends Component
{
    public $rechazarRepues;
    public $repuesto_id;
    public $observacion;

    public function resetFilters()
    {
        $this->reset(['observacion']);
    }

    public function mount()
    {
        $this->resetFilters();

        $this->rechazarRepues = false;
    }

    public function confirmRepuestoRechazo(int $id)
    {
        $repues = Repuesto::where('id', $id)->first();

        $this->repuesto_id = $id;

        $this->resetFilters();

        $this->rechazarRepues=true;
    }

    public function rechazarRepuesto($id)
    {
        $this->validate([
            'observacion' => ['required', 'not_in:0', 'regex:/[a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/'],
        ],
        [
            'observacion.required' => 'El campo Descripción es obligatorio',
            'observacion.regex' => 'La Descripción solo debe ser Texto, números y guiones medios',
        ]);

        $repues = Repuesto::where('id', $id)->first();

        DB::transaction(function () {
            return tap(Observarepuesto::create([
                'repuesto_id' => $this->repuesto_id,
                'observacion' => $this->observacion,
            ]));
        });

        $repues->forceFill([
            'status' => 'Repuesto Rechazado',
        ])->save();

        if (Auth::user()->permiso_id == 2) {
            Notification::send($repues->estacion->user, new NotifiAcepRechaRepuesto($repues));
        } elseif (Auth::user()->permiso_id != 2 && Auth::user()->permiso_id != 3) {
            Notification::send($repues->estacion->supervisor, new NotifiAcepRechaRepuesto($repues));
        }

        $this->resetFilters();

        Alert::warning('Solicitud de Repuesto Rechazada', "Se ha rechazado la solicitud de repuestos y se ha enviado la observación");

        return redirect()->route('repuestos');
    }
    public function render()
    {
        return view('livewire.repuestos.observacion-rechazo-rpuesto');
    }
}
