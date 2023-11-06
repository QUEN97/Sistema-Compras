<?php

namespace App\Http\Livewire\Almacenes;

use App\Models\EstacionProducto;
use Livewire\Component;
use App\Models\Estacion;
use App\Models\User;
use App\Models\Traspaso;
use Illuminate\Support\Facades\DB;
use App\Models\FoliosHistorial;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NotifiAcepRechaAlmacen;


class VerMasAlmacen extends Component
{
    public $ShowgAlmacen, $foliosHisto, $stat, $traspa;
    public $almacen_show_id, $producto, $name, $stock, $created_at;


    public function mount()
    {
        $this->ShowgAlmacen = false;
    }

    public function confirmShowAlmacen(int $id)
    {
        $estacion = EstacionProducto::where('id', $id)->first();

        $nombre = EstacionProducto::join('productos as p', 'p.id', '=', 'estacion_producto.producto_id')
        ->where('estacion_producto.id', $id)
        ->select('p.*')
        ->pluck('p.name')
        ->first();

        $nombreEs = EstacionProducto::join('estacions as e', 'e.id', '=', 'estacion_producto.estacion_id')
        ->where('estacion_producto.id', $id)
        ->select('e.*')
        ->pluck('e.name')
        ->first();

        $this->foliosHisto = FoliosHistorial::where('estacion_producto_id', $id)->get();

        foreach ($this->foliosHisto as $key => $value) {
            $this->stat = $value->status;

            $this->traspa = $value->folio->isentrada_issalida;
        }

        $this->producto = $nombre;

        
        if ($estacion->estacion_id != null) {
             $this->name = $nombreEs;
         } else {
             $this->name = 'En Almacen Del Supervisor';
         }
        
        $this->stock = $estacion->stock;
        $this->created_at = $estacion->created_format;

        $this->ShowgAlmacen = true;
    }

    //FUNCIÓN PARA ACEPTAR LAS ENTRADAS O SALIDAS A ALMACEN QUE RECIBE LOS CAMPOS("id del folio_historials", "la cantidad ingresada", "la esatcion", "el folio")
    public function acepEntradaSali($id, $cant, $esEnSa, $esta, $foli)
    {
        $sto = EstacionProducto::where('id', $esta)->pluck('stock')->first();

        $this->ultFoId = EstacionProducto::where('id', $esta)->first();

        DB::table('folios_historials')->where('id', $id)->update(['status' => 'Aprobado']);

        $this->folIs = FoliosHistorial::where('id', $id)->first();

        $userAd = User::where('permiso_id', 1)->get();
        $userCom = User::where('permiso_id', 4)->get();

        if (Auth::user()->permiso_id != 3) {

            if ($esEnSa == 'Entrada') {

                DB::table('estacion_producto')->where('id', $esta)->increment('stock', $cant);

                Alert::success('Entrada Aprobada', "Se ha agregado un producto al almacen con folio '".$foli."'");

            } elseif ($esEnSa == 'Salida') {
                if ($cant > $sto) {

                    DB::table('estacion_producto')->where('id', $esta)->update(['stock' => 0]);

                    Alert::success('Salida Aprobada', "Se ha descontado un producto del almacen a 0 con folio '".$foli."'");

                } else {

                    DB::table('estacion_producto')->where('id', $esta)->decrement('stock', $cant);

                    Alert::success('Salida Aprobada', "Se ha descontado un producto del almacen con folio '".$foli."'");
                }
            }
        }

        if ($this->ultFoId->estacion != null) {
            Notification::send($this->ultFoId->estacion->user, new NotifiAcepRechaAlmacen($this->folIs));
        } else {
            Notification::send($userAd, new NotifiAcepRechaAlmacen($this->folIs));
            Notification::send($userCom, new NotifiAcepRechaAlmacen($this->folIs));
            
        }
        
        $this->mount();
            
        //return redirect()->route('almacenes');
		return redirect(request()->header('Referer'));
    }

