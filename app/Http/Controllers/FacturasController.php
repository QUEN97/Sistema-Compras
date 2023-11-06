<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FacturasController extends Controller
{
    public function home(){
        $valid = Auth::user()->permiso->panels->where('id', 12)->first();
        $user=Auth::user();
        $facturas;
        if($user->permiso_id=="1" || $user->permiso_id=="4"){
            $facturas=Factura::join('proveedors as pr','pr.id','facturas.proveedor_id')
                ->where('deleted_at',null)->orderBy('facturas.id','desc')
                ->select('facturas.*','pr.titulo_proveedor')->paginate(5);
        }
        if($user->permiso_id=="2"){
            $facturas=Factura::join('proveedors as pr','pr.id','facturas.proveedor_id')
                ->join('estacions as es','es.id','facturas.estacion_id')
                ->where('es.supervisor_id',$user->id)
                ->orderBy('facturas.id','desc')
                ->select('facturas.*','pr.titulo_proveedor')->paginate(5);
                //dd($facturas);
        }
        if($user->permiso_id=="3"){
            $facturas=Factura::join('proveedors as pr','pr.id','facturas.proveedor_id')
                ->join('estacions as es','es.id','facturas.estacion_id')
                ->where('es.user_id',$user->id)
                ->orderBy('facturas.id','desc')
                ->select('facturas.*','pr.titulo_proveedor')->paginate(5);
                //dd($facturas);
        }
        return view('modules.productos.facturas.facturas',compact('facturas','user','valid'));
    }
}
