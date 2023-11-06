<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlmacenController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $this->valid = Auth::user()->permiso->panels->where('id', 2)->first();

        if (Auth::user()->permiso->id == 1) {
        return view('modules.almacenes.index', ['val' => $this->valid, 'user' => $user]);
    } elseif ($this->valid->pivot->re == 1) {
        return view('modules.almacenes.index', ['val' => $this->valid, 'user' => $user]);
    }else {
        return redirect()->route('dashboard');
    }
}
}
