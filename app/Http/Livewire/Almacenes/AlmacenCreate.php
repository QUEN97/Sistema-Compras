<?php

namespace App\Http\Livewire\Almacenes;

use Livewire\Component;
use App\Models\EstacionProducto;
use App\Models\Producto;
use App\Models\Estacion;
use App\Models\Folio;
use App\Models\User;
use App\Models\FoliosHistorial;
use App\Models\ArchivosFoHisto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Notifications\NotifiNewAlmacenGerente;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailNewAlmacenGerente;
use App\Models\Categoria;
use Illuminate\Support\Facades\Notification;

class AlmacenCreate extends Component
{
    use WithFileUploads;

    public $newgAlmacen;
    public $allSuperStation, $superAlma, $remision, $condiEquipo, $viewCondi;
    public $categoria, $categorias;
    public $producto, $status, $stock, $estacion, $supervisor, $motivo, $observacion, $isEntraoSali, $isEstaSuper, $isFolio, $ultFoId;
    public $inputs = [];
    public $i = 1;

    //FUNCIÓN (propio de livewire) PARA INICIALIZAR EL MODAL OCULTO
    public function mount()
    {
        $this->newgAlmacen = false;
    }

    //FUNCIÓN PARA LEVANTAR EL MODAL A LA VISTA
    public function showModalFormAlmacen(){
        $this->newgAlmacen=true;
    }

