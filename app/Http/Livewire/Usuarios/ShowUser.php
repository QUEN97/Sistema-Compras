<?php

namespace App\Http\Livewire\Usuarios;

use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class ShowUser extends Component
{
    public $ShowgUsuario;
    public $user_show_id;
    public $photo, $name, $username, $email, $rol, $zonas, $status, $created_at, $picture;

    public function mount()
    {
        $this->ShowgUsuario = false;
    }

    public function confirmShowUsuario(int $id)
    {
        $user = User::where('id', $id)->first();

        $this->user_show_id = $id;
        $this->name = $user->name;
        $this->username = $user->username;
        $this->email = $user->email;

        $this->rol = $user->permiso->titulo_permiso;

        $this->status = $user->status;
        $this->created_at = Carbon::parse($user['created_at'])->isoFormat('D MMMM Y  h:mm:ss A ');
        $this->picture = $user->profile_photo_path;
        $this->photo = $user->profile_photo_url;

        //$this->created_at = $user->created_format;

        $this->ShowgUsuario = true;
    }

    public function render()
    {
        $user = User::with('zonas')->find($this->user_show_id);
        return view('livewire.usuarios.show-user', compact('user'));
    }
}
