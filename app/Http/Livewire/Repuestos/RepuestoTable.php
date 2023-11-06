<?php

namespace App\Http\Livewire\Repuestos;

use Livewire\Component;
use App\Models\Estacion;
use App\Models\Repuesto;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NotifiAcepRechaRepuesto;

class RepuestoTable extends Component
{
    public function aceptarAdmin($numId) //compras
    {
         DB::table('repuestos')->where('id', $numId)->update(['status' => 'Repuesto Aprobado']);

        $this->folIs = Repuesto::where('id', $numId)->first();

        $userCom=User::where('permiso_id', 4)->get();
        Notification::send($userCom, new NotifiAcepRechaRepuesto($this->folIs));

        Notification::send($this->folIs->estacion->user, new NotifiAcepRechaRepuesto($this->folIs));

        Notification::send($this->folIs->estacion->supervisor, new NotifiAcepRechaRepuesto($this->folIs));

        Alert::success('Repuesto Aprobado', "Se ha Aprobado el Repuesto");

        return redirect()->route('repuestos');
    } 

    public function aceptarRepuesCompr($numId)
    {
        DB::table('repuestos')->where('id', $numId)->update(['status' => 'Enviado a Administración']);

        $this->folIs = Repuesto::where('id', $numId)->first();

        $userAdmin=User::where('permiso_id', 1)->get();
        Notification::send($userAdmin, new NotifiAcepRechaRepuesto($this->folIs));

        Notification::send($this->folIs->estacion->user, new NotifiAcepRechaRepuesto($this->folIs));

        Notification::send($this->folIs->estacion->supervisor, new NotifiAcepRechaRepuesto($this->folIs));

        Alert::success('Repuesto Aprobado', "Se ha enviado la solicitud a administración");

        return redirect()->route('repuestos');
    }

    public function aceptarRepues($numId)
    {
        DB::table('repuestos')->where('id', $numId)->update(['status' => 'Solicitado a Compras']);

        $this->folIs = Repuesto::where('id', $numId)->first();

        $userAdmin=User::where('permiso_id', 1)->get();
        Notification::send($userAdmin, new NotifiAcepRechaRepuesto($this->folIs));

        $userCom=User::where('permiso_id', 4)->get();
        Notification::send($userCom, new NotifiAcepRechaRepuesto($this->folIs));

        Notification::send($this->folIs->estacion->user, new NotifiAcepRechaRepuesto($this->folIs));

        Alert::success('Repuesto Aprobado', "Se ha enviado la solicitud de repuesto a Compras");

        return redirect()->route('repuestos');
    }

    public function render()
    {
        $this->isGeren = Estacion::where('status', 'Activo')->where('user_id', Auth::user()->id)->get();

        $this->isSuper = Estacion::where('status', 'Activo')->where('supervisor_id', Auth::user()->id)->get();
        
        $this->allRepuesto = Estacion::where('status', 'Activo')->get();

        $this->isCompras = Estacion::where('status', 'Activo')->get();

        $trash=Repuesto::all()->where('flag_trash',1)->count(); 


        $this->valid = Auth::user()->permiso->panels->where('id', 3)->first();

        return view('livewire.repuestos.repuesto-table', compact('trash'));
    }
}
