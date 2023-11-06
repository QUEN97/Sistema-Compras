<?php

namespace App\Http\Livewire\Productos\Proveedores;

use App\Models\Proveedor;
use Livewire\Component;

class ShowProveedor extends Component
{
    public $proveedorID,$showProveedor=false;
    public $proveedor;
    public $categoria,$pName,$rfc,$clave,$nCuenta,$bank,$mpago;
    public function ShowRepuesto($id){
        
        $supplier=Proveedor::/* join('categorias as ca','proveedors.categoria_id','ca.id')
        ->select('proveedors.*', 'ca.name as categoria')
        -> */where('proveedors.id',$id)->first();
        $this->pName=$supplier->titulo_proveedor;
        /* $this->categoria=$supplier->categoria; */
        $this->rfc=$supplier->rfc_proveedor;
        $this->clave=$supplier->clabe;
        $this->nCuenta=$supplier->cuenta;
        $this->bank=$supplier->banco;
        $this->mpago=$supplier->condicion_pago;
        $this->showProveedor = true;
    }
    public function render()
    {
        return view('livewire.productos.proveedores.show-proveedor');
    }
}