<?php

namespace App\Http\Livewire\Sistema\Manuales;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Manual;
use App\Models\ManualPermiso;

class TableManuales extends Component
{
    public $item_id;
    public $confirmingManuDeletion = false;
    
   
    public function confirmManuDeletion ( $id)
    {
        $this->confirmingManuDeletion = $id;
    }

    public function deleteManu (Manual $man)
    {
        $man->forceFill([
            'flag_trash' => 1,
        ])->save();
        $this->confirmingManuDeletion = false;
        session()->flash('message', 'Manual eliminado exitosamente');
    }
    public function render()
    {
        $this->valid = Auth::user()->permiso->panels->where('id', 10)->first();

        $this->manuals = Manual::where('flag_trash', 0)->get();

        //$this->manpermis = ManualPermiso::where('permiso_id', Auth::user()->permiso_id)->get();

        return view('livewire.sistema.manuales.table-manuales');
    }
}
