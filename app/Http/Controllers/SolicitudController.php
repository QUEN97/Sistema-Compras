<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SolicitudController extends Controller
{
    public function index()
    {
        $this->valid = Auth::user()->permiso->panels->where('id', 1)->first();
            return view('modules.solicitudes.index', ['val' => $this->valid]);
    }
    // public function destroy(Solicitud $solicitud)
    // {
    //     $solicitud->delete();
    //     return back()->with('eliminar', 'ok');
    // }

    public function trashed_solicitudes()
    {
        $valid = Auth::user()->permiso->panels->where('id', 1)->first();

        $trashed = Solicitud::onlyTrashed()->orderBy("id", "desc")->paginate();

        return view("modules.solicitudes.solicitudestrashed", [
            "trashed" => $trashed,
            "valid" => $valid,
        ]);
    }

    public function do_restore()
    {
        $solicitud = Solicitud::withTrashed()->find(request()->id);
        if ($solicitud == null) {
            abort(404);
        }

        $solicitud->restore();
        return redirect()->back();
    }

    public function delete_permanently()
    {
        $solicitud = Solicitud::withTrashed()->find(request()->id);
        if ($solicitud == null) {
            abort(404);
        }

        $solicitud->forceDelete();
        return redirect()->back();
    }
}
