<?php

namespace App\Http\Livewire\Usuarios;

use App\Models\User;
use App\Models\Zona;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserTable extends Component
{
    public function render(Request $request)
    {
        $this->valid = Auth::user()->permiso->panels->where('id', 4)->first();

        $zon=DB::table('user_zona')->where('user_id',Auth::user()->id)/* ->first()->zona_id */;
        $IDzonas=$zon->pluck('zona_id');
        $isSupervi=User::join('user_zona as uz','users.id','uz.user_id')->whereIn('uz.zona_id',$IDzonas)
        ->where('users.permiso_id',3)->select('users.*')->paginate(5);

        $zonas = Zona::where('status', 'Activo')->get();

        $users = User::where([
            ['name', '!=', Null],
            [function ($query) use ($request) {
                if (($s = $request->s)) {
                    $query->orWhere('name', 'LIKE', '%' . $s . '%')
                        ->orWhere('email', 'LIKE', '%' . $s . '%')
                        ->get();
                }
            }]
        ])->where('id','!=',1)->paginate(5); //ocultamos el usuario desarrollo para tener acceso seguro al sistema
                                                            //->with(['zonas']) eliminado por duplicacion de archivos y no permitia el search

        $trashed = User::onlyTrashed()->count();

        return view('livewire.usuarios.user-table', compact('zonas','users','trashed','isSupervi'));
    }
}
