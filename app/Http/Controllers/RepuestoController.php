<?php

namespace App\Http\Controllers;

use App\Models\Estacion;
use App\Models\Repuesto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RepuestoController extends Controller
{
    function Index()
    {
        $this->valid = Auth::user()->permiso->panels->where('id', 3)->first();

        $trash=Repuesto::all()->where('flag_trash',1)->count(); 

        if (Auth::user()->permiso->id == 1) {
        return view('modules.repuestos.repuestos', ['val' => $this->valid, 'trash'=>$trash]);
    } elseif ($this->valid->pivot->re == 1) {
        return view('modules.repuestos.repuestos', ['val' => $this->valid, 'trash'=>$trash]);
    } else {
        return redirect()->route('dashboard');
    }
    }
    public function trashList(){
        $isGeren = Estacion::where('status', 'Inactivo')->where('user_id', Auth::user()->id)->get();

        $isSuper = Estacion::where('status', 'Inactivo')->where('supervisor_id', Auth::user()->id)->get();

        $allRepuesto = Estacion::where('status', 'Inactivo')->get();
        return view('modules.repuestos.trashed', compact('allRepuesto','isGeren','isSuper'));
    }
   
}
