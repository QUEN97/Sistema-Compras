<?php

namespace App\Http\Livewire\Repuestos;

use Livewire\Component;
use App\Models\Repuesto;
use App\Models\Producto;
use App\Models\Archivo;
use App\Models\Estacion;
use App\Models\User;
use App\Notifications\NotifiEditRepuesto;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class EditRepuesto extends Component
{
    use WithFileUploads;

    public $EditRepuesto, $repuesto_id, $producto, $estacion, $cantidad, $descripcion, $urlArchi;
    public $evidenciaArc;
    public $evidencias = [];

    public function resetFilters()
    {
        $this->reset(['producto', 'estacion', 'cantidad', 'descripcion', 'evidencias']);
    }

    public function mount()
    {
        $this->resetFilters();

        $this->EditRepuesto = false;
    }

    public function confirmRepuestoEdit(int $id)
    {
        $repuesto = Repuesto::where('id', $id)->first();

        $this->repuesto_id = $id;
        $this->producto = $repuesto->producto_id;
        $this->cantidad = $repuesto->cantidad;
        $this->descripcion = $repuesto->descripcion;

        $this->evidenciaArc = $repuesto->archivos;

        $this->EditRepuesto = true;
    }

    public function EditarRepuesto($id)
    {
        $usersAdmins = User::where('permiso_id', 1)->get();
        $usersCompras = User::where('permiso_id', 4)->get();

        $repuest=Repuesto::find($id)->estacion_id;
        //$zonaGerente = DB::table('user_zona')->where('user_id', Estacion::find($repuest)->user->id)->first()->zona_id;
        //$usersSupers = User::where('permiso_id', 2)->join('user_zona as uz', 'uz.user_id', 'users.id')->where('uz.zona_id', $zonaGerente)->select('users.*')->get();
		$estacionGerente = DB::table('estacions')->where('user_id', Auth::user()->id)->first();
        $usersSupers = User::find($estacionGerente->supervisor_id);
        //dd($usersSupers);

        $repues = Repuesto::where('id', $id)->first();

        $estacionId = $repues->estacion_id;
        $usersGerentes = Estacion::find($estacionId)->user;
        $usersSuper = Estacion::find($estacionId)->supervisor;

        $this->validate( [
            'cantidad' => ['required', 'integer', 'numeric', 'min:0'],
            'descripcion' => ['required', 'not_in:0', 'regex:/[a-zA-Z-0-9\?:.,ñÑáéíóúÁÉÍÓÚ]+$/'],
            'evidencias.*' => 'nullable|max:1024|file|mimetypes:application/pdf,image/png,image/jpg,image/jpeg,image/webp,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'evidencias' => ['nullable'],
        ],
        [
            'evidencias.*.max' => 'El archivo no debe ser mayor a 5 MB',
            'evidencias.*.required' => 'El campo Evidencias es obligatorio',
            'evidencias.*.mimetypes' => 'Solo se aceptan archivos con extensión .png .jpg. .jpeg .pdf .doc .docx',
            'evidencias.required' => 'El campo Evidencias es obligatorio',
            'cantidad.required' => 'El campo Cantidad es obligatorio',
            'cantidad.integer' => 'El campo Cantidad debe ser un número',
            'descripcion.required' => 'El campo Descripción es obligatorio',
            'descripcion.regex' => 'La Descripción solo debe ser Texto, números y ciertos simbolos',
        ]);

        if (Auth::user()->permiso_id == 2 || Auth::user()->permiso_id == 1 && $repues->status == 'Repuesto Rechazado') {
            $repues->forceFill([
                'status' => 'Solicitado a Compras',
            ])->save();
        } elseif (Auth::user()->permiso_id == 3 && $repues->status == 'Repuesto Rechazado') {
            $repues->forceFill([
                'status' => 'Solicitado al Supervisor',
            ])->save();
        }

        $repues->forceFill([
            'cantidad' => $this->cantidad,
            'descripcion' => $this->descripcion,
        ])->save();

        if ($this->evidencias != null) {
            foreach ($this->evidencias as $lue) {

                $this->urlArchi = $lue->store('evidencias', 'public');

                Archivo::create([
                    'repuesto_id' => $id,
                    'nombre_archivo' => $lue->getClientOriginalName(),
                    'mime_type' => $lue->getMimeType(),
                    'size' => $lue->getSize(),
                    'archivo_path' => $this->urlArchi,
                    'flag_trash' => 0,
                ]);
            }
        }

        if (Auth::user()->permiso_id == 2) {
            Notification::send($usersAdmins, new NotifiEditRepuesto($repues));
            Notification::send($usersCompras, new NotifiEditRepuesto($repues));
            Notification::send($usersGerentes, new NotifiEditRepuesto($repues));
        } elseif (Auth::user()->permiso_id == 3) {
            Notification::send($usersAdmins, new NotifiEditRepuesto($repues));
            Notification::send($usersCompras, new NotifiEditRepuesto($repues));
            Notification::send($usersSupers, new NotifiEditRepuesto($repues));
        } elseif(Auth::user()->permiso_id == 1){
            Notification::send($usersGerentes, new NotifiEditRepuesto($repues));
            Notification::send($usersCompras, new NotifiEditRepuesto($repues));
            Notification::send($usersSuper, new NotifiEditRepuesto($repues));
        }

        $this->mount();

        Alert::success('Repuesto Actualizado', "El Repuesto". ' '.$repues->producto->name. ' '. "ha sido actualizada en el sistema");

        return redirect()->route('repuestos');
        
    }

    public function removeMe($index)
    {
        array_splice($this->evidencias, $index, 1);
    }

    public function removeArch($id)
    {
        DB::table('archivos')->where('id', $id)->update(['flag_trash' => 1]);
    }

    public function render()
    {
        $this->productos = Producto::where('status', 'Activo')->get();
        return view('livewire.repuestos.edit-repuesto');
    }
}
