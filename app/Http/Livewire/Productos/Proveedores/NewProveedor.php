<?php

namespace App\Http\Livewire\Productos\Proveedores;

use App\Models\Categoria;
use App\Models\Proveedor;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class NewProveedor extends Component
{
    public $addProveedor=false,$showRef=false,$showBank=false;
    public $categoria,$rfc,$titulo_proveedor,$numRef,$ref,$banco,$Ncuenta,$Nclave,$Nbanco, $flag_trash;
    //cuando la variable numRef cambia se ejecuta ela funcion
    public function updatednumRef($ref){
        if($ref=="REF"){
            $this->showRef=true;
        }
        else{
            $this->ref=$ref;
            $this->showRef=false;
        }
    }
    //cuando la variable banco cambia se ejecuta ela funcion
    public function updatedbanco($bk){
        if($bk==0){
            $this->Nbanco="";
            $this->showBank=true;
        }
        else{
            $this->Nbanco=$bk;
            $this->showBank=false;
        }
    }

    //funcion para añadir el registro a la BD
    public function addProveedor(){
            $this->validate( [
                'titulo_proveedor' => ['required',  'max:250'],
                'rfc' => ['required'],
                /* 'categoria' => ['required', 'not_in:0'], */
                'numRef'=>['required'],
                'ref'=>['required'],
                'banco'=>['required'],
                'Nbanco'=>['required','string'],
                'Ncuenta'=>['required','numeric','max_digits:18'],
                'Nclave'=>['required','numeric','digits:18'],],
            [
                'titulo_proveedor.required' => 'El Nombre del Proveedor es obligatorio',
                'titulo_proveedor.max' => 'El Nombre del Proveedor no debe ser mayor a 25 caracteres',
                'rfc.required' => 'El RFC del Proveedor es obligatorio',
                /* 'categoria.required' => 'La Categoría es obligatoria', */
                'numRef.required' => 'El Método de Pago es obligatorio',
                'ref.required' => 'El Número de Referencia es Necesario',
                'banco.required' => 'Seleccione el un Banco de la lista',
                'Nbanco.required' => 'El Nombre del banco es Necesario',
                'Nbanco.sting' => 'El Nombre del banco debe ser sólo Texto',
                'Ncuenta.required' => 'EL Número de cuenta es Necesario',
                'Ncuenta.numeric' => 'Sólo ingresar Números',
                'Ncuenta.max_digits' => 'El número de banco debe de ser de hasta 18 dígitos',
                'Nclave.required' => 'EL Número de Clave es Necesario',
                'Nclave.numeric' => 'Sólo ingresar Números',
                'Nclave.digits' => 'La clave de banco debe de ser de 18 dígitos',
            ]);
            
            $pr=new Proveedor();
            /* $pr->categoria_id= $this->categoria; */
            $pr->titulo_proveedor=strtoupper($this->titulo_proveedor) ;
            $pr->rfc_proveedor=strtoupper($this->rfc) ;
            $pr->clabe=$this->Nclave;
            $pr->cuenta=$this->Ncuenta;
            $pr->banco= strtoupper($this->Nbanco);
            $pr->condicion_pago=$this->ref;
            $pr->flag_trash= 0;
            /* if(is_numeric($this->ref) ){
                $pr->condicion_pago="REF. NUMERICA: ".$this->ref;
            }
            else{
                $pr->condicion_pago=$this->ref;
            } */
               
            $pr->save();

            Alert::success('Nuevo Proveedor', "El Proveedor". ' '.$this->titulo_proveedor. ' '. "ha sido agregado al sistema");

            return redirect()->route('proveedores');
    }
    public function render()
    {
        /* $categorias=Categoria::all()->where('deleted_at',null); */
        return view('livewire.productos.proveedores.new-proveedor'/* , compact('categorias') */);
    }
}