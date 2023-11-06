<?php

namespace App\Http\Livewire\Solicitudes;

use App\Models\Categoria;
use App\Models\Estacion;
use App\Models\Producto;
use App\Models\ProductoSolicitud;
use App\Models\Solicitud;
use App\Models\SolicitudProduct;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use App\Notifications\NotifiNewSolicitud;
use App\Notifications\NotifiNewSolicitudGerente;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailNewSolicitudSupervisor;
use App\Mail\MailNewSolicitudGerente;
use App\Models\ArchivosSolicitud;
use App\Mail\MailNewSolicitudGerenteExt;
use App\Mail\MailNewSolicitudSupervisorExt;
use App\Models\ProductoExtraordinario;
use App\Models\Proveedor;
use App\Notifications\NotifiNewAdminSoli;
use Livewire\WithFileUploads;
use RealRashid\SweetAlert\Facades\Alert;

class SolicitudCreate extends Component
{
	use WithFileUploads;
    public $create = false;
    public $status, $producto, $product, $cantidad, $estacion, $solicitud, $categoria, $proveedor, $proveedor_ext,
        $productos, $soliType = "", $motivo, $itsTot, $producto_extraordinario, $total, $tipo = "";
    public $inputs = [];
    public $i = 1;
    public $currentStep = 1;
	//evidencias
    public $mostrar=false,$evidencias = [],$urlArchi;

    public function Step()
    {
        $this->currentStep++;
    }
    public function nextStep()
    {
        if (Auth::user()->permiso_id == 3) {
            $this->estacion = Estacion::where('user_id', Auth::user()->id)->first()->id;
        }
        $this->validate(
            [
                'cantidad.1' => ['required', 'integer', 'numeric', 'min:0'],
                'estacion' => ['required', 'not_in:0'],
				'producto.1' => ['required'],
                'cantidad.*' => ['required', 'integer', 'numeric', 'min:0'],
                'motivo' => ['required'],
            ],
            [
                'estacion.required' => 'El campo Estación es obligatorio',
                'cantidad.*.required' => 'El Campo Cantidad es obligatorio',
                'cantidad.*.integer' => 'El campo Cantidad debe ser un número',
                'cantidad.*.numeric' => 'El campo Cantidad debe ser un número',
                'cantidad.1.integer' => 'El campo Cantidad debe ser un número',
                'cantidad.1.numeric' => 'El campo Cantidad debe ser un número',
				'producto.1.required' => 'Este producto es obligatorio',
                'motivo.required' => 'El Campo Observación es obligatorio',
            ]
        );
		if(in_array($this->categoria,[5,6,7])){
            $this->validate([
                'evidencias' => ['required'], 
            ],[
                'evidencias.required' =>'las evidencias son requeridas'
            ]);
        }
        $this->currentStep++;
    }

    public function previousStep()
    {
        $this->currentStep--;
    }

    public function resetFilters()
    {
        $this->reset(['producto', 'estacion', 'cantidad', 'categoria']);
    }

    public function mount()
    {
        $this->resetFilters();
    }

    public function showModalFormSolicitud()
    {
        $this->resetFilters();
    }