    //FUNCIÓN PARA ACEPTAR LOS TRASPASOS DE ALMACEN ENTRE ESTACIONES QUE RECIBE LOS CAMPOS("id del folio_historials", "la cantidad ingresada", "la esatcion", "el folio")
    public function acepTraspaso($id, $cant, $esEnSa, $esta, $foli)
    {
        $sto = EstacionProducto::where('id', $esta)->pluck('stock')->first();

        $this->ultFoId = EstacionProducto::where('id', $esta)->first();

        DB::table('folios_historials')->where('id', $id)->update(['status' => 'Aprobado']);

        $this->folIs = FoliosHistorial::where('id', $id)->first();

        $userSuper = User::where('id', $this->ultFoId->supervisor_id)->get();

        $this->almacen = EstacionProducto::where('flag_trash', 0)
                        ->where('estacion_id', $this->folIs->estacion_destino_id)
                        ->where('producto_id', $this->ultFoId->producto_id)->first();

        if (Auth::user()->permiso_id != 2 && Auth::user()->permiso_id != 3) {

            if ($esEnSa == 'Traspaso') {

                if (!empty($this->almacen) || $this->almacen != null) {

                    DB::table('estacion_producto')->where('estacion_id', $this->folIs->estacion_destino_id)
                    ->where('producto_id', $this->ultFoId->producto_id)->increment('stock', $cant);

                    DB::table('estacion_producto')->where('id', $esta)->decrement('stock', $cant);

                    DB::table('folios_historials')->where('id', $id)->update(['status' => 'Aprobado']);

                    $this->folIs->forceFill([
                        'estacion_producto_id' => $this->almacen->id,
                    ])->save();

                    Alert::success('Traspaso Aprobado', "Se ha agregado un producto al almacen con folio '".$foli."'");

                } else {

                    EstacionProducto::create([
                        'estacion_id' => $this->folIs->estacion_destino_id,
                        'producto_id' => $this->ultFoId->producto_id,
                        'stock' => $cant,
                        'status' => 'Solicitado',
                        'flag_trash' => 0,
                    ]);

                    $this->estaUlt = EstacionProducto::latest('id')->first();
                    
                    DB::table('estacion_producto')->where('id', $esta)->decrement('stock', $cant);

                    $this->folIs->forceFill([
                        'estacion_producto_id' => $this->estaUlt->id,
                    ])->save();
                    
                    Alert::success('Traspaso Aprobado', "Se ha agregado un producto al almacen con folio '".$foli."'");
                }

                Notification::send($userSuper, new NotifiAcepRechaAlmacen($this->folIs));
            }
        }

        $this->mount();
            
        //return redirect()->route('almacenes');
		return redirect(request()->header('Referer'));
    }

    public function rechaEntradaSali($id, $folioEs, $esta, $entraSal)
    {
        $this->ultFoId = EstacionProducto::where('id', $esta)->first();

        DB::table('folios_historials')->where('id', $id)->update(['status' => 'Rechazado']);

        $this->folIs = FoliosHistorial::where('id', $id)->first();

        $userAd = User::where('permiso_id', 1)->get();

        $userSuper = User::where('id', $this->ultFoId->supervisor_id)->get();

        if ($entraSal == 'Entrada') {

            Alert::success('Entrada Rechazada', "Se rechazado la solicitud de entrada al almacen con folio '".$folioEs."'");

            if ($this->ultFoId->estacion != null) {
                Notification::send($this->ultFoId->estacion->user, new NotifiAcepRechaAlmacen($this->folIs));
            } else {
                Notification::send($userAd, new NotifiAcepRechaAlmacen($this->folIs));
            }

        } elseif ($entraSal == 'Salida') {

            Alert::success('Salida Rechazada', "Se rechazado la solicitud de entrada al almacen con folio '".$folioEs."'");

            if ($this->ultFoId->estacion != null) {
                Notification::send($this->ultFoId->estacion->user, new NotifiAcepRechaAlmacen($this->folIs));
            } else {
                Notification::send($userAd, new NotifiAcepRechaAlmacen($this->folIs));
            }

        } elseif ($entraSal == 'Traspaso') {

            Alert::success('Traspaso Rechazado', "Se rechazado la solicitud de traspaso de producto con folio '".$folioEs."'");

            Notification::send($userSuper, new NotifiAcepRechaAlmacen($this->folIs));
        }

        $this->mount();
            
        //return redirect()->route('almacenes');
		return redirect(request()->header('Referer'));
    }


    public function render()
    {
        $this->almaCe = EstacionProducto::where('id', $this->almacen_show_id)->first();
        return view('livewire.almacenes.ver-mas-almacen');
    }
}
