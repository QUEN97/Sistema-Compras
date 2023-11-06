<?php

namespace App\Http\Livewire\Productos\Facturas;

use App\Models\ArchivosFactura;
use App\Models\Estacion;
use App\Models\Factura;
use App\Models\Producto;
use App\Models\ProductosFactura;
use App\Models\Proveedor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use RealRashid\SweetAlert\Facades\Alert;

class AddFactura extends Component
{
    use WithFileUploads;
    public $addFactura=false;
    public $proveedor,$estacion,$monto=0,$evidencias=[],$productos,$productosList,$urlArchi,$folio;

    public function addFactura(){
        //dd($this->productosList);
        $user=Auth::user();
        //si el usuario es gerente buscamos esu estación ya que el select no aparecerá
        if($user->permiso_id== 3){
            $this->estacion=Estacion::where('user_id', $user->id)->first()->id;
        }
        $this->validate([
            'estacion'=> ['required','not_in:0'],
            'proveedor'=> ['required','not_in:0'],
            'monto'=> ['required','gt:0'],
            'folio'=> ['required','size:36','regex:/^[a-f\d]{8}-[a-f\d]{4}-[a-f\d]{4}-[a-f\d]{4}-[a-f\d]{12}$/i']
        ],[
            'estacion.required'=>'Seleccione una estación',
            'proveedor.required'=>'Seleccione un proveedor',
            'monto.required'=>'Ingrese el monto TOTAL de la factura',
            'monto.gt'=>'La cantidad debe ser mayor a cero',
            'folio.required'=>'EL folio fiscal es requerido',
            'folio.size'=>'El folio fiscal debe contener 36 caracteres',
            'folio.regex'=>'Ingrese un folio fiscal válido'
            ]);
            $newFactura=new Factura();
            $newFactura->proveedor_id= $this->proveedor;
            $newFactura->estacion_id= $this->estacion;
            $newFactura->monto= $this->monto;
            $newFactura->folio_fiscal=$this->folio;
            $newFactura->save();

            //obtenemos el registro que se ingresó
            $last=Factura::latest('id')->first();

            //guardamos la información de los archivos en BD y en la carpeta public
            foreach ($this->evidencias as $lue) {
                $this->urlArchi = $lue->store('evidencias', 'public');
                ArchivosFactura::create([
                    'id_factura' => $last->id,
                    'nombre_archivo' => $lue->getClientOriginalName(),
                    'mime_type' => $lue->getMimeType(),
                    'size' => $lue->getSize(),
                    'archivo_path' => $this->urlArchi,
                ]);
            }
            //guardamos la lista de productos en BD
            foreach($this->productosList as $pr){
                ProductosFactura::create([
                    'id_factura' => $last->id,
                    'id_producto' => $pr,
                ]);
            }
            Alert::success('Nuevo Registro', "El Registro ha sido agregado al sistema");
            return redirect()->route('facturas');
    }

    public function render()
    {
        $user=Auth::user();
        $proveedores=Proveedor::all()->where('flag_trash',0);
        if($user->permiso_id == 1 || $user->permiso_id == 4){
            $estaciones=Estacion::all()->where('deleted_at',null);
        }
        else{
            $estaciones=Estacion::all()->where('deleted_at',null)->where('supervisor_id',$user->id);
        }
        $this->productos=DB::table('productos as p')
        ->select('p.id as id','p.name as producto')
        ->where('p.deleted_at',null)->get();
        //$productos=Producto::all();
        return view('livewire.productos.facturas.add-factura',compact('proveedores','estaciones','user'));
    }
}
