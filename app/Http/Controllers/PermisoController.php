<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Permiso;
use App\Models\PanelPermiso;
use App\Models\Panel;
use Illuminate\Support\Facades\Auth;

class PermisoController extends Controller
{
    public function show()
    {
        $this->valid = Auth::user()->permiso->panels->where('id', 5)->first();
        
        if (Auth::user()->permiso->id == 1) {
            return view('modules.permisos.index', ['val' => $this->valid]);
        } elseif ($this->valid->pivot->re == 1) {
            return view('modules.permisos.index', ['val' => $this->valid]);
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function asignar(Request $request, $id)
    {
        $permisoEs = Permiso::where('id', $id)->first();

        $request->validate([
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

        $permisoEs->forceFill([ 
            'titulo_permiso' => Str::title($request->titulo_permiso),
            'descripcion' => Str::ucfirst($request->descripcion),
        ])->save();

        for ($i=1; $i <= 13; $i++) { 
            
            $permi = PanelPermiso::where('permiso_id', $id)->where('panel_id', $i)->first();

            if ($permi != null || !empty($permi)) {
                $puedeleer = isset($request->leer[$permi->panel_id]) ? 1 : 0;
                $puedecrear = isset($request->crear[$permi->panel_id]) ? 1 : 0;
                $puedeeditar = isset($request->editar[$permi->panel_id]) ? 1 : 0;
                $puedeeliminar = isset($request->eliminar[$permi->panel_id]) ? 1 : 0;
                $puedevermas = isset($request->vermas[$permi->panel_id]) ? 1 : 0;
                $puedeverpap = isset($request->verpap[$permi->panel_id]) ? 1 : 0;
                $puederestpap = isset($request->restpap[$permi->panel_id]) ? 1 : 0;
                $puedevermaspap = isset($request->vermaspap[$permi->panel_id]) ? 1 : 0;

                $permi->forceFill([ 
                    're' => $puedeleer,
                    'wr' => $puedecrear,
                    'ed' => $puedeeditar,
                    'de' => $puedeeliminar,
                    'vermas' => $puedevermas,
                    'verpap' => $puedeverpap,
                    'restpap' => $puederestpap, 
                    'vermaspap' => $puedevermaspap,
                ])->save();
            } else {
                $puedeleer = isset($request->leer[$i]) ? 1 : 0;
                $puedecrear = isset($request->crear[$i]) ? 1 : 0;
                $puedeeditar = isset($request->editar[$i]) ? 1 : 0;
                $puedeeliminar = isset($request->eliminar[$i]) ? 1 : 0;
                $puedevermas = isset($request->vermas[$i]) ? 1 : 0;
                $puedeverpap = isset($request->verpap[$i]) ? 1 : 0;
                $puederestpap = isset($request->restpap[$i]) ? 1 : 0;
                $puedevermaspap = isset($request->vermaspap[$i]) ? 1 : 0;

                PanelPermiso::create([
                    'permiso_id' => $id,
                    'panel_id' => $i,
                    're' => $puedeleer,
                    'wr' => $puedecrear,
                    'ed' => $puedeeditar,
                    'de' => $puedeeliminar,
                    'vermas' => $puedevermas,
                    'verpap' => $puedeverpap,
                    'restpap' => $puederestpap, 
                    'vermaspap' => $puedevermaspap,
                ]);
            }
        }

        $permiso = Permiso::where('id', $id)->first();

        Alert::success('Permisos Actualizados', "Los Permisos del Rol". ' '.$permiso->titulo_permiso. ' '. "han sido actualizados en el sistema");

        return redirect()->route('roles');
    }
}
