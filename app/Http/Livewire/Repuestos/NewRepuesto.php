<?php

namespace App\Http\Livewire\Repuestos;

use Livewire\Component;
use App\Models\Producto;
use App\Models\Estacion;
use App\Models\Repuesto;
use App\Models\Archivo;
use App\Models\Categoria;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NotifiNewRepuesto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class NewRepuesto extends Component
{
    use WithFileUploads;

    public $newgRepuesto, $producto, $estacion, $cantidad, $descripcion, $urlArchi;
    public $categoria, $categorias;
    public $evidencias = [];

    public function resetFilters()
    {
        $this->reset(['producto', 'estacion', 'cantidad', 'descripcion', 'evidencias']);
    }

    public function mount()
    {
        $this->resetFilters();

        $this->newgRepuesto = false;
    }

    public function showModalFormRepuesto()
    {
        $this->resetFilters();

        $this->newgRepuesto=true;
    }

    public function addRepuesto()
    {
        if (Auth::user()->permiso_id != 2 && Auth::user()->permiso_id != 3) {
            $this->estacionPri = Estacion::where('status', 'Activo')->where('supervisor_id', Auth::user()->id)->first();

            $producto = Producto::where('id', $this->producto)->first();

            $userCompras = User::where('permiso_id', 4)->get();

            $this->validate( [
                'cantidad' => ['required', 'integer', 'numeric', 'min:0'],
                'categoria' => ['required', 'not_in:0'],
                'producto' => ['required', 'not_in:0'],
                'estacion' => ['required', 'not_in:0'],
                'descripcion' => ['required', 'not_in:0', 'regex:/[a-zA-Z-0-9\?:.,ñÑáéíóúÁÉÍÓÚ]+$/'],
                'evidencias.*' => 'required|max:5024|file|mimetypes:application/pdf,image/png,image/jpg,image/jpeg,image/webp,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'evidencias' => ['required'],
            ],
            [
                'evidencias.*.max' => 'El archivo no debe ser mayor a 5 MB',
                'evidencias.*.required' => 'El campo Evidencias es obligatorio',
                'evidencias.*.mimetypes' => 'Solo se aceptan archivos con extensión .png .jpg .jpeg .pdf .doc .docx',
                'evidencias.required' => 'El campo Evidencias es obligatorio',
                'cantidad.required' => 'El campo Cantidad es obligatorio',
                'cantidad.integer' => 'El campo Cantidad debe ser un número',
                'categoria.required' => 'El campo Categoria es obligatorio',
                'producto.required' => 'El campo Producto es obligatorio',
                'estacion.required' => 'El campo Estación es obligatorio',
                'descripcion.required' => 'El campo Descripción es obligatorio',
                'descripcion.regex' => 'La Descripción solo debe ser Texto, números y ciertos simbolos',
            ]);

            DB::transaction(function () {
                return tap(Repuesto::create([
                    'estacion_id' => $this->estacion,
                    'producto_id' => $this->producto,
                    'cantidad' => $this->cantidad,
                    'descripcion' => $this->descripcion,
                    'status' => 'Solicitado a Compras',
                    'flag_trash' => 0,
                ]));
            });

            $ultid = Repuesto::latest('id')->first();

            $estacionId = $ultid->estacion_id;
            $usersGerentes = Estacion::find($estacionId)->user;
            $usersSuper = Estacion::find($estacionId)->supervisor;

            foreach ($this->evidencias as $lue) {

                $this->urlArchi = $lue->store('evidencias', 'public');

                Archivo::create([
                    'repuesto_id' => $ultid->id,
                    'nombre_archivo' => $lue->getClientOriginalName(),
                    'mime_type' => $lue->getMimeType(),
                    'size' => $lue->getSize(),
                    'archivo_path' => $this->urlArchi,
                    'flag_trash' => 0,
                ]);

                Notification::send($usersSuper, new NotifiNewRepuesto($ultid));
                Notification::send($userCompras, new NotifiNewRepuesto($ultid));
                Notification::send($usersGerentes, new NotifiNewRepuesto($ultid));
            }

        }elseif (Auth::user()->permiso_id == 2) {
            $this->estacionPri = Estacion::where('status', 'Activo')->where('supervisor_id', Auth::user()->id)->first();

            $producto = Producto::where('id', $this->producto)->first();

            if ($this->estacionPri == null || empty($this->estacionPri)) {
                $this->mount();

                Alert::error('Error', "No puedes solicitar repuestos porque aún no te han asignado una estación");

                return redirect()->route('repuestos');
            } else {
                $usersIs = User::where('permiso_id', 1)->get();
                $userCompras = User::where('permiso_id', 4)->get();

                $this->validate( [
                    'cantidad' => ['required', 'integer', 'numeric', 'min:0'],
                    'producto' => ['required', 'not_in:0'],
                    'estacion' => ['required', 'not_in:0'],
                    'descripcion' => ['required', 'not_in:0', 'regex:/[a-zA-Z-0-9\?:.,ñÑáéíóúÁÉÍÓÚ]+$/'],
                    'evidencias.*' => 'required|max:5024|file|mimetypes:application/pdf,image/png,image/jpg,image/jpeg,image/webp,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'evidencias' => ['required'],
                ],
                [
                    'evidencias.*.max' => 'El archivo no debe ser mayor a 5 MB',
                    'evidencias.*.required' => 'El campo Evidencias es obligatorio',
                    'evidencias.*.mimetypes' => 'Solo se aceptan archivos con extensión .png .jpg. .jpeg .pdf .doc .docx',
                    'evidencias.required' => 'El campo Evidencias es obligatorio',
                    'cantidad.required' => 'El campo Cantidad es obligatorio',
                    'cantidad.integer' => 'El campo Cantidad debe ser un número',
                    'producto.required' => 'El campo Producto es obligatorio',
                    'estacion.required' => 'El campo Estación es obligatorio',
                    'descripcion.required' => 'El campo Descripción es obligatorio',
                    'descripcion.regex' => 'La Descripción solo debe ser Texto, números y ciertos simbolos',
                ]);

                DB::transaction(function () {
                    return tap(Repuesto::create([
                        'estacion_id' => $this->estacion,
                        'producto_id' => $this->producto,
                        'cantidad' => $this->cantidad,
                        'descripcion' => $this->descripcion,
                        'status' => 'Solicitado a Compras',
                        'flag_trash' => 0,
                    ]));
                });

                $ultid = Repuesto::latest('id')->first();

            $estacionId = $ultid->estacion_id;
            $usersGerentes = Estacion::find($estacionId)->user;

                foreach ($this->evidencias as $lue) {

                    $this->urlArchi = $lue->store('evidencias', 'public');

                    Archivo::create([
                        'repuesto_id' => $ultid->id,
                        'nombre_archivo' => $lue->getClientOriginalName(),
                        'mime_type' => $lue->getMimeType(),
                        'size' => $lue->getSize(),
                        'archivo_path' => $this->urlArchi,
                        'flag_trash' => 0,
                    ]);
                    
                }

                Notification::send($usersIs, new NotifiNewRepuesto($ultid));
                Notification::send($userCompras, new NotifiNewRepuesto($ultid));
                Notification::send($usersGerentes, new NotifiNewRepuesto($ultid));
            }
            
        } elseif (Auth::user()->permiso_id == 3) {
            $this->estacion = Estacion::where('status', 'Activo')->where('user_id', Auth::user()->id)->first();

            $producto = Producto::where('id', $this->producto)->first();

            if ($this->estacion == null || empty($this->estacion)) {
                $this->mount();

                Alert::error('Error', "No puedes solicitar repuestos porque aún no te han asignado una estación");

                return redirect()->route('repuestos');
            } else {
                $usersIs = User::where('permiso_id', 1)->get();
                $userCompras = User::where('permiso_id',4)->get();

                //$zonaGerente= DB::table('user_zona')->where('user_id', Auth::user()->id)->first()->zona_id;
                //$usersSupers = User::where('permiso_id', 2)->join('user_zona as uz','uz.user_id','users.id')->where('uz.zona_id',$zonaGerente)->select('users.*')->get();
				$estacionGerente = DB::table('estacions')->where('user_id', Auth::user()->id)->first();
                $usersSupers = User::find($estacionGerente->supervisor_id);
                // //dd($usersSupers);

                $this->validate( [
                    'cantidad' => ['required', 'integer', 'numeric', 'min:0'],
                    'producto' => ['required', 'not_in:0'],
                    'descripcion' => ['required', 'not_in:0', 'regex:/[a-zA-Z-0-9\?:.,ñÑáéíóúÁÉÍÓÚ]+$/'],
                    'evidencias.*' => 'required|max:5024|file|mimetypes:application/pdf,image/png,image/jpg,image/jpeg,image/webp,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'evidencias' => ['required'],
                ],
                [
                    'evidencias.*.max' => 'El archivo no debe ser mayor a 5 MB',
                    'evidencias.*.required' => 'El campo Evidencias es obligatorio',
                    'evidencias.*.mimetypes' => 'Solo se aceptan archivos con extensión .png .jpg. .jpeg .pdf .doc .docx',
                    'evidencias.required' => 'El campo Evidencias es obligatorio',
                    'cantidad.required' => 'El campo Cantidad es obligatorio',
                    'cantidad.integer' => 'El campo Cantidad debe ser un número',
                    'producto.required' => 'El campo Producto es obligatorio',
                    'descripcion.required' => 'El campo Descripción es obligatorio',
                    'descripcion.regex' => 'La Descripción solo debe ser Texto, números y ciertos simbolos',
                ]);

                DB::transaction(function () {
                    return tap(Repuesto::create([
                        'estacion_id' => $this->estacion->id,
                        'producto_id' => $this->producto,
                        'cantidad' => $this->cantidad,
                        'descripcion' => $this->descripcion,
                        'status' => 'Solicitado al Supervisor',
                        'flag_trash' => 0,
                    ]));
                });

                $ultid = Repuesto::latest('id')->first();

                foreach ($this->evidencias as $lue) {

                    $this->urlArchi = $lue->store('evidencias', 'public');

                    Archivo::create([
                        'repuesto_id' => $ultid->id,
                        'nombre_archivo' => $lue->getClientOriginalName(),
                        'mime_type' => $lue->getMimeType(),
                        'size' => $lue->getSize(),
                        'archivo_path' => $this->urlArchi,
                        'flag_trash' => 0,
                    ]);
                    
                }

                Notification::send($usersIs, new NotifiNewRepuesto($ultid));
                Notification::send($userCompras, new NotifiNewRepuesto($ultid));
                Notification::send($usersSupers, new NotifiNewRepuesto($ultid));
            }
        }

        $this->mount();

        Alert::success('Nuevo Repuesto Solicitado', "El Repuesto para el producto". ' '.$producto->name. ' '. "ha sido solicitado");

        return redirect()->route('repuestos');
    }

    public function removeMe($index)
    {
        array_splice($this->evidencias, $index, 1);
    }

    public function updatedCategoria($id)
    {
        if (Auth::user()->permiso_id != 2 && Auth::user()->permiso_id != 3) {
            $this->productos = Producto::where('categoria_id', $id)->where('status', 'Activo')->get();
        } else {
            $user = Auth::user();
            $this->productos = Producto::whereHas('zonas', function ($query) use ($user) {
                $query->whereIn('zona_id', $user->zonas->pluck('id'));
            })->where('categoria_id', $id)->where('status', 'Activo')->where('deleted_at',null)->get();
        }
    }

    public function render()
    {

        $this->categorias=Categoria::where('status','Activo')->get();

        $this->estaciones = Estacion::where('status', 'Activo')->where('supervisor_id', Auth::user()->id)->get();

        $this->allEstaciones = Estacion::where('status', 'Activo')->get();
        return view('livewire.repuestos.new-repuesto');
    }
}
