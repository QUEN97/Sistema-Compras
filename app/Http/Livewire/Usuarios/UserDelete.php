<?php

namespace App\Http\Livewire\Usuarios;

use App\Models\User;
use Livewire\Component;

class UserDelete extends Component
{
    public $userID,$modalDelete=false;
    public $uName;
    public function ConfirmDelete($id){
        $supplier=User::find($id);
        $this->uName=$supplier->name;
        $this->modalDelete=true;
    }
    public function DeleteUser($id){
        $supplierDel=User::find($id);
        $supplierDel->status="Inactivo";
        $supplierDel->delete();
        $supplierDel->save();
        return redirect()->route('users');
    }
    public function render()
    {
        return view('livewire.usuarios.user-delete');
    }
}
