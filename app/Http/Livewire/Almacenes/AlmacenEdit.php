<?php

namespace App\Http\Livewire\Almacenes;

use Livewire\Component;
use App\Models\EstacionProducto;
use App\Models\FoliosHistorial;
use App\Models\Estacion;
use App\Models\Folio;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NotifiNewAlmacenGerente;


class AlmacenEdit extends Component
{
    public $EditAlmacen;
    public $almacen_edit_id, $almacen_produ_id, $cantidad, $estacion, $motivo, $observacion;

    //FUNCION PARA RESETEAR LOS CAMPOS Y DEJARLOS EN BLANCO
    public function resetFilters()
    {
        $this->reset(['cantidad', 'estacion', 'motivo', 'observacion']);
    }

    //FUNCIÓN (propio de livewire) PARA INICIALIZAR EL MODAL OCULTO
    public function mount()
    {
        $this->resetFilters();

        $this->EditAlmacen = false;
    }

    //FUNCIÓN PARA LEVANTAR EL MODAL A LA VISTA
    public function confirmAlmacenEdit(int $id)
    {
        $alma = EstacionProducto::where('id', $id)->first();

        $this->cantidad = $alma->stock;
       

        $this->EditAlmacen = true;
    }

    //FUNCIÓN PARA EDITAR "SOLICITAR TRASPASO"
    public function EditarAlmacen($id)
    {
        $this->almac = EstacionProducto::where('id', $id)->first();

        $this->validate([
            'cantidad' => ['required', 'numeric', 'integer', 'regex:/[0-9]+$/'],
            'motivo' => ['required', 'string', 'max:100', 'regex:/[a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/'],
            'observacion' => ['required', 'not_in:0', 'regex:/[a-zA-Z-0-9ñÑáéíóúÁÉÍÓÚ]+$/'],
            'estacion' => ['required', 'not_in:0'],
        ],
        [
            'cantidad.required' => 'La Cantidad es oblogatoria',
            'cantidad.numeric' => 'La Cantidad debe ser solo Número',
            'cantidad.integer' => 'La Cantidad debe ser Número entero',
            'cantidad.regex' => 'La Cantidad solo debe ser Números',
            'estacion.required' => 'La Estación es obligatoria',
            'motivo.required' => 'El Campo Motivo es obligatorio',
            'motivo.string' => 'El Campo Motivo deb ser Texto',
            'motivo.max' => 'El campo Motivo no debe ser mayor a 100 carateres',
            'motivo.regex' => 'El campo Motivo solo debe ser Texto',
            'observacion.required' => 'El campo Observaciones es obligatorio',
            'observacion.regex' => 'El campo Observaciones solo debe ser Texto, números y guiones medios',
        ]);

        //VALIDAR QUE NOS SEA UN GERENTE
        if (Auth::user()->permiso_id != 3) {
            
            //VALIDACIONES PARA SABER QUE TENGA O NO STOCK EN SU ALMACEN
            if ($this->almac->stock == 0) {
                $this->mount();
    
                Alert::error('Error', "No puede realizar el traspaso debido a que no cuenta con stock de este producto");
    
                return redirect()->route('almacenes');
            } elseif ($this->cantidad > $this->almac->stock) {
                $this->mount();
    
                Alert::error('Error', "No puede realizar el traspaso debido a que no cuenta con stock suficiente de este producto");
    
                return redirect()->route('almacenes');
            } else {
    
                $usersAdmins = User::where('permiso_id', 1)->get();
                
                DB::transaction(function () {

                    //OBTENER UN FOLIO DE MANERA ALEATORIA
                    $this->isFolio = Str::upper(Str::random(3)) .'-'. rand(99, 999);
    
                    //INSERTAR EL FOLIO OBTENIDO A LA TABLA folios MEDIANTE EL MODELO FOLIO
                    Folio::create([
                        'folio' => $this->isFolio,
                        'motivo' => $this->motivo,
                        'pdf' => 'Por Definir',
                        'isentrada_issalida' => 'Traspaso',
                    ]);
    
                    //OBTENER EL ULTIMO REGISTRO INGRESADO EN LA TABLA folios
                    $this->ultFoId = Folio::latest('id')->first();
    
                    //INSERTAR TODA LA INFORMACIÓN RECIBIDA EN LA TABLA folios_historials MEDIANTE EL MODELO FOLIOSHISTORIAL
                    FoliosHistorial::create([
                        'estacion_producto_id' => $this->almac->id,
                        'estacion_destino_id' => $this->estacion,
                        'folio_id' => $this->ultFoId->id,
                        'observacion' => $this->observacion,
                        'cantidad' => $this->cantidad,
                        'status' => 'Solicitado',
                    ]);
                });

                //OBTENER EL ULTIMO REGISTRO INGRESADO EN LA TABLA folios_historials
                $this->foHisto = FoliosHistorial::latest('id')->first();

                //*UTILIZAR SI EL $joinFolios SIGUIENTE FALLA EN ALGÚN MOMENTO*
                // $joinFolios = DB::select('select ep.id, fh.cantidad, u.name, ep.estacion_id, ep.supervisor_id, e.titulo_estacion, p2.titulo_producto, p2.unidad, fh.observacion
                //                                     from estacion_producto ep, estacions e, productos p2, folios f, folios_historials fh, users u 
                //                                     where (ep.supervisor_id = e.supervisor_id or ep.estacion_id = e.id) and e.supervisor_id = u.id and fh.estacion_destino_id = e.id
                //                                     and ep.producto_id = p2.id and fh.estacion_producto_id = ep.id  and fh.folio_id = f.id and ep.flag_trash = 0 and f.folio = "'.$this->isFolio.'"');

                //QUERY PARA OBTENER TODOS LOS DATOS DE LAS TABLAS NECESARIOS PARA EL PDF
                $joinFolios = FoliosHistorial::crossJoin('productos as p')
                                            ->crossJoin('folios as f')
                                            ->crossJoin('estacion_producto as ep')
                                            ->whereColumn('folios_historials.estacion_producto_id', 'ep.id')
                                            ->whereColumn('ep.producto_id', 'p.id')
                                            ->whereColumn('folios_historials.folio_id', 'f.id')
                                            ->where('ep.flag_trash', 0)
                                            ->whereRaw('f.folio = "'.$this->isFolio.'"')
                                            ->select('folios_historials.id', 'folios_historials.cantidad', 'p.name', 'p.unidad', 'folios_historials.observacion')
                                            ->get();
    
                //LLAMADA AL METODO PARA GENERAR EL PDF PASANDO LOS CAMPOS(FOLIO GENERADO, QUERY, MOTIVO INGRESADO, ESTACIÓN INGRESADA)
                $this->GeneratePDF($this->isFolio, $joinFolios, $this->motivo, $this->estacion);
    
               // DB::table('folios')->where('folio', $this->isFolio)->update(['pdf' => $this->nombrePDF]);
    
               //UNA VEZ CONCLUIDO EL METODO ANTERIOR (GeneratePDF) REGRESA Y ACTUALIZA LA TABLA folios INGRESANDO EL NOMBRE DEL PDF GENERADO EN EL METODO
                $this->ultFoId->forceFill([
                    'pdf' => $this->nombrePDF,
                ])->save();
    
                //LLAMADA AL TRAIT DE NOTIFICACIONES PASANDO LOS CAMPOS("quien recibe la notificacion", new "nombre de archivo de notificacion"("modelo de donde sacara los campos para enviar la notificacion"))
                Notification::send($usersAdmins, new NotifiNewAlmacenGerente($this->ultFoId));
    
                //LLAMADA AL MOUNT
                $this->mount();
    
                //LLAMADA AL TRAIT DE SWEET ALERT PARA MOSTRAR EL ALERT EN PANTALLA PARA FINALIZAR EL TRASPASO
                Alert::success('Traspaso Solicitado', "El Traspaso para el producto". ' '.$this->almac->producto->titulo_producto. ' '. "ha sido solicitado");
    
                //REDIRECCIONAR A LA PAGINA DE ALMACEN
                //return redirect()->route('almacenes');
				return redirect(request()->header('Referer'));
            }
        }
    }

