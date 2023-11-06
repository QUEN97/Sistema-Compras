<?php

namespace App\Http\Controllers;

use App\Models\Zona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ZonaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->valid = Auth::user()->permiso->panels->where('id', 6)->first();

        if (Auth::user()->permiso->id == 1) {
            return view('modules.zonas.zonas', ['val' => $this->valid]);
        } elseif ($this->valid->pivot->re == 1) {
            return view('modules.zonas.zonas', ['val' => $this->valid]);
        } else {
            return redirect()->route('dashboard');
        }
    }

  
    public function trashed_zonas()
    {
        $valid = Auth::user()->permiso->panels->where('id', 6)->first();

        $trashed = Zona::onlyTrashed()->orderBy("id", "desc")->paginate();

        return view("modules.zonas.zonatrashed", [
            "trashed" => $trashed,
            "valid" => $valid,
        ]);
    }

    public function do_restore()
    {
        $zona = Zona::withTrashed()->find(request()->id);
        if ($zona == null) {
            abort(404);
        }

        $zona->restore();
        return redirect()->back();
    }

    public function delete_permanently()
    {
        $zona = Zona::withTrashed()->find(request()->id);
        if ($zona == null) {
            abort(404);
        }

        $zona->forceDelete();
        return redirect()->back();
    }
}