    //FUNCIÓN PARA AGREGAR UN INPUT
    public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs ,$i);
    }
 
    //FUNCIÓN PARA REMOVER UN INPUT
    public function remove($i, $pr)
    {
        unset($this->inputs[$i]);
        unset($this->producto[$pr]);
        unset($this->stock[$pr]);
        unset($this->estacion[$pr]);
        unset($this->observacion[$pr]);
    }

    //FUNCIÓN PARA AGREGAR UN NUEVO PRODUCTO A ALMACEN
    public function addAlmacen()
    {
        //VALIDACIÓN PARA USUARIOS QUE NO SEAN SUPERVISORES NI GERENTES
        if (Auth::user()->permiso_id != 2 && Auth::user()->permiso_id != 3) {

            //VALIDACIÓN PARA SABER SI ESTA EL CAMPO DE ESTACIÓNES O DE SUPERVISORES
            if ($this->allSuperStation != null) {
                if ($this->viewCondi != null) {
                    $this->validate([
                        'estacion' => ['required', 'not_in:0'],
                        'stock.1' => ['required', 'integer', 'numeric', 'min:0'],
                        'motivo' => ['required', 'string', 'max:100', 'regex:/[a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/'],
                        'producto.1' => ['required', 'not_in:0'],
                        'isEntraoSali' => ['required', 'not_in:0'],
                        'remision.1' => 'required|max:5024|file|mimetypes:application/pdf',
                        'condiEquipo.1' => 'required|max:5024|file|mimetypes:application/pdf',
                        'remision.*' => 'required|max:5024|file|mimetypes:application/pdf',
                        'condiEquipo.*' => 'required|max:5024|file|mimetypes:application/pdf',
                        'observacion.1' => ['required', 'not_in:0', 'regex:/[a-zA-Z-0-9\?:.,ñÑáéíóúÁÉÍÓÚ]+$/'],
                        'observacion.*' => ['required', 'not_in:0', 'regex:/[a-zA-Z-0-9\?:.,ñÑáéíóúÁÉÍÓÚ]+$/'],
                        'stock.*' => ['required', 'integer', 'numeric', 'min:0'],
                        'producto.*' => ['required', 'not_in:0'],
                    ],[
                        'estacion.required' => 'El campo Estación es obligatorio',
                        'isEntraoSali.required' => 'Es obligatorio seleccionar una opción',
                        'remision.1.required' => 'Es obligatorio subir un archivo PDF',
                        'remision.1.max' => 'El PDF no debe ser mayor a 5 MB',
                        'remision.1.mimetypes' => 'El archivo debe ser un formato PDF',
                        'condiEquipo.required' => 'Es obligatorio subir un archivo PDF',
                        'condiEquipo.max' => 'El PDF no debe ser mayor a 5 MB',
                        'condiEquipo.mimetypes' => 'El archivo debe ser un formato PDF',
                        'remision.*.required' => 'Es obligatorio subir un archivo PDF',
                        'remision.*.max' => 'El PDF no debe ser mayor a 5 MB',
                        'remision.*.mimetypes' => 'El archivo debe ser un formato PDF',
                        'condiEquipo.*.required' => 'Es obligatorio subir un archivo PDF',
                        'condiEquipo.*.max' => 'El PDF no debe ser mayor a 5 MB',
                        'condiEquipo.*.mimetypes' => 'El archivo debe ser un formato PDF',
                        'stock.*.required' => 'El Campo Cantidad es obligatorio',
                        'producto.*.required' => 'El Campo Producto es obligatorio',
                        'producto.1.required' => 'El Campo Producto es obligatorio',
                        'stock.*.integer' => 'El campo Cantidad debe ser un número',
                        'stock.*.numeric' => 'El campo Cantidad debe ser un número',
                        'stock.1.integer' => 'El campo Cantidad debe ser un número',
                        'stock.1.numeric' => 'El campo Cantidad debe ser un número',
                        'observacion.1.required' => 'El Campo Observaciones es obligatorio',
                        'observacion.1.regex' => 'El campo Observaciones solo debe ser Texto, números y guiones medios',
                        'observacion.*.required' => 'El Campo Observaciones es obligatorio',
                        'observacion.*.regex' => 'El campo Observacines solo debe ser Texto, números y guiones medios',
                        'motivo.required' => 'El Campo Motivo es obligatorio',
                        'motivo.string' => 'El Campo Motivo deb ser Texto',
                        'motivo.max' => 'El campo Motivo no debe ser mayor a 100 carateres',
                        'motivo.regex' => 'El campo Motivo solo debe ser Texto',
                    ]);
                }
                $this->validate([
                    'estacion' => ['required', 'not_in:0'],
                    'stock.1' => ['required', 'integer', 'numeric', 'min:0'],
                    'motivo' => ['required', 'string', 'max:100', 'regex:/[a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/'],
                    'producto.1' => ['required', 'not_in:0'],
                    'isEntraoSali' => ['required', 'not_in:0'],
                    'remision.1' => 'required|max:5024|file|mimetypes:application/pdf',
                    'remision.*' => 'required|max:5024|file|mimetypes:application/pdf',
                    'observacion.1' => ['required', 'not_in:0', 'regex:/[a-zA-Z-0-9\?:.,ñÑáéíóúÁÉÍÓÚ]+$/'],
                    'observacion.*' => ['required', 'not_in:0', 'regex:/[a-zA-Z-0-9\?:.,ñÑáéíóúÁÉÍÓÚ]+$/'],
                    'stock.*' => ['required', 'integer', 'numeric', 'min:0'],
                    'producto.*' => ['required', 'not_in:0'],
                ],[
                    'estacion.required' => 'El campo Estación es obligatorio',
                    'isEntraoSali.required' => 'Es obligatorio seleccionar una opción',
                    'remision.1.required' => 'Es obligatorio subir un archivo PDF',
                    'remision.1.max' => 'El PDF no debe ser mayor a 5 MB',
                    'remision.1.mimetypes' => 'El archivo debe ser un formato PDF',
                    'remision.*.required' => 'Es obligatorio subir un archivo PDF',
                    'remision.*.max' => 'El PDF no debe ser mayor a 5 MB',
                    'remision.*.mimetypes' => 'El archivo debe ser un formato PDF',
                    'stock.*.required' => 'El Campo Cantidad es obligatorio',
                    'producto.*.required' => 'El Campo Producto es obligatorio',
                    'producto.1.required' => 'El Campo Producto es obligatorio',
                    'stock.*.integer' => 'El campo Cantidad debe ser un número',
                    'stock.*.numeric' => 'El campo Cantidad debe ser un número',
                    'stock.1.integer' => 'El campo Cantidad debe ser un número',
                    'stock.1.numeric' => 'El campo Cantidad debe ser un número',
                    'observacion.1.required' => 'El Campo Observaciones es obligatorio',
                    'observacion.1.regex' => 'El campo Observaciones solo debe ser Texto, números y guiones medios',
                    'observacion.*.required' => 'El Campo Observaciones es obligatorio',
                    'observacion.*.regex' => 'El campo Observacines solo debe ser Texto, números y guiones medios',
                    'motivo.required' => 'El Campo Motivo es obligatorio',
                    'motivo.string' => 'El Campo Motivo deb ser Texto',
                    'motivo.max' => 'El campo Motivo no debe ser mayor a 100 carateres',
                    'motivo.regex' => 'El campo Motivo solo debe ser Texto',
                ]);
            } elseif ($this->superAlma != null) {
                if ($this->viewCondi != null) {
                    $this->validate([
                        'supervisor' => ['required', 'not_in:0'],
                        'stock.1' => ['required', 'integer', 'numeric', 'min:0'],
                        'motivo' => ['required', 'string', 'max:100', 'regex:/[a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/'],
                        'producto.1' => ['required', 'not_in:0'],
                        'isEntraoSali' => ['required', 'not_in:0'],
                        'remision.1' => 'required|max:5024|file|mimetypes:application/pdf',
                        'condiEquipo.1' => 'required|max:5024|file|mimetypes:application/pdf',
                        'remision.*' => 'required|max:5024|file|mimetypes:application/pdf',
                        'condiEquipo.*' => 'required|max:5024|file|mimetypes:application/pdf',
                        'observacion.1' => ['required', 'not_in:0', 'regex:/[a-zA-Z-0-9\?:.,ñÑáéíóúÁÉÍÓÚ]+$/'],
                        'observacion.*' => ['required', 'not_in:0', 'regex:/[a-zA-Z-0-9\?:.,ñÑáéíóúÁÉÍÓÚ]+$/'],
                        'stock.*' => ['required', 'integer', 'numeric', 'min:0'],
                        'producto.*' => ['required', 'not_in:0'],
                    ],[
                        'supervisor.required' => 'El campo Estación es obligatorio',
                        'isEntraoSali.required' => 'Es obligatorio seleccionar una opción',
                        'remision.1.required' => 'Es obligatorio subir un archivo PDF',
                        'remision.1.max' => 'El PDF no debe ser mayor a 5 MB',
                        'remision.1.mimetypes' => 'El archivo debe ser un formato PDF',
                        'condiEquipo.1.required' => 'Es obligatorio subir un archivo PDF',
                        'condiEquipo.1.max' => 'El PDF no debe ser mayor a 5 MB',
                        'condiEquipo.1.mimetypes' => 'El archivo debe ser un formato PDF',
                        'remision.*.required' => 'Es obligatorio subir un archivo PDF',
                        'remision.*.max' => 'El PDF no debe ser mayor a 5 MB',
                        'remision.*.mimetypes' => 'El archivo debe ser un formato PDF',
                        'condiEquipo.*.required' => 'Es obligatorio subir un archivo PDF',
                        'condiEquipo.*.max' => 'El PDF no debe ser mayor a 5 MB',
                        'condiEquipo.*.mimetypes' => 'El archivo debe ser un formato PDF',
                        'stock.*.required' => 'El Campo Cantidad es obligatorio',
                        'producto.*.required' => 'El Campo Producto es obligatorio',
                        'producto.1.required' => 'El Campo Producto es obligatorio',
                        'stock.*.integer' => 'El campo Cantidad debe ser un número',
                        'stock.*.numeric' => 'El campo Cantidad debe ser un número',
                        'stock.1.integer' => 'El campo Cantidad debe ser un número',
                        'stock.1.numeric' => 'El campo Cantidad debe ser un número',
                        'observacion.1.required' => 'El Campo Observaciones es obligatorio',
                        'observacion.1.regex' => 'El campo Observaciones solo debe ser Texto, números y guiones medios',
                        'observacion.*.required' => 'El Campo Observaciones es obligatorio',
                        'observacion.*.regex' => 'El campo Observacines solo debe ser Texto, números y guiones medios',
                        'motivo.required' => 'El Campo Motivo es obligatorio',
                        'motivo.string' => 'El Campo Motivo deb ser Texto',
                        'motivo.max' => 'El campo Motivo no debe ser mayor a 100 carateres',
                        'motivo.regex' => 'El campo Motivo solo debe ser Texto',
                    ]);
                }
                $this->validate([
                    'supervisor' => ['required', 'not_in:0'],
                    'stock.1' => ['required', 'integer', 'numeric', 'min:0'],
                    'motivo' => ['required', 'string', 'max:100', 'regex:/[a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/'],
                    'producto.1' => ['required', 'not_in:0'],
                    'isEntraoSali' => ['required', 'not_in:0'],
                    'remision.1' => 'required|max:5024|file|mimetypes:application/pdf',
                    'remision.*' => 'required|max:5024|file|mimetypes:application/pdf',
                    'observacion.1' => ['required', 'not_in:0', 'regex:/[a-zA-Z-0-9\?:.,ñÑáéíóúÁÉÍÓÚ]+$/'],
                    'observacion.*' => ['required', 'not_in:0', 'regex:/[a-zA-Z-0-9\?:.,ñÑáéíóúÁÉÍÓÚ]+$/'],
                    'stock.*' => ['required', 'integer', 'numeric', 'min:0'],
                    'producto.*' => ['required', 'not_in:0'],
                ],[
                    'supervisor.required' => 'El campo Estación es obligatorio',
                    'isEntraoSali.required' => 'Es obligatorio seleccionar una opción',
                    'remision.1.required' => 'Es obligatorio subir un archivo PDF',
                    'remision.1.max' => 'El PDF no debe ser mayor a 5 MB',
                    'remision.1.mimetypes' => 'El archivo debe ser un formato PDF',
                    'remision.*.required' => 'Es obligatorio subir un archivo PDF',
                    'remision.*.max' => 'El PDF no debe ser mayor a 5 MB',
                    'remision.*.mimetypes' => 'El archivo debe ser un formato PDF',
                    'stock.*.required' => 'El Campo Cantidad es obligatorio',
                    'producto.*.required' => 'El Campo Producto es obligatorio',
                    'producto.1.required' => 'El Campo Producto es obligatorio',
                    'stock.*.integer' => 'El campo Cantidad debe ser un número',
                    'stock.*.numeric' => 'El campo Cantidad debe ser un número',
                    'stock.1.integer' => 'El campo Cantidad debe ser un número',
                    'stock.1.numeric' => 'El campo Cantidad debe ser un número',
                    'observacion.1.required' => 'El Campo Observaciones es obligatorio',
                    'observacion.1.regex' => 'El campo Observaciones solo debe ser Texto, números y guiones medios',
                    'observacion.*.required' => 'El Campo Observaciones es obligatorio',
                    'observacion.*.regex' => 'El campo Observacines solo debe ser Texto, números y guiones medios',
                    'motivo.required' => 'El Campo Motivo es obligatorio',
                    'motivo.string' => 'El Campo Motivo deb ser Texto',
                    'motivo.max' => 'El campo Motivo no debe ser mayor a 100 carateres',
                    'motivo.regex' => 'El campo Motivo solo debe ser Texto',
                ]);
            } else {
                if ($this->viewCondi != null) {
                    $this->validate([
                        'stock.1' => ['required', 'integer', 'numeric', 'min:0'],
                        'motivo' => ['required', 'string', 'max:100', 'regex:/[a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/'],
                        'producto.1' => ['required', 'not_in:0'],
                        'isEntraoSali' => ['required', 'not_in:0'],
                        'remision.1' => 'required|max:5024|file|mimetypes:application/pdf',
                        'condiEquipo.1' => 'required|max:5024|file|mimetypes:application/pdf',
                        'remision.*' => 'required|max:5024|file|mimetypes:application/pdf',
                        'condiEquipo.*' => 'required|max:5024|file|mimetypes:application/pdf',
                        'observacion.1' => ['required', 'not_in:0', 'regex:/[a-zA-Z-0-9\?:.,ñÑáéíóúÁÉÍÓÚ]+$/'],
                        'observacion.*' => ['required', 'not_in:0', 'regex:/[a-zA-Z-0-9\?:.,ñÑáéíóúÁÉÍÓÚ]+$/'],
                        'stock.*' => ['required', 'integer', 'numeric', 'min:0'],
                        'producto.*' => ['required', 'not_in:0'],
                    ],[
                        'isEntraoSali.required' => 'Es obligatorio seleccionar una opción',
                        'remision.1.required' => 'Es obligatorio subir un archivo PDF',
                        'remision.1.max' => 'El PDF no debe ser mayor a 5 MB',
                        'remision.1.mimetypes' => 'El archivo debe ser un formato PDF',
                        'condiEquipo.1.required' => 'Es obligatorio subir un archivo PDF',
                        'condiEquipo.1.max' => 'El PDF no debe ser mayor a 5 MB',
                        'condiEquipo.1.mimetypes' => 'El archivo debe ser un formato PDF',
                        'remision.*.required' => 'Es obligatorio subir un archivo PDF',
                        'remision.*.max' => 'El PDF no debe ser mayor a 5 MB',
                        'remision.*.mimetypes' => 'El archivo debe ser un formato PDF',
                        'condiEquipo.*.required' => 'Es obligatorio subir un archivo PDF',
                        'condiEquipo.*.max' => 'El PDF no debe ser mayor a 5 MB',
                        'condiEquipo.*.mimetypes' => 'El archivo debe ser un formato PDF',
                        'stock.*.required' => 'El Campo Cantidad es obligatorio',
                        'producto.*.required' => 'El Campo Producto es obligatorio',
                        'producto.1.required' => 'El Campo Producto es obligatorio',
                        'stock.*.integer' => 'El campo Cantidad debe ser un número',
                        'stock.*.numeric' => 'El campo Cantidad debe ser un número',
                        'stock.1.integer' => 'El campo Cantidad debe ser un número',
                        'stock.1.numeric' => 'El campo Cantidad debe ser un número',
                        'observacion.1.required' => 'El Campo Observaciones es obligatorio',
                        'observacion.1.regex' => 'El campo Observaciones solo debe ser Texto, números y guiones medios',
                        'observacion.*.required' => 'El Campo Observaciones es obligatorio',
                        'observacion.*.regex' => 'El campo Observacines solo debe ser Texto, números y guiones medios',
                        'motivo.required' => 'El Campo Motivo es obligatorio',
                        'motivo.string' => 'El Campo Motivo deb ser Texto',
                        'motivo.max' => 'El campo Motivo no debe ser mayor a 100 carateres',
                        'motivo.regex' => 'El campo Motivo solo debe ser Texto',
                    ]);
                }
                $this->validate( [
                    'stock.1' => ['required', 'integer', 'numeric', 'min:0'],
                    'motivo' => ['required', 'string', 'max:100', 'regex:/[a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/'],
                    'producto.1' => ['required', 'not_in:0'],
                    'isEntraoSali' => ['required', 'not_in:0'],
                    'isEstaSuper' => ['required', 'not_in:0'],
                    'remision.1' => 'required|max:5024|file|mimetypes:application/pdf',
                    'remision.*' => 'required|max:5024|file|mimetypes:application/pdf',
                    'observacion.1' => ['required', 'not_in:0', 'regex:/[a-zA-Z-0-9\?:.,ñÑáéíóúÁÉÍÓÚ]+$/'],
                    'observacion.*' => ['required', 'not_in:0', 'regex:/[a-zA-Z-0-9\?:.,ñÑáéíóúÁÉÍÓÚ]+$/'],
                    'stock.*' => ['required', 'integer', 'numeric', 'min:0'],
                    'producto.*' => ['required', 'not_in:0'],
                ],
                [
                    'isEntraoSali.required' => 'Es obligatorio seleccionar una opción',
                    'isEstaSuper.required' => 'Es obligatorio seleccionar una opción',
                    'remision.1.required' => 'Es obligatorio subir un archivo PDF',
                    'remision.1.max' => 'El PDF no debe ser mayor a 5 MB',
                    'remision.1.mimetypes' => 'El archivo debe ser un formato PDF',
                    'remision.*.required' => 'Es obligatorio subir un archivo PDF',
                    'remision.*.max' => 'El PDF no debe ser mayor a 5 MB',
                    'remision.*.mimetypes' => 'El archivo debe ser un formato PDF',
                    'stock.*.required' => 'El campo Stock es obligatorio',
                    'producto.*.required' => 'El campo Producto es obligatorio',
                    'producto.1.required' => 'El campo Producto es obligatorio',
                    'stock.*.integer' => 'El campo Stock debe ser un número',
                    'stock.*.numeric' => 'El campo Stock debe ser un número',
                    'stock.1.integer' => 'El campo Stock debe ser un número',
                    'stock.1.numeric' => 'El campo Stock debe ser un número',
                    'observacion.1.required' => 'El campo Observaciones es obligatorio',
                    'observacion.1.regex' => 'El campo Observaciones solo debe ser Texto, números y guiones medios',
                    'observacion.*.required' => 'El campo Observaciones es obligatorio',
                    'observacion.*.regex' => 'El campo Observacines solo debe ser Texto, números y guiones medios',
                    'motivo.required' => 'El campo Motivo es obligatorio',
                    'motivo.string' => 'El campo Motivo deb ser Texto',
                    'motivo.max' => 'El campo Motivo no debe ser mayor a 100 carateres',
                    'motivo.regex' => 'El campo Motivo solo debe ser Texto',
                ]);
            }

            //VARIABLE QUE CONTIENE LA ESTACIÓN ASIGNADA AL SUPERVISOR INGRESADO
            $this->estEs = Estacion::where('status', 'Aactivo')->where('supervisor_id', $this->supervisor)->first();

            //VALIDACION PARA SABER SI EL SUPERVISOR ESTA ASIGNADO A UNA ESTACIÓN
            if ($this->estEs == null || empty($this->estEs)) {
                $this->mount();

                Alert::error('Error', "No se le puede asignar Entradas o Salidas a este Supervisor por que no esta asignado a ninguna estacion");

                return redirect()->route('almacenes');
            } else {

                //OBTENER UN FOLIO DE MANERA ALEATORIA
                $this->isFolio = Str::upper(Str::random(3)) .'-'. rand(99, 999);

                //INSERTAR EL FOLIO OBTENIDO A LA TABLA folios MEDIANTE EL MODELO FOLIO
                DB::transaction(function () {
                    return tap(Folio::create([
                        'folio' => $this->isFolio,
                        'motivo' => $this->motivo,
                        'pdf' => 'Por Definir',
                        'isentrada_issalida' => $this->isEntraoSali,
                    ]));
                });

                DB::transaction(function (){

                    //OBTENER EL ULTIMO REGISTRO INGRESADO EN LA TABLA folios
                    $ultFoId = Folio::latest('id')->first();

                    //ITERAR LOS PRODUCTOS QUE SELEECIONO
                    foreach ($this->producto as $key => $value) {

                        //VALIDACIÓN ES EN EL ALMACEN DE UNA ESTACIÓN O EN EL ALMACEN DE UN SUPERVISOR
                        if ($this->isEstaSuper == 'Estacion') {
                            $this->almacen = EstacionProducto::where('flag_trash', 0)
                                        ->where('estacion_id', $this->estacion)
                                        ->where('producto_id', $this->producto[$key])->first();
                        } elseif ($this->isEstaSuper == 'SuperviAlma') {
                            $this->almacen = EstacionProducto::where('flag_trash', 0)
                                        ->where('supervisor_id', $this->supervisor)
                                        ->where('producto_id', $this->producto[$key])->first();
                        }

                        //VALIDAR SI ESE MISMO ALMACEN TIENE STOCK  
                        if (!empty($this->almacen) || $this->almacen != null) {

                            //SI EL ALMACEN TIENE STOCK SE ACTUALIZA EL STATUS DE LA TABLA estacion_producto
                            $this->almacen->forceFill([
                                //'stock' => $this->almacen->stock + $this->stock[$i],
                                'status' => 'Solicitado',
                            ])->save();

                            //SE INSERTA TODA LA INFORMACIÓN INGRESADA EN LA TABLA folios_historials MEDIANTE EL MODELO FOLIOSHISTORIAL
                            FoliosHistorial::create([
                                'estacion_producto_id' => $this->almacen->id,
                                'folio_id' => $ultFoId->id,
                                'observacion' => $this->observacion[$key],
                                'cantidad' => $this->stock[$key],
                                'status' => 'Solicitado',
                            ]);

                            //SE OBTIENE EL ULTIMO REGISTRO RECIEN INGRESADO DE LA TABLA folios_historials
                            $almaExistArch = FoliosHistorial::latest('id')->first();

                            //SE ESTABLECE EL NOMBRE DEL ARHIVO DE REMISION INGRESADO
                            $nombreRemisi = $almaExistArch->id.'_NR_'.now()->format('d-m-Y').'_'.rand(10, 100000).'_'.$this->remision[$key]->getClientOriginalName();

                            //SE GUARDA EL ARCHIVO DE REMISION CON LOS CAMPOS("carpeta donde se guardara", "nombre del archivo", 'public')
                            $this->remision[$key]->storeAs('evidencias-almacen', $nombreRemisi, 'public');

                            //SE INSERTA TODA LA INFORMACIÓN OBTENIDA EN LA TABLA archivos_fo_histos MEDIANTE EL MODELO ARCHIVOSFOHISTO
                            ArchivosFoHisto::create([
                                'folios_historial_id' => $almaExistArch->id,
                                'nombre_remision' => $this->remision[$key]->getClientOriginalName(),
                                'mime_type_remision' => $this->remision[$key]->getMimeType(),
                                'size_remision' => $this->remision[$key]->getSize(),
                                'path_remision' => $nombreRemisi,
                                'flag_trash' => 0,
                            ]);

                            //SE OBTIENE EL ULTIMO REGISTO INGRESADO EN LA TABLA archivos_fo_histos
                            $archiFo = ArchivosFoHisto::latest('id')->first();

                            //SE VALIDA SI LA SOLICITUD ES UNA ENTRADA PARA PODER INGRESAR EL ARCHIVO DE CONDICIONES DEL EQUIPO
                            if ($this->isEntraoSali == 'Entrada') {

                                //SE ESTABLECE EL NOMBRE DEL ARCHIVO DE CONDICIONES DEL EQUIPO INGRESADO
                                $nombreCondi = $almaExistArch->id.'_CE_'.now()->format('d-m-Y').'_'.rand(10, 100000).'_'.$this->condiEquipo[$key]->getClientOriginalName();

                                //SE GUARDA EL ARCHIVO DE CONDICIONES DEL EQUIPO CON LOS CAMPOS("carpeta donde se guardara", "nombre del archivo", 'public')
                                $this->condiEquipo[$key]->storeAs('evidencias-almacen', $nombreCondi, 'public');

                                //SE ACTUALIZA LA TABLA archivos_fo_histos CON LA INFORMACION DEL ARCHIVO CONDICIONES DEL EQUIPO
                                $archiFo->forceFill([
                                    'nombre_condiciones' => $this->condiEquipo[$key]->getClientOriginalName(),
                                    'mime_type_condiciones' => $this->condiEquipo[$key]->getMimeType(),
                                    'size_condiciones' => $this->condiEquipo[$key]->getSize(),
                                    'path_condiciones' => $nombreCondi,
                                ])->save();
                            }
                        } else {
                        //SI EL ALMACEN NO TIENE STOCK

                            //VALIDACION PARA SABER SI ES EL ALMACEN DE UNA ESTACIÓN O EL ALMACEM DE UN SUPERVISOR
                            // SE INSERTA LA INFORMACIÓN INGRESADA EN LA TABLA estacion_producto MEDIANTE EL MODELO ESTACIONPRODUCTO
                            if ($this->isEstaSuper == 'Estacion') {
                                EstacionProducto::create([
                                    'estacion_id' => $this->estacion,
                                    'producto_id' => $this->producto[$key],
                                    'stock' => 0,
                                    'status' => 'Solicitado',
                                    'flag_trash' => 0,
                                ]);
                            } elseif ($this->isEstaSuper == 'SuperviAlma') {
                                EstacionProducto::create([
                                    'supervisor_id' => $this->supervisor,
                                    'producto_id' => $this->producto[$key],
                                    'stock' => 0,
                                    'status' => 'Solicitado',
                                    'flag_trash' => 0,
                                ]);
                            }

                            //SE OBTIENE EL ULTIMO REGISTRO INGRESADO EN LA TABLA estacion_producto
                            $ultId = EstacionProducto::latest('id')->first();

                            //SE INSERTA LA INFORMACIÓN INGRESADA EN LA TABLA folios_historials MEDIANTE EL MODELO FOLIOSHISTORIAL
                            FoliosHistorial::create([
                                'estacion_producto_id' => $ultId->id,
                                'folio_id' => $ultFoId->id,
                                'observacion' => $this->observacion[$key],
                                'cantidad' => $this->stock[$key],
                                'status' => 'Solicitado',
                            ]);

                            //SE OBTIENE EL ULTIMO REGISTRO RECIEN INGRESADO DE LA TABLA folios_historials
                            $almaExistArch = FoliosHistorial::latest('id')->first();

                            //SE ESTABLECE EL NOMBRE DEL ARHIVO DE REMISION INGRESADO
                            $nombreRemisi = $almaExistArch->id.'_NR_'.now()->format('d-m-Y').'_'.rand(10, 100000).'_'.$this->remision[$key]->getClientOriginalName();

                            //SE GUARDA EL ARCHIVO DE REMISION CON LOS CAMPOS("carpeta donde se guardara", "nombre del archivo", 'public')
                            $this->remision[$key]->storeAs('evidencias-almacen', $nombreRemisi, 'public');

                            //SE INSERTA TODA LA INFORMACIÓN OBTENIDA EN LA TABLA archivos_fo_histos MEDIANTE EL MODELO ARCHIVOSFOHISTO
                            ArchivosFoHisto::create([
                                'folios_historial_id' => $almaExistArch->id,
                                'nombre_remision' => $this->remision[$key]->getClientOriginalName(),
                                'mime_type_remision' => $this->remision[$key]->getMimeType(),
                                'size_remision' => $this->remision[$key]->getSize(),
                                'path_remision' => $nombreRemisi,
                                'flag_trash' => 0,
                            ]);

                            //SE OBTIENE EL ULTIMO REGISTO INGRESADO EN LA TABLA archivos_fo_histos
                            $archiFo = ArchivosFoHisto::latest('id')->first();

                            //SE VALIDA SI LA SOLICITUD ES UNA ENTRADA PARA PODER INGRESAR EL ARCHIVO DE CONDICIONES DEL EQUIPO
                            if ($this->isEntraoSali == 'Entrada') {

                                //SE ESTABLECE EL NOMBRE DEL ARCHIVO DE CONDICIONES DEL EQUIPO INGRESADO
                                $nombreCondi = $almaExistArch->id.'_CE_'.now()->format('d-m-Y').'_'.rand(10, 100000).'_'.$this->condiEquipo[$key]->getClientOriginalName();

                                //SE GUARDA EL ARCHIVO DE CONDICIONES DEL EQUIPO CON LOS CAMPOS("carpeta donde se guardara", "nombre del archivo", 'public')
                                $this->condiEquipo[$key]->storeAs('evidencias-almacen', $nombreCondi, 'public');

                                //SE ACTUALIZA LA TABLA archivos_fo_histos CON LA INFORMACION DEL ARCHIVO CONDICIONES DEL EQUIPO
                                $archiFo->forceFill([
                                    'nombre_condiciones' => $this->condiEquipo[$key]->getClientOriginalName(),
                                    'mime_type_condiciones' => $this->condiEquipo[$key]->getMimeType(),
                                    'size_condiciones' => $this->condiEquipo[$key]->getSize(),
                                    'path_condiciones' => $nombreCondi,
                                ])->save();
                            }
                        }
                    }
                });

                //SE VALIDA SI ES EL ALMACEN ES ESTACIÓN O DE UN SUPERVISOR
                if ($this->isEstaSuper == 'Estacion') {

                    //QUERY PARA TRAER TODOS LOS DATOS DEL ALMACEN DE LA ESTACION SEGÚN EL FOLIO DADO PARA EL PDF
                    $joinFolios = DB::table('folios_historials')
                            ->join('folios', 'folios_historials.folio_id', '=', 'folios.id')
                            ->join('estacion_producto', 'folios_historials.estacion_producto_id', '=', 'estacion_producto.id')
                            ->join('productos', 'estacion_producto.producto_id', '=', 'productos.id')
                            ->join('estacions', 'estacion_producto.estacion_id', '=', 'estacions.id')
                            ->select('estacion_producto.id', 'folios_historials.cantidad', 'estacion_producto.estacion_id', 'estacions.name', 'productos.name', 'productos.unidad', 'folios_historials.observacion')
                            ->where('folios.folio', $this->isFolio)
                            ->get();

                } elseif ($this->isEstaSuper == 'SuperviAlma') {

                    //QUERY PARA TRAER TODOS LOS DATOS DEL ALMACEN DEL SUPERVISOR SEGÚN EL FOLIO DADO PARA EL PDF
                    $joinFolios = DB::select('select ep.id, fh.cantidad, u.name, ep.estacion_id, ep.supervisor_id, e.name, p2.name, p2.unidad, fh.observacion
                                                from estacion_producto ep, estacions e, productos p2, folios f, folios_historials fh, users u 
                                                where ep.supervisor_id = e.supervisor_id and e.supervisor_id = u.id 
                                                and ep.producto_id = p2.id and fh.estacion_producto_id = ep.id  and fh.folio_id = f.id and ep.flag_trash = 0 and f.folio = "'.$this->isFolio.'"');
                }

                //LLAMADA AL METODO PARA GENERAR EL PDF PASANDO LOS CAMPOS(FOLIO GENERADO, QUERY, MOTIVO INGRESADO, ALMACEN DE ESTACION O SUPERVISOR)
                $this->GeneratePDF($this->isFolio, $joinFolios, $this->motivo, $this->isEntraoSali);

                //UNA VEZ CONCLUIDO EL METODO ANTERIOR (GeneratePDF) REGRESA Y ACTUALIZA LA TABLA folios INGRESANDO EL NOMBRE DEL PDF GENERADO EN EL METODO
                DB::table('folios')->where('folio', $this->isFolio)->update(['pdf' => $this->nombrePDF]);

                //SE RESETEA LOS INPUTS CREADOS
                $this->inputs = [];

                //LLAMADA A LA FUNCIÓN MOUNT
                $this->mount();

                //LLAMADA AL TRAIT DE SWEET ALERT PARA MOSTRAR EL ALERT EN PANTALLA PARA FINALIZAR EL TRASPASO
                Alert::success('Nuevo Producto', "Se ha enviado la solicitud de entrada a bodega");
                
                //REDIRECCIONAR A LA PAGINA DE ALMACEN
                return redirect()->route('almacenes');

            }

        }elseif (Auth::user()->permiso_id == 2) {
            $this->estacionEs = Estacion::where('status', 'Activo')->where('supervisor_id', Auth::user()->id)->first();

            if ($this->estacionEs == null || empty($this->estacionEs)) {
                $this->mount();

                Alert::error('Error', "No puedes solicitar productos porque aún no te han asignado una estación");

                return redirect()->route('solicitudes');
            } else {

                $usersAdmins = User::where('permiso_id', 1)->get();
                $usersCompras = User::where('permiso_id', 4)->get();

                if ($this->allSuperStation != null) {
                    if ($this->viewCondi != null) {
                        $this->validate([
                            'estacion' => ['required', 'not_in:0'],
                            'stock.1' => ['required', 'integer', 'numeric', 'min:0'],
                            'motivo' => ['required', 'string', 'max:100', 'regex:/[a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/'],
                            'producto.1' => ['required', 'not_in:0'],
                            'isEntraoSali' => ['required', 'not_in:0'],
                            'remision.1' => 'required|max:5024|file|mimetypes:application/pdf',
                            'condiEquipo.1' => 'required|max:5024|file|mimetypes:application/pdf',
                            'remision.*' => 'required|max:5024|file|mimetypes:application/pdf',
                            'condiEquipo.*' => 'required|max:5024|file|mimetypes:application/pdf',
                            'observacion.1' => ['required', 'not_in:0', 'regex:/[a-zA-Z-0-9\?:.,ñÑáéíóúÁÉÍÓÚ]+$/'],
                            'observacion.*' => ['required', 'not_in:0', 'regex:/[a-zA-Z-0-9\?:.,ñÑáéíóúÁÉÍÓÚ]+$/'],
                            'stock.*' => ['required', 'integer', 'numeric', 'min:0'],
                            'producto.*' => ['required', 'not_in:0'],
                        ],[
                            'estacion.required' => 'El campo Estación es obligatorio',
                            'isEntraoSali.required' => 'Es obligatorio seleccionar una opción',
                            'remision.1.required' => 'Es obligatorio subir un archivo PDF',
                            'remision.1.max' => 'El PDF no debe ser mayor a 5 MB',
                            'remision.1.mimetypes' => 'El archivo debe ser un formato PDF',
                            'condiEquipo.required' => 'Es obligatorio subir un archivo PDF',
                            'condiEquipo.max' => 'El PDF no debe ser mayor a 5 MB',
                            'condiEquipo.mimetypes' => 'El archivo debe ser un formato PDF',
                            'remision.*.required' => 'Es obligatorio subir un archivo PDF',
                            'remision.*.max' => 'El PDF no debe ser mayor a 5 MB',
                            'remision.*.mimetypes' => 'El archivo debe ser un formato PDF',
                            'condiEquipo.*.required' => 'Es obligatorio subir un archivo PDF',
                            'condiEquipo.*.max' => 'El PDF no debe ser mayor a 5 MB',
                            'condiEquipo.*.mimetypes' => 'El archivo debe ser un formato PDF',
                            'stock.*.required' => 'El Campo Cantidad es obligatorio',
                            'producto.*.required' => 'El Campo Producto es obligatorio',
                            'producto.1.required' => 'El Campo Producto es obligatorio',
                            'stock.*.integer' => 'El campo Cantidad debe ser un número',
                            'stock.*.numeric' => 'El campo Cantidad debe ser un número',
                            'stock.1.integer' => 'El campo Cantidad debe ser un número',
                            'stock.1.numeric' => 'El campo Cantidad debe ser un número',
                            'observacion.1.required' => 'El Campo Observaciones es obligatorio',
                            'observacion.1.regex' => 'El campo Observaciones solo debe ser Texto, números y guiones medios',
                            'observacion.*.required' => 'El Campo Observaciones es obligatorio',
                            'observacion.*.regex' => 'El campo Observacines solo debe ser Texto, números y guiones medios',
                            'motivo.required' => 'El Campo Motivo es obligatorio',
                            'motivo.string' => 'El Campo Motivo deb ser Texto',
                            'motivo.max' => 'El campo Motivo no debe ser mayor a 100 carateres',
                            'motivo.regex' => 'El campo Motivo solo debe ser Texto y números',
                        ]);
                    }
                    $this->validate([
                        'estacion' => ['required', 'not_in:0'],
                        'stock.1' => ['required', 'integer', 'numeric', 'min:0'],
                        'motivo' => ['required', 'string', 'max:100', 'regex:/[a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/'],
                        'producto.1' => ['required', 'not_in:0'],
                        'isEntraoSali' => ['required', 'not_in:0'],
                        'remision.1' => 'required|max:5024|file|mimetypes:application/pdf',
                        'remision.*' => 'required|max:5024|file|mimetypes:application/pdf',
                        'observacion.1' => ['required', 'not_in:0', 'regex:/[a-zA-Z-0-9\?:.,ñÑáéíóúÁÉÍÓÚ]+$/'],
                        'observacion.*' => ['required', 'not_in:0', 'regex:/[a-zA-Z-0-9\?:.,ñÑáéíóúÁÉÍÓÚ]+$/'],
                        'stock.*' => ['required', 'integer', 'numeric', 'min:0'],
                        'producto.*' => ['required', 'not_in:0'],
                    ],[
                        'estacion.required' => 'El campo Estación es obligatorio',
                        'isEntraoSali.required' => 'Es obligatorio seleccionar una opción',
                        'remision.1.required' => 'Es obligatorio subir un archivo PDF',
                        'remision.1.max' => 'El PDF no debe ser mayor a 5 MB',
                        'remision.1.mimetypes' => 'El archivo debe ser un formato PDF',
                        'remision.*.required' => 'Es obligatorio subir un archivo PDF',
                        'remision.*.max' => 'El PDF no debe ser mayor a 5 MB',
                        'remision.*.mimetypes' => 'El archivo debe ser un formato PDF',
                        'stock.*.required' => 'El Campo Cantidad es obligatorio',
                        'producto.*.required' => 'El Campo Producto es obligatorio',
                        'producto.1.required' => 'El Campo Producto es obligatorio',
                        'stock.*.integer' => 'El campo Cantidad debe ser un número',
                        'stock.*.numeric' => 'El campo Cantidad debe ser un número',
                        'stock.1.integer' => 'El campo Cantidad debe ser un número',
                        'stock.1.numeric' => 'El campo Cantidad debe ser un número',
                        'observacion.1.required' => 'El Campo Observaciones es obligatorio',
                        'observacion.1.regex' => 'El campo Observaciones solo debe ser Texto, números y guiones medios',
                        'observacion.*.required' => 'El Campo Observaciones es obligatorio',
                        'observacion.*.regex' => 'El campo Observacines solo debe ser Texto, números y guiones medios',
                        'motivo.required' => 'El Campo Motivo es obligatorio',
                        'motivo.string' => 'El Campo Motivo deb ser Texto',
                        'motivo.max' => 'El campo Motivo no debe ser mayor a 100 carateres',
                        'motivo.regex' => 'El campo Motivo solo debe ser Texto y números',
                    ]);
                } else {
                    if ($this->viewCondi != null) {
                        $this->validate([
                            'stock.1' => ['required', 'integer', 'numeric', 'min:0'],
                            'motivo' => ['required', 'string', 'max:100', 'regex:/[a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/'],
                            'producto.1' => ['required', 'not_in:0'],
                            'isEntraoSali' => ['required', 'not_in:0'],
                            'remision.1' => 'required|max:5024|file|mimetypes:application/pdf',
                            'condiEquipo.1' => 'required|max:5024|file|mimetypes:application/pdf',
                            'remision.*' => 'required|max:5024|file|mimetypes:application/pdf',
                            'condiEquipo.*' => 'required|max:5024|file|mimetypes:application/pdf',
                            'observacion.1' => ['required', 'not_in:0', 'regex:/[a-zA-Z-0-9\?:.,ñÑáéíóúÁÉÍÓÚ]+$/'],
                            'observacion.*' => ['required', 'not_in:0', 'regex:/[a-zA-Z-0-9\?:.,ñÑáéíóúÁÉÍÓÚ]+$/'],
                            'stock.*' => ['required', 'integer', 'numeric', 'min:0'],
                            'producto.*' => ['required', 'not_in:0'],
                        ],[
                            'isEntraoSali.required' => 'Es obligatorio seleccionar una opción',
                            'remision.1.required' => 'Es obligatorio subir un archivo PDF',
                            'remision.1.max' => 'El PDF no debe ser mayor a 5 MB',
                            'remision.1.mimetypes' => 'El archivo debe ser un formato PDF',
                            'condiEquipo.1.required' => 'Es obligatorio subir un archivo PDF',
                            'condiEquipo.1.max' => 'El PDF no debe ser mayor a 5 MB',
                            'condiEquipo.1.mimetypes' => 'El archivo debe ser un formato PDF',
                            'remision.*.required' => 'Es obligatorio subir un archivo PDF',
                            'remision.*.max' => 'El PDF no debe ser mayor a 5 MB',
                            'remision.*.mimetypes' => 'El archivo debe ser un formato PDF',
                            'condiEquipo.*.required' => 'Es obligatorio subir un archivo PDF',
                            'condiEquipo.*.max' => 'El PDF no debe ser mayor a 5 MB',
                            'condiEquipo.*.mimetypes' => 'El archivo debe ser un formato PDF',
                            'stock.*.required' => 'El Campo Cantidad es obligatorio',
                            'producto.*.required' => 'El Campo Producto es obligatorio',
                            'producto.1.required' => 'El Campo Producto es obligatorio',
                            'stock.*.integer' => 'El campo Cantidad debe ser un número',
                            'stock.*.numeric' => 'El campo Cantidad debe ser un número',
                            'stock.1.integer' => 'El campo Cantidad debe ser un número',
                            'stock.1.numeric' => 'El campo Cantidad debe ser un número',
                            'observacion.1.required' => 'El Campo Observaciones es obligatorio',
                            'observacion.1.regex' => 'El campo Observaciones solo debe ser Texto, números y guiones medios',
                            'observacion.*.required' => 'El Campo Observaciones es obligatorio',
                            'observacion.*.regex' => 'El campo Observacines solo debe ser Texto, números y guiones medios',
                            'motivo.required' => 'El Campo Motivo es obligatorio',
                            'motivo.string' => 'El Campo Motivo deb ser Texto',
                            'motivo.max' => 'El campo Motivo no debe ser mayor a 100 carateres',
                            'motivo.regex' => 'El campo Motivo solo debe ser Texto y números',
                        ]);
                    }
                    $this->validate( [
                        'stock.1' => ['required', 'integer', 'numeric', 'min:0'],
                        'motivo' => ['required', 'string', 'max:100', 'regex:/[a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/'],
                        'producto.1' => ['required', 'not_in:0'],
                        'isEntraoSali' => ['required', 'not_in:0'],
                        'isEstaSuper' => ['required', 'not_in:0'],
                        'remision.1' => 'required|max:5024|file|mimetypes:application/pdf',
                        'remision.*' => 'required|max:5024|file|mimetypes:application/pdf',
                        'observacion.1' => ['required', 'not_in:0', 'regex:/[a-zA-Z-0-9\?:.,ñÑáéíóúÁÉÍÓÚ]+$/'],
                        'observacion.*' => ['required', 'not_in:0', 'regex:/[a-zA-Z-0-9\?:.,ñÑáéíóúÁÉÍÓÚ]+$/'],
                        'stock.*' => ['required', 'integer', 'numeric', 'min:0'],
                        'producto.*' => ['required', 'not_in:0'],
                    ],
                    [
                        'isEntraoSali.required' => 'Es obligatorio seleccionar una opción',
                        'isEstaSuper.required' => 'Es obligatorio seleccionar una opción',
                        'remision.1.required' => 'Es obligatorio subir un archivo PDF',
                        'remision.1.max' => 'El PDF no debe ser mayor a 5 MB',
                        'remision.1.mimetypes' => 'El archivo debe ser un formato PDF',
                        'remision.*.required' => 'Es obligatorio subir un archivo PDF',
                        'remision.*.max' => 'El PDF no debe ser mayor a 5 MB',
                        'remision.*.mimetypes' => 'El archivo debe ser un formato PDF',
                        'stock.*.required' => 'El campo Stock es obligatorio',
                        'producto.*.required' => 'El campo Producto es obligatorio',
                        'producto.1.required' => 'El campo Producto es obligatorio',
                        'stock.*.integer' => 'El campo Stock debe ser un número',
                        'stock.*.numeric' => 'El campo Stock debe ser un número',
                        'stock.1.integer' => 'El campo Stock debe ser un número',
                        'stock.1.numeric' => 'El campo Stock debe ser un número',
                        'observacion.1.required' => 'El campo Observaciones es obligatorio',
                        'observacion.1.regex' => 'El campo Observaciones solo debe ser Texto, números y guiones medios',
                        'observacion.*.required' => 'El campo Observaciones es obligatorio',
                        'observacion.*.regex' => 'El campo Observacines solo debe ser Texto, números y guiones medios',
                        'motivo.required' => 'El campo Motivo es obligatorio',
                        'motivo.string' => 'El campo Motivo deb ser Texto',
                        'motivo.max' => 'El campo Motivo no debe ser mayor a 100 carateres',
                        'motivo.regex' => 'El campo Motivo solo debe ser Texto y números',
                    ]);
                }
                    
                $this->isFolio = Str::upper(Str::random(3)) .'-'. rand(99, 999);

                DB::transaction(function () {
                    return tap(Folio::create([
                        'folio' => $this->isFolio,
                        'motivo' => $this->motivo,
                        'pdf' => 'Por Definir',
                        'isentrada_issalida' => $this->isEntraoSali,
                    ]));
                });

                DB::transaction(function (){

                    $estaName = Estacion::where('status', 'Activo')->where('id', $this->estacion)->first();

                    $ultFoId = Folio::latest('id')->first();

                    foreach ($this->producto as $key => $val) {

                        if ($this->isEstaSuper == 'Estacion') {
                            $this->almacen = EstacionProducto::where('flag_trash', 0)
                                    ->where('estacion_id', $this->estacion)
                                    ->where('producto_id', $this->producto[$key])->first();
                        } elseif ($this->isEstaSuper == 'Mi Almacen') {
                            $this->almacen = EstacionProducto::where('flag_trash', 0)
                                    ->where('supervisor_id', Auth::user()->id)
                                    ->where('producto_id', $this->producto[$key])->first();
                        }
                            
                        if (!empty($this->almacen) || $this->almacen != null) {

                            $this->almacen->forceFill([
                                //'stock' => $this->almacen->stock + $this->stock[$i],
                                'status' => 'Solicitado',
                            ])->save();

                            FoliosHistorial::create([
                                'estacion_producto_id' => $this->almacen->id,
                                'folio_id' => $ultFoId->id,
                                'observacion' => $this->observacion[$key],
                                'cantidad' => $this->stock[$key],
                                'status' => 'Solicitado',
                            ]);

                            $almaExistArch = FoliosHistorial::latest('id')->first();

                            if ($this->isEstaSuper == 'Estacion') {
                                $nombreRemisi = $almaExistArch->id.'_NR_'.now()->format('d-m-Y').'_'.$estaName->name.'_'.rand(10, 100000).'_'.$this->remision[$key]->getClientOriginalName();
                            } elseif ($this->isEstaSuper == 'Mi Almacen') {
                                $nombreRemisi = $almaExistArch->id.'_NR_'.now()->format('d-m-Y').'_'.Auth::user()->name.'_'.rand(10, 100000).'_'.$this->remision[$key]->getClientOriginalName();
                            }

                            $this->remision[$key]->storeAs('evidencias-almacen', $nombreRemisi, 'public');

                            ArchivosFoHisto::create([
                                'folios_historial_id' => $almaExistArch->id,
                                'nombre_remision' => $this->remision[$key]->getClientOriginalName(),
                                'mime_type_remision' => $this->remision[$key]->getMimeType(),
                                'size_remision' => $this->remision[$key]->getSize(),
                                'path_remision' => $nombreRemisi,
                                'flag_trash' => 0,
                            ]);

                            $archiFo = ArchivosFoHisto::latest('id')->first();

                            if ($this->isEntraoSali == 'Entrada') {

                                if ($this->isEstaSuper == 'Estacion') {
                                    $nombreCondi = $almaExistArch->id.'_CE_'.now()->format('d-m-Y').'_'.$estaName->name.'_'.rand(10, 100000).'_'.$this->condiEquipo[$key]->getClientOriginalName();
                                } elseif ($this->isEstaSuper == 'Mi Almacen') {
                                    $nombreCondi = $almaExistArch->id.'_CE_'.now()->format('d-m-Y').'_'.Auth::user()->name.'_'.rand(10, 100000).'_'.$this->condiEquipo[$key]->getClientOriginalName();
                                }
    
                                $this->condiEquipo[$key]->storeAs('evidencias-almacen', $nombreCondi, 'public');
    
                                $archiFo->forceFill([
                                    'nombre_condiciones' => $this->condiEquipo[$key]->getClientOriginalName(),
                                    'mime_type_condiciones' => $this->condiEquipo[$key]->getMimeType(),
                                    'size_condiciones' => $this->condiEquipo[$key]->getSize(),
                                    'path_condiciones' => $nombreCondi,
                                ])->save();
                            }
                        } else {
                            if ($this->isEstaSuper == 'Estacion') {
                                EstacionProducto::create([
                                    'estacion_id' => $this->estacion,
                                    'producto_id' => $this->producto[$key],
                                    'stock' => 0,
                                    'status' => 'Solicitado',
                                    'flag_trash' => 0,
                                ]);
                            } elseif ($this->isEstaSuper == 'Mi Almacen') {
                                EstacionProducto::create([
                                    'supervisor_id' => Auth::user()->id,
                                    'producto_id' => $this->producto[$key],
                                    'stock' => 0,
                                    'status' => 'Solicitado',
                                    'flag_trash' => 0,
                                ]);
                            }

                            $ultId = EstacionProducto::latest('id')->first();

                            FoliosHistorial::create([
                                'estacion_producto_id' => $ultId->id,
                                'folio_id' => $ultFoId->id,
                                'observacion' => $this->observacion[$key],
                                'cantidad' => $this->stock[$key],
                                'status' => 'Solicitado',
                            ]);

                            $almaExistArch = FoliosHistorial::latest('id')->first();

                            if ($this->isEstaSuper == 'Estacion') {
                                $nombreRemisi = $almaExistArch->id.'_NR_'.now()->format('d-m-Y').'_'.$estaName->name.'_'.rand(10, 100000).'_'.$this->remision[$key]->getClientOriginalName();
                            } elseif ($this->isEstaSuper == 'Mi Almacen') {
                                $nombreRemisi = $almaExistArch->id.'_NR_'.now()->format('d-m-Y').'_'.Auth::user()->name.'_'.rand(10, 100000).'_'.$this->remision[$key]->getClientOriginalName();
                            }
                            
                            $this->remision[$key]->storeAs('evidencias-almacen', $nombreRemisi, 'public');

                            ArchivosFoHisto::create([
                                'folios_historial_id' => $almaExistArch->id,
                                'nombre_remision' => $this->remision[$key]->getClientOriginalName(),
                                'mime_type_remision' => $this->remision[$key]->getMimeType(),
                                'size_remision' => $this->remision[$key]->getSize(),
                                'path_remision' => $nombreRemisi,
                                'flag_trash' => 0,
                            ]);

                            $archiFo = ArchivosFoHisto::latest('id')->first();

                            if ($this->isEntraoSali == 'Entrada') {

                                if ($this->isEstaSuper == 'Estacion') {
                                    $nombreCondi = $almaExistArch->id.'_CE_'.now()->format('d-m-Y').'_'.$estaName->name.'_'.rand(10, 100000).'_'.$this->condiEquipo[$key]->getClientOriginalName();
                                } elseif ($this->isEstaSuper == 'Mi Almacen') {
                                    $nombreCondi = $almaExistArch->id.'_CE_'.now()->format('d-m-Y').'_'.Auth::user()->name.'_'.rand(10, 100000).'_'.$this->condiEquipo[$key]->getClientOriginalName();
                                }

                                $this->condiEquipo[$key]->storeAs('evidencias-almacen', $nombreCondi, 'public');

                                $archiFo->forceFill([
                                    'nombre_condiciones' => $this->condiEquipo[$key]->getClientOriginalName(),
                                    'mime_type_condiciones' => $this->condiEquipo[$key]->getMimeType(),
                                    'size_condiciones' => $this->condiEquipo[$key]->getSize(),
                                    'path_condiciones' => $nombreCondi,
                                ])->save();
                            }
                        }
                    }
                });

                if ($this->isEstaSuper == 'Estacion') {
                    $joinFolios = DB::table('folios_historials')
                                    ->join('folios', 'folios_historials.folio_id', '=', 'folios.id')
                                    ->join('estacion_producto', 'folios_historials.estacion_producto_id', '=', 'estacion_producto.id')
                                    ->join('productos', 'estacion_producto.producto_id', '=', 'productos.id')
                                    ->join('estacions', 'estacion_producto.estacion_id', '=', 'estacions.id')
                                    ->select('estacion_producto.id', 'estacion_producto.estacion_id', 'folios_historials.cantidad', 'estacions.name', 'productos.name', 'productos.unidad', 'folios_historials.observacion', 'productos.product_photo_path')
                                    ->where('folios.folio', $this->isFolio)
                                    ->get();

                } elseif ($this->isEstaSuper == 'Mi Almacen') {
                    $joinFolios = DB::select('select ep.id, fh.cantidad, ep.estacion_id, ep.supervisor_id, p2.titulo_producto, p2.unidad, fh.observacion
                                        from estacion_producto ep, estacions e, productos p2, folios f, folios_historials fh
                                        where ep.supervisor_id = e.supervisor_id and ep.producto_id = p2.id and fh.estacion_producto_id = ep.id 
                                        and fh.folio_id = f.id and ep.flag_trash = 0 and f.folio = "'.$this->isFolio.'"');
                }


                $this->GeneratePDF($this->isFolio, $joinFolios, $this->motivo, $this->isEntraoSali);

                DB::table('folios')->where('folio', $this->isFolio)->update(['pdf' => $this->nombrePDF]);


                $this->inputs = [];

                $this->mount();

                Alert::success('Nuevo Producto', "Se ha enviado la solicitud de entrada a bodega");
                
                return redirect()->route('almacenes');
            }
        } elseif (Auth::user()->permiso_id == 3) {
            
            $this->estacion = Estacion::where('status', 'Activo')->where('user_id', Auth::user()->id)->first();

            if ($this->estacion == null || empty($this->estacion)) {

                $this->mount();

                Alert::error('Error', "No puedes ingresar o sacar productos porque aún no te han asignado una estación");

                return redirect()->route('almacenes');
            } else {

                $usersAdmins = User::where('permiso_id', 1)->get();
                $usersCompras = User::where('permiso_id', 4)->get();

                //$zonaGerente= DB::table('user_zona')->where('user_id', Auth::user()->id)->first()->zona_id;
                //$usersSupers = User::where('permiso_id', 2)->join('user_zona as uz','uz.user_id','users.id')->where('uz.zona_id',$zonaGerente)->select('users.*')->get();
				$estacionGerente = DB::table('estacions')->where('user_id', Auth::user()->id)->first();
                $usersSupers = User::find($estacionGerente->supervisor_id);

                if ($this->viewCondi != null) {
                    $this->validate([
                        'stock.1' => ['required', 'integer', 'numeric', 'min:0'],
                        'motivo' => ['required', 'string', 'max:100', 'regex:/[a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/'],
                        'producto.1' => ['required', 'not_in:0'],
                        'isEntraoSali' => ['required', 'not_in:0'],
                        'remision.1' => 'required|max:5024|file|mimetypes:application/pdf',
                        'condiEquipo.1' => 'required|max:5024|file|mimetypes:application/pdf',
                        'remision.*' => 'required|max:5024|file|mimetypes:application/pdf',
                        'condiEquipo.*' => 'required|max:5024|file|mimetypes:application/pdf',
                        'observacion.1' => ['required', 'not_in:0', 'regex:/[a-zA-Z-0-9\?:.,ñÑáéíóúÁÉÍÓÚ]+$/'],
                        'observacion.*' => ['required', 'not_in:0', 'regex:/[a-zA-Z-0-9\?:.,ñÑáéíóúÁÉÍÓÚ]+$/'],
                        'stock.*' => ['required', 'integer', 'numeric', 'min:0'],
                        'producto.*' => ['required', 'not_in:0'],
                    ],[
                        'isEntraoSali.required' => 'Es obligatorio seleccionar una opción',
                        'remision.1.required' => 'Es obligatorio subir un archivo PDF',
                        'remision.1.max' => 'El PDF no debe ser mayor a 5 MB',
                        'remision.1.mimetypes' => 'El archivo debe ser un formato PDF',
                        'condiEquipo.required' => 'Es obligatorio subir un archivo PDF',
                        'condiEquipo.max' => 'El PDF no debe ser mayor a 5 MB',
                        'condiEquipo.mimetypes' => 'El archivo debe ser un formato PDF',
                        'remision.*.required' => 'Es obligatorio subir un archivo PDF',
                        'remision.*.max' => 'El PDF no debe ser mayor a 5 MB',
                        'remision.*.mimetypes' => 'El archivo debe ser un formato PDF',
                        'condiEquipo.*.required' => 'Es obligatorio subir un archivo PDF',
                        'condiEquipo.*.max' => 'El PDF no debe ser mayor a 5 MB',
                        'condiEquipo.*.mimetypes' => 'El archivo debe ser un formato PDF',
                        'stock.*.required' => 'El Campo Cantidad es obligatorio',
                        'producto.*.required' => 'El Campo Producto es obligatorio',
                        'producto.1.required' => 'El Campo Producto es obligatorio',
                        'stock.*.integer' => 'El campo Cantidad debe ser un número',
                        'stock.*.numeric' => 'El campo Cantidad debe ser un número',
                        'stock.1.integer' => 'El campo Cantidad debe ser un número',
                        'stock.1.numeric' => 'El campo Cantidad debe ser un número',
                        'observacion.1.required' => 'El Campo Observaciones es obligatorio',
                        'observacion.1.regex' => 'El campo Observaciones solo debe ser Texto, números y guiones medios',
                        'observacion.*.required' => 'El Campo Observaciones es obligatorio',
                        'observacion.*.regex' => 'El campo Observacines solo debe ser Texto, números y guiones medios',
                        'motivo.required' => 'El Campo Motivo es obligatorio',
                        'motivo.string' => 'El Campo Motivo deb ser Texto',
                        'motivo.max' => 'El campo Motivo no debe ser mayor a 100 carateres',
                        'motivo.regex' => 'El campo Motivo solo debe ser Texto y números',
                    ]);
                } else {
                    $this->validate([
                        'stock.1' => ['required', 'integer', 'numeric', 'min:0'],
                        'motivo' => ['required', 'string', 'max:100', 'regex:/[a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/'],
                        'producto.1' => ['required', 'not_in:0'],
                        'isEntraoSali' => ['required', 'not_in:0'],
                        'remision.1' => 'required|max:5024|file|mimetypes:application/pdf',
                        'remision.*' => 'required|max:5024|file|mimetypes:application/pdf',
                        'observacion.1' => ['required', 'not_in:0', 'regex:/[a-zA-Z-0-9\?:.,ñÑáéíóúÁÉÍÓÚ]+$/'],
                        'observacion.*' => ['required', 'not_in:0', 'regex:/[a-zA-Z-0-9\?:.,ñÑáéíóúÁÉÍÓÚ]+$/'],
                        'stock.*' => ['required', 'integer', 'numeric', 'min:0'],
                        'producto.*' => ['required', 'not_in:0'],
                    ],
                    [
                        'isEntraoSali.required' => 'Es obligatorio seleccionar una opción',
                        'remision.1.required' => 'Es obligatorio subir un archivo PDF',
                        'remision.1.max' => 'El PDF no debe ser mayor a 5 MB',
                        'remision.1.mimetypes' => 'El archivo debe ser un formato PDF',
                        'remision.*.required' => 'Es obligatorio subir un archivo PDF',
                        'remision.*.max' => 'El PDF no debe ser mayor a 5 MB',
                        'remision.*.mimetypes' => 'El archivo debe ser un formato PDF',
                        'stock.*.required' => 'El Campo Cantidad es obligatorio',
                        'producto.*.required' => 'El Campo Producto es obligatorio',
                        'producto.1.required' => 'El Campo Producto es obligatorio',
                        'stock.*.integer' => 'El campo Cantidad debe ser un número',
                        'stock.*.numeric' => 'El campo Cantidad debe ser un número',
                        'stock.1.integer' => 'El campo Cantidad debe ser un número',
                        'stock.1.numeric' => 'El campo Cantidad debe ser un número',
                        'observacion.1.required' => 'El Campo Observaciones es obligatorio',
                        'observacion.1.regex' => 'El campo Observaciones solo debe ser Texto, números y guiones medios',
                        'observacion.*.required' => 'El Campo Observaciones es obligatorio',
                        'observacion.*.regex' => 'El campo Observacines solo debe ser Texto, números y guiones medios',
                        'motivo.required' => 'El Campo Motivo es obligatorio',
                        'motivo.string' => 'El Campo Motivo deb ser Texto',
                        'motivo.max' => 'El campo Motivo no debe ser mayor a 100 carateres',
                        'motivo.regex' => 'El campo Motivo solo debe ser Texto y números',
                    ]);
                }

                $this->isFolio = Str::upper(Str::random(3)) .'-'. rand(99, 999);

                DB::transaction(function () {
                    return tap(Folio::create([
                        'folio' => $this->isFolio,
                        'motivo' => $this->motivo,
                        'pdf' => 'por definir',
                        'isentrada_issalida' => $this->isEntraoSali,
                    ]));
                });
                    
                DB::transaction(function (){

                    $this->ultFoId = Folio::latest('id')->first();
    
                    foreach ($this->producto as $key => $val) {
                        $this->almacen = EstacionProducto::where('flag_trash', 0)
                                        ->where('estacion_id', $this->estacion->id)
                                        ->where('producto_id', $this->producto[$key])->first();
                            
                        if (!empty($this->almacen) || $this->almacen != null) {
    
                            $this->almacen->forceFill([
                                //'stock' => $this->almacen->stock + $this->stock[$i],
                                'status' => 'Solicitado',
                            ])->save();
    
                            FoliosHistorial::create([
                                'estacion_producto_id' => $this->almacen->id,
                                'folio_id' => $this->ultFoId->id,
                                'observacion' => $this->observacion[$key],
                                'cantidad' => $this->stock[$key],
                                'status' => 'Solicitado',
                            ]);

                            $almaExistArch = FoliosHistorial::latest('id')->first();

                            $nombreRemisi = $almaExistArch->id.'_NR_'.now()->format('d-m-Y').'_'.$this->estacion->name.'_'.rand(10, 100000).'_'.$this->remision[$key]->getClientOriginalName();

                            $this->remision[$key]->storeAs('evidencias-almacen', $nombreRemisi, 'public');

                            ArchivosFoHisto::create([
                                'folios_historial_id' => $almaExistArch->id,
                                'nombre_remision' => $this->remision[$key]->getClientOriginalName(),
                                'mime_type_remision' => $this->remision[$key]->getMimeType(),
                                'size_remision' => $this->remision[$key]->getSize(),
                                'path_remision' => $nombreRemisi,
                                'flag_trash' => 0,
                            ]);

                            $archiFo = ArchivosFoHisto::latest('id')->first();

                            if ($this->isEntraoSali == 'Entrada') {

                                $nombreCondi = $almaExistArch->id.'_CE_'.now()->format('d-m-Y').'_'.$this->estacion->name.'_'.rand(10, 100000).'_'.$this->condiEquipo[$key]->getClientOriginalName();
    
                                $this->condiEquipo[$key]->storeAs('evidencias-almacen', $nombreCondi, 'public');
    
                                $archiFo->forceFill([
                                    'nombre_condiciones' => $this->condiEquipo[$key]->getClientOriginalName(),
                                    'mime_type_condiciones' => $this->condiEquipo[$key]->getMimeType(),
                                    'size_condiciones' => $this->condiEquipo[$key]->getSize(),
                                    'path_condiciones' => $nombreCondi,
                                ])->save();
                            }
                        } else {
                            EstacionProducto::create([
                                'estacion_id' => $this->estacion->id,
                                'producto_id' => $this->producto[$key],
                                'stock' => 0,
                                'status' => 'Solicitado',
                                'flag_trash' => 0,
                            ]);
    
                            $ultId = EstacionProducto::latest('id')->first();
    
                            FoliosHistorial::create([
                                'estacion_producto_id' => $ultId->id,
                                'folio_id' => $this->ultFoId->id,
                                'observacion' => $this->observacion[$key],
                                'cantidad' => $this->stock[$key],
                                'status' => 'Solicitado',
                            ]);

                            $almaExistArch = FoliosHistorial::latest('id')->first();

                            $nombreRemisi = $almaExistArch->id.'_NR_'.now()->format('d-m-Y').'_'.$this->estacion->name.'_'.rand(10, 100000).'_'.$this->remision[$key]->getClientOriginalName();

                            $this->remision[$key]->storeAs('evidencias-almacen', $nombreRemisi, 'public');

                            ArchivosFoHisto::create([
                                'folios_historial_id' => $almaExistArch->id,
                                'nombre_remision' => $this->remision[$key]->getClientOriginalName(),
                                'mime_type_remision' => $this->remision[$key]->getMimeType(),
                                'size_remision' => $this->remision[$key]->getSize(),
                                'path_remision' => $nombreRemisi,
                                'flag_trash' => 0,
                            ]);

                            $archiFo = ArchivosFoHisto::latest('id')->first();

                            if ($this->isEntraoSali == 'Entrada') {

                                $nombreCondi = $almaExistArch->id.'_CE_'.now()->format('d-m-Y').'_'.$this->estacion->name.'_'.rand(10, 100000).'_'.$this->condiEquipo[$key]->getClientOriginalName();

                                $this->condiEquipo[$key]->storeAs('evidencias-almacen', $nombreCondi, 'public');

                                $archiFo->forceFill([
                                    'nombre_condiciones' => $this->condiEquipo[$key]->getClientOriginalName(),
                                    'mime_type_condiciones' => $this->condiEquipo[$key]->getMimeType(),
                                    'size_condiciones' => $this->condiEquipo[$key]->getSize(),
                                    'path_condiciones' => $nombreCondi,
                                ])->save();
                            }
                        }
                    }
                });
    
                $joinFolios = DB::table('folios_historials')
                        ->join('folios', 'folios_historials.folio_id', '=', 'folios.id')
                        ->join('estacion_producto', 'folios_historials.estacion_producto_id', '=', 'estacion_producto.id')
                        ->join('productos', 'estacion_producto.producto_id', '=', 'productos.id')
                        ->join('estacions', 'estacion_producto.estacion_id', '=', 'estacions.id')
                        ->select('estacion_producto.id', 'estacion_producto.estacion_id', 'folios_historials.cantidad', 'estacions.name', 'productos.name', 'productos.unidad', 'folios_historials.observacion', 'productos.product_photo_path')
                        ->where('folios.folio', $this->isFolio)
                        ->get();

                $this->GeneratePDF($this->isFolio, $joinFolios, $this->motivo, $this->isEntraoSali);

                $this->ultFoId->forceFill([
                    'pdf' => $this->nombrePDF,
                ])->save();

                $mailData = [
                    'usuarioSolici' => Auth::user()->name,
                    'estacEs' => $this->estacion->name,
                    'esdeFolio' => $this->isFolio,
                    'motivoEs' => $this->motivo,
                    'entraSale' => $this->isEntraoSali,
                    'produSolici' => $joinFolios,
                    'nombrePdf' => $this->nombrePDF,
                ];

                Mail::to($usersSupers)
                    ->cc($usersAdmins)
                    ->bcc('comprasgdl@fullgas.com.mx','auxsistemas@fullgas.com.mx')
                    ->send(new MailNewAlmacenGerente($mailData));

                Notification::send($usersAdmins, new NotifiNewAlmacenGerente($this->ultFoId));
                Notification::send($usersCompras, new NotifiNewAlmacenGerente($this->ultFoId));
                Notification::send($usersSupers, new NotifiNewAlmacenGerente($this->ultFoId));

                $this->inputs = [];

                $this->mount();

                Alert::success('Nuevo Producto', "Se ha enviado la solicitud de".' '.$this->isEntraoSali.' '."a su supervisor");
                    
                return redirect()->route('almacenes');
            }
        }
    }

    public function GeneratePDF($esunFolio, $foliosHisto, $motivoEs, $entraSale) {
        $fecha = now()->format('d-m-Y');
        $supervisor = Auth::user()->name;
        $gerente = Auth::user()->name;

        if (Auth::user()->permiso_id == 2) {
            $this->nombrePDF = $fecha .'_'. $esunFolio .'_'. $supervisor .'_'. rand(10, 100000) .'.pdf';
        } elseif (Auth::user()->permiso_id == 3) {
            $this->nombrePDF = $fecha .'_'. $esunFolio .'_'. $gerente .'_'. rand(10, 100000) .'.pdf';
        } elseif (Auth::user()->permiso_id != 2 && Auth::user()->permiso_id != 3) {
            $this->nombrePDF = $fecha .'_'. $esunFolio .'_'. rand(10, 100000) .'.pdf';
        }
        
        $data = [
            'fechaEntrada' => $fecha,
            'foliosPedidos' => $foliosHisto,
            'folioEntrada' => $esunFolio,
            'solicitadoPor' => Auth::user()->name,
            'elMotivo' => $motivoEs,
            'esEntraoSale' => $entraSale,
        ];
           
        $cont = Pdf::loadView('livewire.almacenes.almacen-entrada-pdf', $data)->output();

        Storage::disk('public')->put('entradas-salidas-pdfs/'.$this->nombrePDF, $cont);
    }

    //FUNCIÓN PARA ACTUALIZAR EL INPUT DE LAS ESTACIONES A MOSTRAR SEGÚN EL PERMISO
    public function updatedisEstaSuper($entraSup) {
        if (Auth::user()->permiso_id == 2) {
            if ($entraSup == 'Estacion') {
                $this->allSuperStation = Estacion::where('supervisor_id', Auth::user()->id)->where('status', 'Activo')->get();
            } else {
                $this->allSuperStation = null;

                $this->reset(['estacion']);
            }

        } elseif (Auth::user()->permiso_id != 2 && Auth::user()->permiso_id != 3) {
            if ($entraSup == 'Estacion') {
                $this->superAlma = null;

                $this->reset(['supervisor']);

                $this->allSuperStation = Estacion::where('status', 'Activo')->get();

            } elseif ($entraSup == 'SuperviAlma') {
                $this->allSuperStation = null;

                $this->reset(['estacion']);

                $this->superAlma = User::where('permiso_id', 2)->where('status', 'Activo')->get();
            }
        }
    }

    //FUNCIÓN PARA MOSTRAR U OCULTAR EL INPUT DE CONDICIONES DEL EQUIPO
    public function updatedisEntraoSali($entr)
    {
        if ($entr == 'Entrada') {
            $this->viewCondi = true;
        } else {
            $this->viewCondi = null;

            $this->reset(['condiEquipo']);
        }
    }

    public function updatedCategoria($id)
    {
        if (Auth::user()->permiso_id != 2 && Auth::user()->permiso_id != 3) {
            $this->productos = Producto::where('categoria_id', $id)->where('status', 'Activo')->get();
        } else {
            $user = Auth::user();
            $this->productos = Producto::whereHas('zonas', function ($query) use ($user) {
                $query->whereIn('zona_id', $user->zonas->pluck('id'));
            })->where('categoria_id', $id)->where('status', 'Activo')->get();
        }
    }

      //FUNCIÓN (propio de livewire) PARA RENDERIZAR EL COMPONENTE Y LAS DEMAS VARIABLES DENTRO DEL METODO A LA VISTA
    public function render()
    {
        //VALIDACION PARA MOSTRAR LOS PRODUCTOS SEGUN EL PERMISO Y LA ZONA DEL USUARIO
        // if (Auth::user()->permiso_id != 2 && Auth::user()->permiso_id != 3) {
        //     $this->productos = Producto::where('status', 'Activo')->get();
        // } else {
        //     $user = Auth::user();
        //     $this->productos = Producto::whereHas('zonas', function ($query) use ($user) {
        //         $query->whereIn('zona_id', $user->zonas->pluck('id'));
        //     })->get();
        // }

        $this->categorias=Categoria::where('status','Activo')->whereIn('id',[1,2,3,4,5,6,7])->get();

        //VARIABLE PARA MOSTRAR TODAS LAS ESTACIONES
        $this->allStation = Estacion::where('status', 'Activo')->get();

        return view('livewire.almacenes.almacen-create');
    }
}
