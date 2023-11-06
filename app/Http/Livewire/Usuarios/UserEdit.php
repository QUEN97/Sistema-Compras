<?php

namespace App\Http\Livewire\Usuarios;

use App\Models\Permiso;
use App\Models\User;
use App\Models\Zona;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class UserEdit extends Component
{
    public $EditUsuario;
    public $user_edit_id, $name, $username, $email, $role, $status, $password, $password_confirmation;

    public $zonasUpdate;

    public function resetFilters()
    {
        $this->reset(['name', 'username', 'email', 'password', 'role',  'status']);
    }

    public function mount( )
    {
        $this->EditUsuario = false;
        $this->zonasUpdate=[];
    }

    public function confirmUserEdit(int $id) {

        $user = User::where('id', $id)->first();

        $this->user_edit_id = $id;
        $this->name = $user->name;
        $this->username = $user->username;
        $this->email = $user->email;

        $this->role = $user->permiso->id;
        $this->status = $user->status;

        $this->EditUsuario = true;
        
        $arrayID=[];
        $zonasArray=DB::table('user_zona')->select('zona_id')->where('user_id',$id)->get(); 
        foreach($zonasArray as $zona){
           
           $arrayID[]=$zona->zona_id;
       } 
       
       $this->zonasUpdate=$arrayID;
    }

    public function EditarUsuario($id) {
        $user = User::where('id', $id)->first();

            $this->validate( [
                'name' => ['required', 'string', 'max:250'],
                'username' => ['required', 'string', 'max:250'],
                'email' => ['required', 'email', 'max:40', Rule::unique('users')->ignore($user->id)],
                'password' => ['nullable', 'string', 'confirmed', Password::min(8)],
                'password_confirmation' => ['same:password'],
                'role' => ['required', 'not_in:0'],
                'status' => ['required', 'not_in:0'],
        ],
        [
            'name.required' => 'El campo Nombre es obligatorio',
            'name.string' => 'El campo Nombre debe ser Texto',
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
            'role.required' => 'El campo Rol es obligatorio',
            'status.required' => 'El campo Status es obligatorio',
        ]);

        if ($this->email !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user);
        } else {
            $user->forceFill([
                'name' => $this->name,
                'username' => $this->username,
                'email' => $this->email,
                'permiso_id' => $this->role,
                'status' => $this->status,
            ])->save();
        }

        if (!empty($this->password)) {
            $user->forceFill([
                'password' => Hash::make($this->password),
            ])->save();  
        } else {
            $user->forceFill([
                'name' => $this->name,
                'username' => $this->username,
                'email' => $this->email,
                'permiso_id' => $this->role,
                'status' => $this->status,
            ])->save();
        }
        if (isset($user->zonas)){
            $user->zonas()->sync($this->zonasUpdate);
            }else{
                $user->zonas()->sync(array());
            }

        $this->resetFilters();
        Alert::success('Usuario Actualizado', "El usuario". ' '.$this->name. ' '. "ha sido actualizado en el sistema");

        return redirect()->route('users');
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    protected function updateVerifiedUser($user) {
        $user->forceFill([
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'permiso_id' => $this->role,
            'status' => $this->statId,
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
    
    public function render()
    {
        $permisos = Permiso::all();
        $zonas = Zona::all();
        return view('livewire.usuarios.user-edit', compact('zonas','permisos'));
    }
}
