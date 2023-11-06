<?php

namespace App\Http\Livewire\Sistema\Manuales;

use App\Models\Manual;
use Livewire\Component;

class ManualDelete extends Component
{
    public $manID,$modalDelete=false;
    public $mName;
    public function ConfirmDelete($id){
        $supplier=Manual::find($id);
        $this->mName=$supplier->titulo_manual;
        $this->modalDelete=true;
    }
    public function DeleteManual($id){
        $supplierDel=Manual::find($id);
        $supplierDel->flag_trash=0;
        $supplierDel->save();
        return redirect()->route('manuales');
    }
    public function render()
    {
        return view('livewire.sistema.manuales.manual-delete');
    }
}
