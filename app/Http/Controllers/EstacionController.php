<?php

namespace App\Http\Controllers;

use App\Models\Estacion;
use App\Models\Zona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EstacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $zonas = Zona::all();
        $estaciones;
        $user=Auth::user();
        if($user->permiso_id==1 || $user->permiso_id==4){
            $estaciones = Estacion::where([
                ['name', '!=', Null],
                [function ($query) use ($request) {
                    if (($s = $request->s)) {
                        $query->orWhere('name', 'LIKE', '%' . $s . '%')
                            ->get();
                    }
                }]
            ])->paginate(5);
        }
        if($user->permiso_id==2){
            $estaciones = Estacion::where([
                ['name', '!=', Null],
                [function ($query) use ($request) {
                    if (($s = $request->s)) {
                        $query->orWhere('name', 'LIKE', '%' . $s . '%')->select('estacions.*')
                            ->get();
                    }
                }]
            ])->where('supervisor_id',$user->id)->paginate(5);
        }
        if($user->permiso_id==3){
            $estaciones = Estacion::where([
                ['name', '!=', Null],
                [function ($query) use ($request) {
                    if (($s = $request->s)) {
                        $query->orWhere('name', 'LIKE', '%' . $s . '%')
                            ->get();
                    }
                }]
            ])->where('user_id',$user->id)->paginate(5);
        }
        $trashed = Estacion::onlyTrashed()->count();
        $valid = Auth::user()->permiso->panels->where('id', 7)->first();
        return view ('modules.estaciones.estaciones', compact('estaciones','trashed','zonas','valid'));
    }

    public function destroy(Estacion $estacion)
    {
        $estacion->delete();
        return back()->with('eliminar', 'ok');
    }

    public function trashed_estaciones()
    {
        $valid = Auth::user()->permiso->panels->where('id', 7)->first();

        $trashed = Estacion::onlyTrashed()->orderBy("id", "desc")->paginate();

        return view("modules.estaciones.estaciontrashed", [
            "trashed" => $trashed,
            'valid' => $valid,
        ]);
    }

    public function do_restore()
{
    $estacion = Estacion::withTrashed()->find(request()->id);
    if ($estacion == null)
    {
        abort(404);
    }
 
    $estacion->restore();
    return redirect()->back();
}

public function delete_permanently()
{
    $estacion = Estacion::withTrashed()->find(request()->id);
    if ($estacion == null)
    {
        abort(404);
    }
 
    $estacion->forceDelete();
    return redirect()->back();
}
}
