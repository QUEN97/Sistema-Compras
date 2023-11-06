<?php

namespace App\Http\Livewire\Sistema\Versiones;

use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class UserComments extends Component
{
    public $usercomment = false;

   
    public function render()
    {
        // $user = Auth::user();
        // $comments = Comment::where('user_id', $user->id)->get(); comentario de cada usuario

        $comments = Comment::where('flag_trash', 0)->get();
        return view('livewire.sistema.versiones.user-comments', compact('comments'));
    }

    public function DeleteComment($id){
        $supplierDel=Comment::find($id);
        $supplierDel->flag_trash=1;
        $supplierDel->save();
        return redirect()->route('versiones');
    }
}
