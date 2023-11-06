<?php

namespace App\Http\Livewire\Productos\Facturas;

use App\Models\ArchivosFactura;
use App\Models\Estacion;
use App\Models\Factura;
use App\Models\ProductosFactura;
use App\Models\Proveedor;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use RealRashid\SweetAlert\Facades\Alert;

class EditFactura extends Component
{
    use WithFileUploads;
    public $facturaID,$editFactura=false;
    public $estacion,$monto,$urlArchi;
    public $productos,$estaciones,$proveedor,$evidenciaArc,$folio;
    public $productosUpdate=[],$evidencias=[];
    public function confirmFacturaEdit($id){
        $factura=Factura::find($id);
        $ProductosF=ProductosFactura::where('id_factura',$id)->get();
        $this->estaciones=Estacion::where('id',$factura->estacion_id)->get();
        $this->proveedor=Proveedor::where('id',$factura->proveedor_id)->first()->titulo_proveedor;
        $this->monto=$factura->monto;
        $this->folio=$factura->folio_fiscal;
        $this->productosUpdate=$ProductosF->pluck('id_producto');
        $this->evidenciaArc=ArchivosFactura::where('id_factura',$id)->get();
        $this->editFactura=true;
    }

    public function FacturaUpdate($id){
        $this->validate([
            'monto'=> ['required','gt:0'],
            'folio'=> ['required','size:36','regex:/^[a-f\d]{8}-[a-f\d]{4}-[a-f\d]{4}-[a-f\d]{4}-[a-f\d]{12}$/i']
        ],[
            'monto.required'=>'Ingrese el monto TOTAL de la factura',
            'monto.gt'=>'La cantidad debe ser mayor a cero',
            'folio.required'=>'EL folio fiscal es requerido',
            'folio.size'=>'El folio fiscal debe contener 36 caracteres',
            'folio.regex'=>'Ingrese un folio fiscal válido'
            ]);
        $factura=Factura::find($id);
        //dd($this->productosUpdate);
        $pFacturas=ProductosFactura::where('id_factura',$id);
        if($pFacturas->count()>0){
            ProductosFactura::where('id_factura',$id)->whereIn('id_producto',$pFacturas->pluck('id_producto'))->delete();
        }
        $factura->monto=$this->monto;
        $factura->folio_fiscal=$this->folio;
        $factura->save();
        foreach ($this->productosUpdate as $pro){
            $inProducto = new ProductosFactura();
            $inProducto->id_factura = $id;
            $inProducto->id_producto = $pro;
            $inProducto->save();
        }
        //guardamos la información de los archivos en BD y en la carpeta public
        foreach ($this->evidencias as $lue) {
            $this->urlArchi = $lue->store('evidencias', 'public');
            ArchivosFactura::create([
                'id_factura' => $id,
                'nombre_archivo' => $lue->getClientOriginalName(),
                'mime_type' => $lue->getMimeType(),
                'size' => $lue->getSize(),
                'archivo_path' => $this->urlArchi,
            ]);
        }
        //Descartada la idea del Sync ya que hay conflicto
        /* if (isset($factura->productos)){
            $factura->productos()->sync($this->productosUpdate);
            }else{
                $factura->productos()->sync(array());
            } */
            Alert::success('Registro Actualizado', "El Registro ha sido actualizado en el sistema");
            return redirect()->route('facturas');
    }

    public function removeArch($id)
    {
        ArchivosFactura::where('id', $id)->delete();
    }
    //remover archivo seleccionado (no se encuentra en la BD)
    public function removeMe($index)
    {
        array_splice($this->evidencias, $index, 1);
    }

    public function render()
    {
        $this->productos=DB::table('productos as p')
        ->select('p.id as id','p.name as producto')
        ->where('p.deleted_at',null)->get();
        return view('livewire.productos.facturas.edit-factura');
    }
}
