<?php

namespace App\Http\Livewire\Solicitudes;

use App\Exports\ProductoExtport;
use App\Models\Estacion;
use App\Models\ProductoExtraordinario;
use App\Models\Proveedor;
use App\Models\Solicitud;
use App\Models\User;
use App\Notifications\NotifiEditAdminSoli;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NotifiEditSolicitud;
use App\Notifications\NotifiEditSolicitudGerente;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class SolicitudExtraEdit extends Component
{
    public $EditSolicitud;
    public $solicitud_id;
    public $estacion, $producto, $cantidad, $produs,$sugerencias, $solicitudEs,$listEX=[], 
    $productsext, $tipo, $producto_extraordinario;
    public $inputs = [];
    public $i = 1;
    public $subtotal=0,$iva=0,$isr=0;

    public function resetFilters()
    {
        $this->reset(['producto', 'estacion', 'cantidad']);
    }

    public function mount()
    {
        $this->resetFilters();

        $this->EditSolicitud = false;
    }
    public function buscarProductos(){
        
    }

    public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs, $i);
    }
    public function Eliminar($id,$key){
        $registro=ProductoExtraordinario::find($id);
        $registro->flag_trash=1;
        $registro->save();
        unset($this->listEX[$key]);
    }

    public function confirmSolicitudEdit(int $id)
    {
        $solici = Solicitud::where('id', $id)->first();

        $this->produs = ProductoExtraordinario::where('flag_trash', 0)
            ->where('solicitud_id', $solici->id)->get();
        foreach($this->produs as $px => $k){
            $this->listEX[$px]['id']=$k->id;
            $this->listEX[$px]['nombre']=$k->producto_extraordinario ;
            $this->listEX[$px]['proveedor']=$k->proveedor_id;
            $this->listEX[$px]['cantidad']=$k->cantidad;
            $this->listEX[$px]['total']=$k->total;
            $this->listEX[$px]['tipo']=$k->tipo;
        }
            //dd($this->listEX);
        $this->solicitud_id = $id;
        $this->estacion = $solici->estacion_id;

        $this->EditSolicitud = true;
        
    }

    public function EditarSolicitud($id)
    {
        //dd($this->listEX);
        $solici = solicitud::where('id', $id)->first();

        $usersAdmins = User::where('permiso_id', 1)->where('id','!=',2)->get();
        $usersCompras = User::where('permiso_id', 4)->get();

        $solicitud=Solicitud::find($id)->estacion_id;
        //$zonaGerente = DB::table('user_zona')->where('user_id', Estacion::find($solicitud)->user->id)->first()->zona_id;
        //$usersSupers = User::where('permiso_id', 2)->join('user_zona as uz', 'uz.user_id', 'users.id')->where('uz.zona_id', $zonaGerente)->select('users.*')->get();
		$estacionGerente = Solicitud::find($id)->estacion;
        $usersSupers = User::find($estacionGerente->supervisor_id); // se envia solo al supervisor de la estacion que realiza la solicitud
        //dd($usersSupers);


        $estacionId = $solici->estacion_id;
        $usersGerentes = Estacion::find($estacionId)->user;
        $usersSuper = Estacion::find($estacionId)->supervisor;

        $this->validate(
            [
                'listEX.*.cantidad' => ['required', 'integer', 'numeric', 'min:1'],
                'listEX.*.nombre' => ['required', 'not_in:0'],
                'listEX.*.proveedor' => ['required', 'not_in:0'],
                'listEX.*.tipo' => ['required', 'not_in:0'],
                //'listEX.*.total' => ['required', 'not_in:0'],
            ],
            [
                'listEX.*.cantidad.required' => 'El campo Cantidad es obligatorio',
                'listEX.*.cantidad.min' => 'La cantidad solicitada debe ser mayor o igual a 1',
                'listEX.*.cantidad.integer' => 'El campo Cantidad debe ser un número',
                'listEX.*.cantidad.numeric' => 'El campo Cantidad debe ser un número',
                'listEX.*.nombre.required' => 'El Nombre del producto o servicio es obligatorio',
                'listEX.*.proveedor.required' => 'El Proveedor del producto o servicio es obligatorio',
                'listEX.*.tipo' => 'Seleccione un tipo',
                //'listEX.*.total'=>'El precio es requerido'
            ]
        );

        $solici->total=$this->subtotal;//el total es el Subtotal(se hizo esto por cambios requeridos por Lupita)
        $solici->iva=$this->subtotal*($this->iva/100);
        $solici->isr=$this->subtotal*($this->isr/100);
        $solici->save();
        //dd($this->listEX);
        foreach($this->listEX as $ex){
            $registo=ProductoExtraordinario::find($ex["id"]);
            $registo->producto_extraordinario=$ex["nombre"];
            $registo->proveedor_id=$ex["proveedor"];
            $registo->cantidad=$ex["cantidad"];
            $registo->total=$ex["total"];
            $registo->tipo=$ex["tipo"];
            $registo->save();
        }

        if (Auth::user()->permiso_id == 2 && $solici->status == 'Solicitud Rechazada') {
            $solici->forceFill([
                'status' => 'Solicitado a Compras',
            ])->save();
        } elseif (Auth::user()->permiso_id == 3 && $solici->status == 'Solicitud Rechazada') {
            $solici->forceFill([
                'status' => 'Solicitado al Supervisor',
            ])->save();
        }
        $this->GenerateExtPDF($solici);

        if (Auth::user()->permiso_id == 2) {
            Notification::send($usersAdmins, new NotifiEditSolicitud($solici));
            Notification::send($usersCompras, new NotifiEditSolicitud($solici));
            Notification::send($usersGerentes, new NotifiEditSolicitud($solici));
        } elseif (Auth::user()->permiso_id == 3) {
            Notification::send($usersAdmins, new NotifiEditSolicitudGerente($solici));
            Notification::send($usersCompras, new NotifiEditSolicitudGerente($solici));
            Notification::send($usersSupers, new NotifiEditSolicitudGerente($solici));
        } elseif(Auth::user()->permiso_id == 1){
            Notification::send($usersGerentes, new NotifiEditAdminSoli($solici));
            Notification::send($usersCompras, new NotifiEditAdminSoli($solici));
            Notification::send($usersSuper, new NotifiEditAdminSoli($solici));
        }

        $this->resetFilters();

        Alert::success('Solicitud Actualizada', "La Solicitud de la estación" . ' ' . $this->est->name . ' ' . "ha sido actualiada en el sistema");

        //return redirect()->route('solicitudes');
		return redirect(request()->header('Referer'));
    }

    
    public function GenerateExtPDF($solicitud)
    {
        $fecha = now()->format('d-m-Y');
        $supervisor = Auth::user()->name;
        $gerente = Auth::user()->name;

        $this->est = Estacion::where('id', $solicitud->estacion_id)->first();

        if (Auth::user()->permiso_id == 2) {
            $this->nombrePDF = $fecha . '_' . $this->est->name . '_' . $supervisor . '_' . rand(10, 100000) . '.pdf';
        } elseif (Auth::user()->permiso_id == 3) {
            $this->nombrePDF = $fecha . '_' . $this->est->name . '_' . $gerente . '_' . rand(10, 100000) . '.pdf';
        } elseif (Auth::user()->permiso_id != 2 && Auth::user()->permiso_id != 3) {
            $this->nombrePDF = $fecha . '_' . $this->est->name . '_' . $this->est->supervisor->name . '_' . rand(10, 100000) . '.pdf';
        }

        $this->itsTot = ProductoExtraordinario::where('solicitud_id', $solicitud->id)->where('flag_trash', 0)->sum('total');

        $data = [
            'fechaSolicitud' => $solicitud->created_format,
            'estacio' => $this->est->name,
            'zonaEsta' => $this->est->zona->name,
            'catego' => $solicitud->categoria->name,
            'solicitudproducto' => $solicitud,
            'numSolicitud' => $solicitud->id,
            'motivo' => $solicitud->motivo,
            'totalSoli' => number_format($solicitud->total,2) ,
            'iva'=> number_format($solicitud->iva,2),
            'isr'=> number_format($solicitud->isr,2), 
            'total'=>($solicitud->total+$solicitud->iva)-$solicitud->isr
        ];

        $cont = Pdf::loadView('livewire.solicitudes.solicitud-ext-pdf', $data)->output();

        Storage::disk('public')->put('solicitudes-pdfs/' . $this->nombrePDF, $cont);
        Storage::disk('public')->delete('solicitudes-pdfs/' . $solicitud->pdf);

        $solicitud->forceFill([
            'pdf' => $this->nombrePDF,
        ])->save();
    }

    public function render()
    {
        $proveedores = Proveedor::all()->where('flag_trash', 0);
        return view('livewire.solicitudes.solicitud-extra-edit', compact('proveedores'));
    }
    
}
