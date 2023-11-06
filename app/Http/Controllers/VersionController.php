<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VersionController extends Controller
{
    public function show()
    {$this->valid = Auth::user()->permiso->panels->where('id', 10)->first();
        
        if (Auth::user()->permiso->id == 1) {
            return view('modules.sistema.versiones.index', ['val' => $this->valid]);
        } elseif ($this->valid->pivot->re == 1) {
            return view('modules.sistema.versiones.index', ['val' => $this->valid]);
        } else {
            return redirect()->route('dashboard');
        }
    }
}
