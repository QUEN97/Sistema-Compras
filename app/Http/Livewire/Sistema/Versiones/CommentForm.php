<?php

namespace App\Http\Livewire\Sistema\Versiones;

use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class CommentForm extends Component
{
    public $contentForm = false;
    public $content;

    public function saveComment()
    {
        $this->validate(
            [
                'content' => 'required|min:5',
            ],
            [
                'content.required'=>'El campo Comentario es Obligatorio',
                'content.min' => 'Minimo 5 Carácteres'
            ]
        );

        $user = auth()->user();

        Comment::create([
            'user_id' => $user->id,
            'content' => $this->content,
            'flag_trash' => 0,
        ]);

        $this->reset('content');

        Alert::success('Nuevo Comentario', "Gracias por ayudarnos a mejorar");

        return redirect()->route('versiones');
    }

    public function getUserComments()
    {
        $user = Auth::user();

        $comments = Comment::where('user_id', $user->id)->get();

        return view('livewire.user-comments', compact('comments'));
    }

    public function render()
    {
        return view('livewire.sistema.versiones.comment-form');
    }
}
