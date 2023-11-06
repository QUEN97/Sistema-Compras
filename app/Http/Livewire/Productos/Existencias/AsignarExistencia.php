<?php

namespace App\Http\Livewire\Productos\Existencias;

use App\Models\Estacion;
use App\Models\EstacionProducto;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;
class AsignarExistencia extends Component
{
   
    public $showModal=false;
    public $estaciones,$estacionID,$productos,$producto,$cantidad;
    public $i=1;
    public $inputs=[];

    public function updatedEstacionID($id){
        $zona=Estacion::find($id)->zona_id;
        $this->productos=Producto::join('producto_zona as pz','pz.producto_id','productos.id')
        ->where('pz.zona_id',$zona)->select('productos.id','productos.name')
        ->get();
        //dd($this->productos);
    }

    //la variable i que se para es la que definimos al inicio, por lo que al hacer This se va incrementando
    public function add($i)
    {
        $this->i++;
        array_push($this->inputs, $i);
    }
    public function remove($i, $it)
    {
        unset($this->inputs[$i]);
        unset($this->producto[$it]);
    }
    public function insertarStock(){
        $this->validate([
            'producto.0.id' => ['required', 'not_in:0'],
            'producto.0.stock' => ['required', 'integer', 'numeric', 'min:1'],
            'producto.*.id' => ['required', 'not_in:0'],
            'producto.*.stock' => ['required', 'integer', 'numeric', 'min:1'],
        ],
        [
            'producto.0.id.required' => 'Seleccione un producto',
            'producto.0.stock.required' => 'Ingrese el stock que debe contener el almacén de la estación',
            'producto.0.stock.min' => 'El stock esperado debe ser MAYOR a 1',
            'producto.*.id.required' => 'Seleccione un producto',
            'producto.*.stock.required' => 'Ingrese el stock que debe contener el almacén de la estación',
            'producto.*.stock.min' => 'El stock esperado debe ser MAYOR a 1',
        ]);
        $existentes=[];

        foreach ($this->producto as $pr){          
            //buscamos en la tabla si el producto existe, en cado de existir actualizaremos el stock fijo del registro 
            if(EstacionProducto::where('estacion_id',$this->estacionID)->where('producto_id',$pr['id'])->count() > 0){
                array_push($existentes,'existe: '.$pr['id']);
                $regExiste=EstacionProducto::where('estacion_id',$this->estacionID)->where('producto_id',$pr['id'])->first();
                $regExiste->stock_fijo=$pr['stock'];
                $regExiste->save();
            }
            else{
                $registro= new EstacionProducto();
                $registro->estacion_id=$this->estacionID;
                $registro->producto_id=$pr['id'];
                $registro->stock=0;
                $registro->stock_fijo=$pr['stock'];
                $registro->status="Solicitado";
                $registro->save();
            }
            //dd(count($existentes)==count($this->producto));
        }
        if(count($existentes)>0 && (count($existentes)==count($this->producto))){
            Alert::warning('Stock Actualizado','El stock esperado de los prodcutos han sido actualizados');
        }
        elseif (count($existentes)>0 && (count($existentes)<count($this->producto))){
            Alert::warning('Productos Asignados','El stock esperado de algunos productos han sido actualizados');
        }
        else{
            Alert::success('Registro Exitoso','Los productos han sido asignados al almacén de la estación');
        }
        return redirect()->route('almacenes');
        //dd($existentes);
    }
    public function render()
    {
        if(Auth::user()->permiso_id !=3 && Auth::user()->permiso_id !=2){
            $this->estaciones= Estacion::where('status','Activo')->orderBy('name','asc')->get();
        }
        elseif (Auth::user()->permiso_id ==2){
            $this->estaciones= Estacion::where('status','Activo')->where('supervisor_id',Auth::user()->id)
            ->orderBy('name','asc')->get();
        }
        return view('livewire.productos.existencias.asignar-existencia');
    }
}