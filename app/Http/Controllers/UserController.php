<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Zona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // $zonas = Zona::all();
        // $users = User::where([
        //     ['name', '!=', Null],
        //     [function ($query) use ($request) {
        //         if (($s = $request->s)) {
        //             $query->orWhere('name', 'LIKE', '%' . $s . '%')
        //                 ->orWhere('email', 'LIKE', '%' . $s . '%')
        //                 ->get();
        //         }
        //     }]
        // ])->with(['zonas'])->first()->paginate(5);

        // $trashed = User::onlyTrashed()->count();
        $this->valid = Auth::user()->permiso->panels->where('id', 4)->first();

        if (Auth::user()->permiso->id == 1) {
            return view('modules.usuarios.usuarios', ['val' => $this->valid]);
        } elseif ($this->valid->pivot->re == 1) {
            return view('modules.usuarios.usuarios', ['val' => $this->valid]);
        } else {
            return redirect()->route('dashboard');
        }
    }

    // public function destroy(User $user)
    // {
    //     $user->delete();
    //     return back()->with('eliminar', 'ok');
    // }

    public function trashed_users()
    {

        $valid = Auth::user()->permiso->panels->where('id', 4 )->first();
        $trashed = User::onlyTrashed()->orderBy("id", "desc")->paginate();

        return view("modules.usuarios.usertrashed", [
            "trashed" => $trashed,
            "valid" => $valid,
        ]);
    }

    public function do_restore()
    {
        $user = User::withTrashed()->find(request()->id);
        if ($user == null) {
            abort(404);
        }

        $user->restore();
        return redirect()->back();
    }

    public function delete_permanently()
    {
        $user = User::withTrashed()->find(request()->id);
        if ($user == null) {
            abort(404);
        }

        $user->forceDelete();
        return redirect()->back();
    }
}
