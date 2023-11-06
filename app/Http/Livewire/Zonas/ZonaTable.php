<?php

namespace App\Http\Livewire\Zonas;

use App\Models\Zona;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ZonaTable extends Component
{
    public function render(Request $request)
    {
        $this->valid = Auth::user()->permiso->panels->where('id', 6)->first();

        $user = Auth::user();
        
        $zonasSups = $user->zonas;

         $zonas = Zona::where([
             ['name', '!=', Null],
             [function ($query) use ($request) {
                 if (($s = $request->s)) {
                     $query->orWhere('name', 'LIKE', '%' . $s . '%')
                         ->get();
                 }
             }]
         ])->paginate(5);
      
        $trashed = Zona::onlyTrashed()->count();
        return view('livewire.zonas.zona-table',[
            'zonasSups' => $zonasSups,
            'trashed' => $trashed,
             'zonas' => $zonas,
        ]);
    }
}
