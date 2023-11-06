<?php

namespace App\Http\Livewire\Productos\Proveedores;

use App\Models\Categoria;
use App\Models\Proveedor;
use Livewire\Component;

class EditProveedor extends Component
{
    public $proveedorID;
    public $editProveedor=false,$showRef=false,$showBank=false;
    public $categoria,$rfc,$titulo_proveedor,$numRef,$ref,$banco,$Ncuenta,$Nclave,$Nbanco;
    public function confirmProveedorEdit($id){
        $supplier=Proveedor::find($id);
        $this->titulo_proveedor= $supplier->titulo_proveedor;
        $this->rfc= $supplier->rfc_proveedor;
       /*  $this->categoria= $supplier->categoria_id; */
        $this->Ncuenta= $supplier->cuenta;
        $this->Nclave= $supplier->clabe;
        $this->Nbanco= $supplier->banco;
        $this->ref= $supplier->condicion_pago;
        $this->editProveedor=true;
    }
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
            //$this->Nbanco="";
            $this->showBank=true;
        }
        else{
            $this->Nbanco=$bk;
            $this->showBank=false;
        }
    }
    public function ProveedorUpdate($id){
        $this->validate( [
            'titulo_proveedor' => ['required', 'string'],
            'rfc' => ['required', 'string', 'size:13', 'regex:/^[A-ZÑ&]{3,4}[0-9]{6}[A-V1-9][0-9A-HJ-NP-TV-Z]{2}$/'],
            /* 'categoria' => ['required', 'not_in:0'], */
            'Nbanco'=>['required','string'],
            'Ncuenta'=>['required','numeric','max_digits:18'],
            'Nclave'=>['required','numeric','digits:18'],],
        [
            'titulo_proveedor.required' => 'El Nombre del Proveedor es obligatorio',
            'titulo_proveedor.string' => 'El Nombre del Proveedor debe ser solo Texto',         
            'rfc.required' => 'El RFC del Proveedor es obligatorio',
            'rfc.string' => 'El RFC del Proveedor debe ser solo Texto',
            'rfc.size' => 'El RFC del Proveedor debe de ser de 13 caracteres',
            'rfc.regex' => 'Ingrese un RFC válido',
            /* 'categoria.required' => 'La Categoría es obligatoria', */
            'Nbanco.required' => 'El Nombre del banco es Necesario',
            'Nbanco.sting' => 'El Nombre del banco debe ser sólo Texto',
            'Ncuenta.required' => 'EL Número de cuenta es Necesario',
            'Ncuenta.numeric' => 'Sólo ingresar Números',
            'Ncuenta.max_digits' => 'El número de banco debe de ser de hasta 18 dígitos',
            'Nclave.required' => 'EL Número de Clave es Necesario',
            'Nclave.numeric' => 'Sólo ingresar Números',
            'Nclave.digits' => 'La clave de banco debe de ser de 18 dígitos']);


        $supplierUP=Proveedor::find($id);
       /*  $supplierUP->categoria_id=$this->categoria; */
        $supplierUP->titulo_proveedor=strtoupper($this->titulo_proveedor);
        $supplierUP->rfc_proveedor=strtoupper($this->rfc);
        $supplierUP->clabe=$this->Nclave;
        $supplierUP->cuenta=$this->Ncuenta;
        $supplierUP->banco=$this->Nbanco;
        $supplierUP->condicion_pago=$this->ref;
        $supplierUP->save();
        return redirect()->route('proveedores');
    }
    public function render()
    {
        /* $categorias=Categoria::all()->where('deleted_at',null); */
        return view('livewire.productos.proveedores.edit-proveedor'/* ,compact('categorias') */);
    }
}