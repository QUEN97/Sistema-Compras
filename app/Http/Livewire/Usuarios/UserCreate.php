<?php

namespace App\Http\Livewire\Usuarios;

use App\Mail\MailNewUser;
use App\Models\Permiso;
use App\Models\User;
use App\Models\Zona;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;

class UserCreate extends Component
{
    public $newgUsuario;
    public $name, $username, $email, $password, $password_confirmation, $permiso;
    public $zonas, $zonasList;

     public function resetFilters()
    {
        $this->reset(['name', 'username', 'email', 'password', 'permiso']);
    }

    public function mount()
    {
        $this->zonas = Zona::all();
        $this->newgUsuario = false;
    }

    public function showModalFormUsuario(){
        
        $this->resetFilters();

        $this->newgUsuario=true;
    }

public function addUsuario()
    {
        $usersIs = User::where('permiso_id', 1)->get();
        $this->validate( [
            'name' => ['required', 'max:250'],
            'username' => ['required',  'max:30'],
            'email' => ['required', 'string', 'email', 'max:40', 'unique:users'],
            'password' => ['required', 'string', 'confirmed', Password::min(8)],
            'password_confirmation' => ['required', 'same:password'],
            'permiso' => ['required', 'not_in:0'],
        ],
        [
            'name.required' => 'El campo Nombre es obligatorio',
            'name.max' => 'El campo Nombre no debe ser mayor a 250 carateres',
            'username.required' => 'El campo Usuario es obligatorio',
            'username.max' => 'El campo Usuario no debe ser mayor a 250 carateres',
            'email.required' => 'El campo Email es obligatorio',
            'email.email' => 'El campo Email debe ser un correo valido',
            'email.max' => 'El campo Email no debe ser mayor a 40 caracteres',
            'password.required' => 'La contraseña es obligatoria',
            'password.min' => 'La contraseña debe ser mayor a 8 caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'password_confirmation.required' => 'La contraseña es obligatoria',
            'password_confirmation.same' => 'Las contraseñas no coinciden',
            'permiso.required' => 'El campo Rol es obligatorio',
        ]);

        $pass=$this->password; //se almacena en otra variable para poder recuperarla antes del hash y poder enviarla al usuario por mail
        $emailuser= $this->email; //se almacena en otra variable para facilitar el reconocimiento al mailer y para envio al usuario
	
        // Create the user
    $user = User::create([
        'name' => $this->name,
        'username' => $this->username,
        'permiso_id' => $this->permiso,
        'email' => $this->email,
        'password' => Hash::make($this->password),
    ]);

    $user->zonas()->sync($this->zonasList);

    
    
    $ultid = User::latest('id')->first();

    $mailDataU = [
        'fecha' => $ultid->created_at,
        'usuarioname' => $ultid->name,
        'usuariousername' => $ultid->username,
        'pass' => $pass,
        'numUser' => $ultid->id,
    ];

     Mail::to($emailuser) // reconocemos al usuario creado y le enviamos el correo
    ->cc($usersIs)// no puede haber dos veces el campo bcc/cc (copia oculta)
    ->bcc('auxsistemas@fullgas.com.mx')
    ->send(new MailNewUser($mailDataU));

    $this->reset();

        $this->mount();

        $this->resetFilters();
        Alert::success('Nuevo Usuario', "El usuario". ' '.$this->name. ' '. "ha sido agregado al sistema");
        
        return redirect()->route('users');
    }

    
    public function render()
    {
        $permisos = Permiso::all();
        $zonas = Zona::where('status','Activo');
        return view('livewire.usuarios.user-create', compact('zonas','permisos'));
    }
}