    //METODO PARA GENERAR PDFS 
    public function GeneratePDF($esunFolio, $foliosHisto, $motivoEs, $estacionEs)
    {
        $fecha = now()->format('d-m-Y');
        $supervisor = Auth::user()->name;

        //OBTENER LA ESTACIÓN
        $isEsta = Estacion::where('id', $estacionEs)->first();

        //VALIDACIONES PARA SABER QUIEN ESTA GENERANDO EL PDF Y ARMAR EL NOMBRE DEL PDF
        //SI EL USUARIO ES SUPERVISOR
        if (Auth::user()->permiso_id == 2) {
            $this->nombrePDF = $fecha .'_'. $esunFolio .'_'. $supervisor .'_'. rand(10, 100000) .'.pdf';

            $solicitadoPorS = Auth::user()->name;
        //SI EL USUARIO ES QUIEN SEA MENOS SUPERVISOR NI GERENTE
        } elseif (Auth::user()->permiso_id != 2 && Auth::user()->permiso_id != 3) {
            $this->nombrePDF = $fecha .'_'. $esunFolio .'_'. rand(10, 100000) .'.pdf';

            $solicitadoPorS = $isEsta->supervisor->name;
        }

        //ARRAY DE VARIABLES CON LOS DATOS CORRESPONDIENTES PARA INGRESAR EN EL PDF
        $data = [
            'fechaEntrada' => $fecha,
            'foliosPedidos' => $foliosHisto,
            'folioEntrada' => $esunFolio,
            'solicitadoPor' => $solicitadoPorS,
            'solicitaEsta' => $isEsta->name,
            'elMotivo' => $motivoEs,
        ];
           
        //LLAMADA AL TRAIT PDF PASANDO LOS CAMPOS("vista blade con la estructura pdf", "array de datos que se usaran en la vista blade")
        $cont = Pdf::loadView('livewire.almacenes.almacen-traspaso-pdf', $data)->output();

        //LLAMADA AL TRAIT STORAGE PARA GUARDAR EL PDF RECIEN CREADO PASANDO LOS CAMPOS("carpeta donde se guardara", "pdf generado")
        Storage::disk('public')->put('entradas-salidas-pdfs/'.$this->nombrePDF, $cont);
    }
    public function render()
    {
         //VARIABLE PARA ITERAR TODAS LAS ESTACIONES QUE VE UN SUPERVISOR
         $this->allSuperStation = Estacion::where('supervisor_id', Auth::user()->id)->where('status', 'Activo')->get();

         //VARIABLE PARA ITERAR TODAS LAS ESTACIÓNES
         $this->allStation = Estacion::where('status', 'Activo')->get();
        return view('livewire.almacenes.almacen-edit');
    }
}