    public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs, $i);
    }

    public function remove($i, $it)
    {
        unset($this->inputs[$i]);
        unset($this->producto[$it]);
        unset($this->cantidad[$it]);
    }

    public function rem($l)
    {
        unset($this->producto[$l]);
        unset($this->inputs[$l]);
        unset($this->cantidad[$l]);
    }

    //Compras Ordinarias
    public function addSolicitud()
    {
        if (Auth::user()->permiso_id != 2 && Auth::user()->permiso_id != 3) {
            $usCompras = User::where('permiso_id', 4)->get();
            $this->validate(
                [
                    'cantidad.1' => ['required', 'integer', 'numeric', 'min:0'],
                    'motivo' => ['required'],
                    'producto.1' => ['required', 'not_in:0'],
                    'estacion' => ['required', 'not_in:0'],
                    'cantidad.*' => ['required', 'integer', 'numeric', 'min:0'],
                    'producto.*' => ['required', 'not_in:0'],
                ],
                [
                    'estacion.required' => 'El campo Estación es obligatorio',
                    'cantidad.*.required' => 'El Campo Cantidad es obligatorio',
                    'producto.*.required' => 'El Campo Producto es obligatorio',
                    'cantidad.*.integer' => 'El campo Cantidad debe ser un número',
                    'cantidad.*.numeric' => 'El campo Cantidad debe ser un número',
                    'cantidad.1.integer' => 'El campo Cantidad debe ser un número',
                    'cantidad.1.numeric' => 'El campo Cantidad debe ser un número',
                    'motivo.required' => 'El campo Motivo de la Solicitud es obligatorio',
                ]
            );

            DB::transaction(function () {
                return tap(Solicitud::create([
                    'estacion_id' => $this->estacion,
                    'categoria_id' => $this->categoria,
                    'pdf' => "ewfwefew",
                    'status' => "Solicitado a Compras",
                    'tipo_compra' => 'Ordinario',
                    'motivo' => $this->motivo
                ]));
            });

            $ultid = Solicitud::latest('id')->first();

            $estacionId = $ultid->estacion_id;
            $usersGerentes = Estacion::find($estacionId)->user;
            $usersSuper = Estacion::find($estacionId)->supervisor;

            foreach ($this->producto as $key => $lue) {

                $tot = Producto::where('id', $lue)->pluck('precio')->first();

                ProductoSolicitud::create([
                    'solicitud_id' => $ultid->id,
                    'producto_id' => $lue,
                    'proveedor_id' => $this->proveedor[$key],
                    'cantidad' => $this->cantidad[$key],
                    'total' => $this->cantidad[$key] * $tot,
                    'flag_trash' => 0,
                ]);
            }

            $this->GeneratePDF($this->estacion, $ultid);

            $ultid->forceFill([
                'pdf' => $this->nombrePDF,
            ])->save();

            Notification::send($usCompras, new NotifiNewSolicitud($ultid));
            Notification::send($usersGerentes, new NotifiNewAdminSoli($ultid));
            Notification::send($usersSuper, new NotifiNewAdminSoli($ultid));

            $this->inputs = [];
        } elseif (Auth::user()->permiso_id == 2) {
            $this->estacionEs = Estacion::where('status', 'Activo')->where('supervisor_id', Auth::user()->id)->first();

            if ($this->estacionEs == null || empty($this->estacionEs)) {
                $this->mount();

                Alert::error('Error', "No puedes solicitar productos porque aún no te han asignado una estación");

                return redirect()->route('solicitudes');
            } else {
                 $usersIs = User::where('permiso_id', 1)->where('id','!=',2)->get();
                $Compras = User::where('permiso_id', 4)->get();

                $this->validate(
                    [
                        'cantidad.1' => ['required', 'integer', 'numeric', 'min:0'],
                        'producto.1' => ['required', 'not_in:0'],
                        'estacion' => ['required', 'not_in:0'],
                        'cantidad.*' => ['required', 'integer', 'numeric', 'min:0'],
                        'producto.*' => ['required', 'not_in:0'],
                    ],
                    [
                        'estacion.required' => 'El campo Estación es obligatorio',
                        'cantidad.*.required' => 'El Campo Cantidad es obligatorio',
                        'producto.*.required' => 'El Campo Producto es obligatorio',
                        'cantidad.*.integer' => 'El campo Cantidad debe ser un número',
                        'cantidad.*.numeric' => 'El campo Cantidad debe ser un número',
                        'cantidad.1.integer' => 'El campo Cantidad debe ser un número',
                        'cantidad.1.numeric' => 'El campo Cantidad debe ser un número',
                    ]
                );

                DB::transaction(function () {
                    return tap(Solicitud::create([
                        'estacion_id' => $this->estacion,
                        'categoria_id' => $this->categoria,
                        'pdf' => "ewfwefew",
                        'status' => "Solicitado a Compras",
                        'tipo_compra' => 'Ordinario',
                        'motivo' => $this->motivo,
                    ]));
                });

                $ultid = Solicitud::latest('id')->first();

                $estacionId = $ultid->estacion_id;
                $usersGerentes = Estacion::find($estacionId)->user;

                    //dd($usersGerentes);

                foreach ($this->producto as $key => $lue) {

                    $tot = Producto::where('id', $lue)->pluck('precio')->first();

                    ProductoSolicitud::create([
                        'solicitud_id' => $ultid->id,
                        'producto_id' => $lue,
                        //'proveedor_id' => $this->proveedor[$key],
                        'cantidad' => $this->cantidad[$key],
                        'total' => $this->cantidad[$key] * $tot,
                        'flag_trash' => 0,
                    ]);
                }

                $this->GeneratePDF($this->estacion, $ultid);

                $ultid->forceFill([
                    'pdf' => $this->nombrePDF,
                ])->save();

                $this->estac = Estacion::where('id', $this->estacion)->first();

                $mailData = [
                    'solicitadopor' => Auth::user()->name,
                    'fechaSolicitud' => $ultid->created_format,
                    'estaci' => $this->estac->name,
                    'solicitudprodu' => $ultid->productos,
                    'categ' => $ultid->categoria->name,
                    'numSolici' => $ultid->id,
                    'nombrePdf' => $this->nombrePDF,
                    'motivo' => $ultid->motivo,
                ];

                Mail::to($usersIs)
                    //->cc($usersSupers)
                    //->bcc('comprasgdl@fullgas.com.mx','auxsistemas@fullgas.com.mx')
                    ->send(new MailNewSolicitudGerenteExt($mailData));

                Notification::send($usersIs, new NotifiNewSolicitud($ultid));
                Notification::send($Compras, new NotifiNewSolicitud($ultid));
                Notification::send($usersGerentes, new NotifiNewSolicitud($ultid));

                $this->inputs = [];
            }
        } elseif (Auth::user()->permiso_id == 3) {
            $this->estacion = Estacion::where('status', 'Activo')->where('user_id', Auth::user()->id)->first();

            //$producto = Producto::where('id', $this->producto)->first();

            if ($this->estacion == null || empty($this->estacion)) {
                $this->mount();

                Alert::error('Error', "No puedes solicitar productos porque aún no te han asignado una estación");

                return redirect()->route('solicitudes');
            } else {
                $usersAdmins = User::where('permiso_id', 1)->where('id','!=',2)->get();
                $usersCompras = User::where('permiso_id', 4)->get();
                //dd($usersAdmins);
                //$zonaGerente = DB::table('user_zona')->where('user_id', Auth::user()->id)->first()->zona_id;
                //$usersSupers = User::where('permiso_id', 2)->join('user_zona as uz', 'uz.user_id', 'users.id')->where('uz.zona_id', $zonaGerente)->select('users.*')->get();
				$estacionGerente = DB::table('estacions')->where('user_id', Auth::user()->id)->first();
                $usersSupers = User::find($estacionGerente->supervisor_id); // se envia solo al supervisor de la estacion que realiza la solicitud
                //dd($usersSupers);

                $this->validate(
                    [
                        'cantidad.1' => ['required', 'integer', 'numeric', 'min:0'],
                        'producto.1' => ['required', 'not_in:0'],
                        'categoria' => ['required', 'integer', 'numeric', 'min:0'],
                        'motivo' => ['required'],
                        'cantidad.*' => ['required', 'integer', 'numeric', 'min:0'],
                        'producto.*' => ['required', 'not_in:0'],
                    ],
                    [
                        'cantidad.*.required' => 'el Campo Cantidad es obligatorio',
                        'producto.*.required' => 'el Campo Producto es obligatorio',
                        'cantidad.*.integer' => 'El campo Cantidad debe ser un número',
                        'cantidad.*.numeric' => 'El campo Cantidad debe ser un número',
                        'cantidad.1.integer' => 'El campo Cantidad debe ser un número',
                        'cantidad.1.numeric' => 'El campo Cantidad debe ser un número',
                    ]
                );
                DB::transaction(function () {
                    return tap(Solicitud::create([
                        'estacion_id' => $this->estacion->id,
                        'categoria_id' => $this->categoria,
                        'pdf' => "Por Definir",
                        'status' => "Solicitado al Supervisor",
                        'tipo_compra' => 'Ordinario',
                        'motivo' => $this->motivo,
                    ]));
                });
                $ultid = Solicitud::latest('id')->first();

                foreach ($this->producto as $key => $lue) {
                    $tot = Producto::where('id', $lue)->pluck('precio')->first();
                    ProductoSolicitud::create([
                        'solicitud_id' => $ultid->id,
                        'producto_id' => $lue,
                        //'proveedor_id' => $this->proveedor[$key],
                        'cantidad' => $this->cantidad[$key],
                        'total' => $this->cantidad[$key] * $tot,
                        'flag_trash' => 0,
                    ]);
                }

                $this->GeneratePDF($this->estacion->id, $ultid);

                $ultid->forceFill([
                    'pdf' => $this->nombrePDF,
                ])->save();

                Notification::send($usersAdmins, new NotifiNewSolicitudGerente($ultid));
                //Notification::send($usersCompras, new NotifiNewSolicitudGerente($ultid));
                Notification::send($usersSupers, new NotifiNewSolicitudGerente($ultid));

                $mailData = [
                    'solicitadopor' => Auth::user()->name,
                    'fechaSolicitud' => $ultid->created_format,
                    'estaci' => $this->estacion->name,
                    'solicitudprodu' => $ultid->productos,
                    'categ' => $ultid->categoria->name,
                    'numSolici' => $ultid->id,
                    'nombrePdf' => $this->nombrePDF,
                    'motivo' => $ultid->motivo,
                ];

                // Lista de correos electrónicos en copia oculta (CCO)
                 $bccEmails = [
                    $usersSupers,
                    //'comprasgdl@fullgas.com.mx',
                    'admonsistemas@fullgas.com.mx',
                    // Agrega más direcciones de correo aquí...
                ];

                Mail::to($usersAdmins)
                    ->cc($bccEmails)
                    ->send(new MailNewSolicitudGerente($mailData));

                $this->inputs = [];
            }
        }

		$ultid = Solicitud::latest('id')->first();
        if(in_array($this->categoria,[5,6,7])){
            foreach ($this->evidencias as $lue) {
                $this->urlArchi = $lue->store('gdl/solicitudes/evidencias', 'public');
                $archivo=new ArchivosSolicitud();
                $archivo->solicitud_id=$ultid->id;
                $archivo->nombre_archivo=$lue->getClientOriginalName();
                $archivo->mime_type=$lue->getMimeType();
                $archivo->size=$lue->getSize();
                $archivo->archivo_path=$this->urlArchi;
                $archivo->save();
            }
        }
        $this->mount();
        Alert::success('Nueva Solicitud De Productos', "Se ha enviado la solicitud de productos");
        return redirect()->route('solicitudes');
    }

    //Compras Extraordinarias
    public function addSolicitudExt()
    {
        //dd($this->proveedor_ext);
        if (Auth::user()->permiso_id != 2 && Auth::user()->permiso_id != 3) {
            $usCompras = User::where('permiso_id', 4)->get();
            $this->validate(
                [
                    'cantidad.1' => ['required', 'integer', 'numeric', 'min:0'],
                    'total.1' => ['required', 'integer', 'numeric', 'min:0'],
                    'motivo' => ['required'],
                    'estacion' => ['required', 'not_in:0'],
                    'cantidad.*' => ['required', 'integer', 'numeric', 'min:0'],
                    'total.*' => ['required', 'integer', 'numeric', 'min:0'],
                    'producto.*' => ['required', 'not_in:0'],
                ],
                [
                    'estacion.required' => 'El campo Estación es obligatorio',
                    'cantidad.*.required' => 'El Campo Cantidad es obligatorio',
                    'total.*.required' => 'El Campo Cantidad es obligatorio',
                    'producto.*.required' => 'El Campo Producto es obligatorio',
                    'cantidad.*.integer' => 'El campo Cantidad debe ser un número',
                    'cantidad.*.numeric' => 'El campo Cantidad debe ser un número',
                    'total.*.integer' => 'El campo Precio debe ser un número',
                    'total.*.numeric' => 'El campo Precio debe ser un número',
                    'cantidad.1.integer' => 'El campo Cantidad debe ser un número',
                    'total.1.integer' => 'El campo Precio debe ser un número',
                    'cantidad.1.numeric' => 'El campo Cantidad debe ser un número',
                    'total.1.numeric' => 'El campo Precio debe ser un número',
                    'motivo.required' => 'El campo Motivo de la Solicitud es obligatorio',
                ]
            );

            DB::transaction(function () {
                return tap(Solicitud::create([
                    'estacion_id' => $this->estacion,
                    'categoria_id' => $this->categoria,
                    'pdf' => "ewfwefew",
                    'status' => "Solicitado a Compras",
                    'tipo_compra' => 'Extraordinario',
                    'motivo' => $this->motivo
                ]));
            });

            $ultid = Solicitud::latest('id')->first();

            $estacionId = $ultid->estacion_id;
            $usersGerentes = Estacion::find($estacionId)->user;
            $usersSuper = Estacion::find($estacionId)->supervisor;

            foreach ($this->producto_extraordinario as $key => $lueext) {

                ProductoExtraordinario::create([
                    'solicitud_id' => $ultid->id,
                    'tipo' => $this->tipo,
                    'producto_extraordinario' => $lueext,
                    'proveedor_id' => $this->proveedor_ext[$key],
                    'cantidad' => $this->cantidad[$key],
                    'total' => $this->total[$key],
                    'flag_trash' => 0,
                ]);
            }

            $this->GenerateExtPDF($this->estacion, $ultid);

            $ultid->forceFill([
                'pdf' => $this->nombrePDF,
            ])->save();

            Notification::send($usCompras, new NotifiNewSolicitud($ultid));
            Notification::send($usersGerentes, new NotifiNewAdminSoli($ultid));
            Notification::send($usersSuper, new NotifiNewAdminSoli($ultid));

            $this->inputs = [];
        } elseif (Auth::user()->permiso_id == 2) {
            $this->estacionEs = Estacion::where('status', 'Activo')->where('supervisor_id', Auth::user()->id)->first();

            if ($this->estacionEs == null || empty($this->estacionEs)) {
                $this->mount();

                Alert::error('Error', "No puedes solicitar productos porque aún no te han asignado una estación");

                return redirect()->route('solicitudes');
            } else {
                $usersIs = User::where('permiso_id', 1)->where('id','!=',2)->get();
                $Compras = User::where('permiso_id', 4)->get();

                $this->validate(
                    [
                        'cantidad.1' => ['required', 'integer', 'numeric', 'min:0'],
                        'producto_extraordinario.1' => ['required', 'not_in:0'],
                        'estacion' => ['required', 'not_in:0'],
                        'cantidad.*' => ['required', 'integer', 'numeric', 'min:0'],
                        'producto_extraordinario.*' => ['required', 'not_in:0'],
                    ],
                    [
                        'estacion.required' => 'El campo Estación es obligatorio',
                        'cantidad.*.required' => 'El Campo Cantidad es obligatorio',
                        'producto_extraordinario.*.required' => 'El Campo Producto es obligatorio',
                        'cantidad.*.integer' => 'El campo Cantidad debe ser un número',
                        'cantidad.*.numeric' => 'El campo Cantidad debe ser un número',
                        'cantidad.1.integer' => 'El campo Cantidad debe ser un número',
                        'cantidad.1.numeric' => 'El campo Cantidad debe ser un número',
                    ]
                );
                //dd($this->cantidad);

                DB::transaction(function () {
                    return tap(Solicitud::create([
                        'estacion_id' => $this->estacion,
                        'categoria_id' => $this->categoria,
                        'pdf' => "ewfwefew",
                        'status' => "Solicitado a Compras",
                        'tipo_compra' => 'Extraordinario',
                        'motivo' => $this->motivo,
                    ]));
                });

                $ultid = Solicitud::latest('id')->first();

                $estacionId = $ultid->estacion_id;
                $usersGerentes = Estacion::find($estacionId)->user;

                foreach ($this->producto_extraordinario as $key => $lueext) {

                    ProductoExtraordinario::create([
                        'solicitud_id' => $ultid->id,
                        'tipo' => $this->tipo,
                        'producto_extraordinario' => $lueext,
                        //'proveedor_id' => $this->proveedor_ext[$key],
                        'cantidad' => $this->cantidad[$key],
                        'total' => 0,
                        'flag_trash' => 0,
                    ]);
                }


                $this->GenerateExtPDF($this->estacion, $ultid);

                $ultid->forceFill([
                    'pdf' => $this->nombrePDF,
                ])->save();

                $this->estac = Estacion::where('id', $this->estacion)->first();

                $mailData = [
                    'solicitadopor' => Auth::user()->name,
                    'fechaSolicitud' => $ultid->created_format,
                    'estaci' => $this->estac->name,
                    'solicitudprodu' => $ultid->extraordinarios,
                    'categ' => $ultid->categoria->name,
                    'numSolici' => $ultid->id,
                    'nombrePdf' => $this->nombrePDF,
                    'motivo' => $ultid->motivo,
                ];

                // Lista de correos electrónicos en copia oculta (CCO)
                 $bccEmails = [
                    $usersSupers,
                    'comprasgdl@fullgas.com.mx',
                    'admonsistemas@fullgas.com.mx',
                    // Agrega más direcciones de correo aquí...
                ];

                Mail::to($usersAdmins)
                    ->cc($bccEmails)
                    ->send(new MailNewSolicitudGerenteExt($mailData));

                Notification::send($usersIs, new NotifiNewSolicitud($ultid));
                Notification::send($Compras, new NotifiNewSolicitud($ultid));
                Notification::send($usersGerentes, new NotifiNewSolicitud($ultid));

                $this->inputs = [];
            }
        } elseif (Auth::user()->permiso_id == 3) {
            $this->estacion = Estacion::where('status', 'Activo')->where('user_id', Auth::user()->id)->first();

            //$producto = Producto::where('id', $this->producto)->first();

            if ($this->estacion == null || empty($this->estacion)) {
                $this->mount();

                Alert::error('Error', "No puedes solicitar productos porque aún no te han asignado una estación");

                return redirect()->route('solicitudes');
            } else {
                $usersAdmins = User::where('permiso_id', 1)->where('id','!=',2)->get();
                $usersCompras = User::where('permiso_id', 4)->get();

                $zonaGerente = DB::table('user_zona')->where('user_id', Auth::user()->id)->first()->zona_id;
                $usersSupers = User::where('permiso_id', 2)->join('user_zona as uz', 'uz.user_id', 'users.id')->where('uz.zona_id', $zonaGerente)->select('users.*')->get();
                //dd($usersSupers);

                $this->validate(
                    [
                        'cantidad.1' => ['required', 'integer', 'numeric', 'min:0'],
                        'producto_extraordinario.1' => ['required', 'not_in:0'],
                        'categoria' => ['required', 'integer', 'numeric', 'min:0'],
                        'motivo' => ['required'],
                        'cantidad.*' => ['required', 'integer', 'numeric', 'min:0'],
                        'producto_extraordinario.*' => ['required', 'not_in:0'],
                    ],
                    [
                        'cantidad.*.required' => 'el Campo Cantidad es obligatorio',
                        'producto_extraordinario.*.required' => 'el Campo Producto es obligatorio',
                        'cantidad.*.integer' => 'El campo Cantidad debe ser un número',
                        'cantidad.*.numeric' => 'El campo Cantidad debe ser un número',
                        'cantidad.1.integer' => 'El campo Cantidad debe ser un número',
                        'cantidad.1.numeric' => 'El campo Cantidad debe ser un número',
                    ]
                );

                DB::transaction(function () {
                    return tap(Solicitud::create([
                        'estacion_id' => $this->estacion->id,
                        'categoria_id' => $this->categoria,
                        'pdf' => "Por Definir",
                        'status' => "Solicitado al Supervisor",
                        'tipo_compra' => 'Extraordinario',
                        'motivo' => $this->motivo,
                    ]));
                });

                $ultid = Solicitud::latest('id')->first();

                foreach ($this->producto_extraordinario as $key => $lueext) {

                    ProductoExtraordinario::create([
                        'solicitud_id' => $ultid->id,
                        'tipo' => $this->tipo,
                        'producto_extraordinario' => $lueext,
                        //'proveedor_id' => $this->proveedor_ext[$key],
                        'cantidad' => $this->cantidad[$key],
                        'total' => 0,
                        'flag_trash' => 0,
                    ]);
                }

                $this->GenerateExtPDF($this->estacion->id, $ultid);

                $ultid->forceFill([
                    'pdf' => $this->nombrePDF,
                ])->save();

                $mailData = [
                    'solicitadopor' => Auth::user()->name,
                    'fechaSolicitud' => $ultid->created_format,
                    'estaci' => $this->estacion->name,
                    'solicitudprodu' => $ultid->extraordinarios,
                    'categ' => $ultid->categoria->name,
                    'numSolici' => $ultid->id,
                    'nombrePdf' => $this->nombrePDF,
                    'motivo' => $ultid->motivo,
                ];

                Mail::to($usersAdmins)
                    ->cc($usersSupers)
                    ->bcc('comprasgdl@fullgas.com.mx')
                    ->bcc('auxsistemas@fullgas.com.mx')
                    ->send(new MailNewSolicitudGerenteExt($mailData));

                Notification::send($usersAdmins, new NotifiNewSolicitudGerente($ultid));
                //Notification::send($usersCompras, new NotifiNewSolicitudGerente($ultid));
                Notification::send($usersSupers, new NotifiNewSolicitudGerente($ultid));

                $this->inputs = [];
            }
        }

        $this->mount();

        Alert::success('Nueva Solicitud De Productos', "Se ha enviado la solicitud de productos");

        return redirect()->route('solicitudes');
    }

    // Genera PDF Compras Ordinarias
    public function GeneratePDF($estacion, $solicitud)
    {
        $fecha = now()->format('d-m-Y');
        $supervisor = Auth::user()->name;
        $gerente = Auth::user()->name;

        $this->est = Estacion::where('id', $estacion)->first();

        if (Auth::user()->permiso_id == 2) {
            $this->nombrePDF = $fecha . '_' . $this->est->name . '_' . $supervisor . '_' . rand(10, 100000) . '.pdf';
        } elseif (Auth::user()->permiso_id == 3) {
            $this->nombrePDF = $fecha . '_' . $this->est->name . '_' . $gerente . '_' . rand(10, 100000) . '.pdf';
        } elseif (Auth::user()->permiso_id != 2 && Auth::user()->permiso_id != 3) {
            $this->nombrePDF = $fecha . '_' . $this->est->name . '_' . $this->est->supervisor->name . '_' . rand(10, 100000) . '.pdf';
        }

        $this->itsTot = ProductoSolicitud::where('solicitud_id', $solicitud->id)->where('flag_trash', 0)->sum('total');

        $data = [
            'fechaSolicitud' => $solicitud->created_format,
            'estacio' => $this->est->name,
            'zonaEsta' => $this->est->zona->name,
            'catego' => $solicitud->categoria->name,
            'solicitudproducto' => $solicitud,
            'numSolicitud' => $solicitud->id,
            'motivo' => $solicitud->motivo,
            'totalSoli' => 0,
            'iva'=>0,
            'isr'=>0,
            'total'=>0
        ];

        $cont = Pdf::loadView('livewire.solicitudes.solicitud-pdf', $data)->output();

        Storage::disk('public')->put('solicitudes-pdfs/' . $this->nombrePDF, $cont);
    }

    //Genera PDF Compras Extraordinarias
    public function GenerateExtPDF($estacion, $solicitud)
    {
        $fecha = now()->format('d-m-Y');
        $supervisor = Auth::user()->name;
        $gerente = Auth::user()->name;

        $this->est = Estacion::where('id', $estacion)->first();

        if (Auth::user()->permiso_id == 2) {
            $this->nombrePDF = $fecha . '_' . $this->est->name . '_' . $supervisor . '_' . rand(10, 100000) . '.pdf';
        } elseif (Auth::user()->permiso_id == 3) {
            $this->nombrePDF = $fecha . '_' . $this->est->name . '_' . $gerente . '_' . rand(10, 100000) . '.pdf';
        } elseif (Auth::user()->permiso_id != 2 && Auth::user()->permiso_id != 3) {
            $this->nombrePDF = $fecha . '_' . $this->est->name . '_' . $this->est->supervisor->name . '_' . rand(10, 100000) . '.pdf';
        }

        $this->itsTot = ProductoExtraordinario::where('solicitud_id', $solicitud->id)->where('flag_trash', 0)->sum('total');

        $data = [
            'fechaSolicitud' => $solicitud->created_format,
            'estacio' => $this->est->name,
            'zonaEsta' => $this->est->zona->name,
            'catego' => $solicitud->categoria->name,
            'solicitudproducto' => $solicitud,
            'numSolicitud' => $solicitud->id,
            'motivo' => $solicitud->motivo,
            'totalSoli' => 0,
            'iva'=>0,
            'isr'=>0,
            'total'=>0
        ];

        $cont = Pdf::loadView('livewire.solicitudes.solicitud-ext-pdf', $data)->output();

        Storage::disk('public')->put('solicitudes-pdfs/' . $this->nombrePDF, $cont);
    }

    public function updatedCategoria($id)
    {
        if (Auth::user()->permiso_id != 2 && Auth::user()->permiso_id != 3) {
            $this->productos = Producto::where('categoria_id', $id)->where('status', 'Activo')->get();
        } else {
            // $this->productos = Producto::where('categoria_id', $id)->where('status', 'Activo')->where('zona_id', Auth::user()->zona_id)->get();
            $user = Auth::user();
            $this->productos = Producto::whereHas('zonas', function ($query) use ($user) {
                $query->whereIn('zona_id', $user->zonas->pluck('id'));
            })->where('categoria_id', $id)->where('status', 'Activo')->get();
        }
		if(in_array($id,[5,6,7])){
            $this->mostrar=true;
        }
        else{
            $this->mostrar=false;
        }
    }

    public function render()
    {
        $categorias = Categoria::where('status', 'Activo')->where('id', '!=', 8)->get();
        $proveedores = Proveedor::all()->where('flag_trash', 0);
        $categoriasExt = Categoria::whereNotIn('id', [1, 2, 3, 4, 5, 6, 7,9])->get();
        $allEsta = Estacion::where('status', 'Activo')->get();
        $superEsta = Estacion::where('status', 'Activo')->where('supervisor_id', Auth::user()->id)->get();
        return view('livewire.solicitudes.solicitud-create', compact('categorias', 'allEsta', 'superEsta', 'categoriasExt', 'proveedores'));
    }
}
