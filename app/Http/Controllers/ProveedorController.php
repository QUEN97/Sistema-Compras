<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProveedorController extends Controller
{
    public function trashList(){
        $list=Proveedor::select('*')->where('flag_trash',1)->paginate(5);
        return view('modules.productos.proveedores.trashed',compact('list'));
    }
    public function search(Request $request){
        $valid = Auth::user()->permiso->panels->where('id', 11)->first();
        $dat;
        $trash=Proveedor::all()->where('flag_trash',1)->count(); 
        if($request->q ==""){
            $dat=Proveedor::/*join('categorias as ca','proveedors.categoria_id','ca.id')
            ->select('proveedors.*', 'ca.name as categoria')->*/where('proveedors.flag_trash',0)->paginate(5);
        }
        else{
             $dat=Proveedor::/*join('categorias as ca','proveedors.categoria_id','ca.id')
            ->select('proveedors.*', 'ca.name as categoria')*/
            where('proveedors.flag_trash',0)
            ->where('proveedors.titulo_proveedor','LIKE','%'.$request->q.'%')
            ->paginate(5);
        }
        return view('modules.productos.proveedores.proveedores',compact('dat','trash','valid'));
    }
    public function all(){
        $valid = Auth::user()->permiso->panels->where('id', 11)->first();
        $dat=Proveedor::/* join('categorias as ca','proveedors.categoria_id','ca.id')
        ->select('proveedors.*', 'ca.name as categoria')-> */where('proveedors.flag_trash',0)->paginate(5);
        $trash=Proveedor::all()->where('flag_trash',1)->count();
        return view('modules.productos.proveedores.proveedores',compact('dat','trash','valid'));
    }
}