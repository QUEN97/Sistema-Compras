<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $valid = Auth::user()->permiso->panels->where('id', 8)->first();

        $productos = Producto::where([
            ['name', '!=', Null],
            [function ($query) use ($request) {
                if (($s = $request->s)) {
                    $query->orWhere('name', 'LIKE', '%' . $s . '%')
                        ->get();
                }
            }]
        ])->paginate(5);
        $trashed = Producto::onlyTrashed()->count();
        return view('modules.productos.existencias.productos',compact('productos','trashed','valid'));
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();
        return back()->with('eliminar', 'ok');
    }

    public function trashed_productos()
    {
        $valid = Auth::user()->permiso->panels->where('id', 8)->first();

        $trashed = Producto::onlyTrashed()->orderBy("id", "desc")->paginate();

        return view("modules.productos.existencias.productotrashed", [
            "trashed" => $trashed,
            "valid" => $valid,
        ]);
    }

    public function do_restore()
{
    $producto = Producto::withTrashed()->find(request()->id);
    if ($producto == null)
    {
        abort(404);
    }
 
    $producto->restore();
    return redirect()->back();
}

public function delete_permanently()
{
    $producto = Producto::withTrashed()->find(request()->id);
    if ($producto == null)
    {
        abort(404);
    }
 
    $producto->forceDelete();
    return redirect()->back();
}
}
