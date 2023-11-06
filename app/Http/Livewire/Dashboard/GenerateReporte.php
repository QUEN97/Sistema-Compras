<?php

namespace App\Http\Livewire\Dashboard;

use App\Exports\AlmacenExpot;
use App\Exports\CategoriaExtport;
use App\Exports\EstacionExport;
use App\Exports\GastosGralExport;
use Livewire\Component;
use App\Exports\GeneralExport;
use App\Exports\ProductoExtport;
use App\Exports\ProveedorExport;
use App\Exports\RepuestoExtport;
use App\Exports\Sheets\GastosGralSheet;
use App\Exports\SolicitudExport;
use App\Exports\ZonaExport;
use App\Models\Categoria;
use App\Models\Solicitud;
use App\Models\Zona;
use Maatwebsite\Excel\Facades\Excel;

class GenerateReporte extends Component
{
    public $newgReporte, $tiporepor, $fechIni, $fechFin;
    public $statRepor, $reporSelec="Todos";
    private $solici;
    private $categori;
    private $zona;

    public function resetFilters()
    {
        $this->reset(['tiporepor', 'fechIni', 'fechFin', 'statRepor', 'reporSelec']);
    }

    public function mount()
    {
        $this->resetFilters();
        $this->newgReporte = false;
    }

    public function showModalFormReporte()
    {
        $this->resetFilters();
        $this->newgReporte = true;
    }

    public function addReporte()
    {
        $this->validate([
            'tiporepor'=>['required'],
            'reporSelec'=>['required'],
            'fechIni'=>['required'],
            'fechFin'=>['required']
        ],[
            'tiporepor.required'=>'El tipo de reporte es necesario',
            'reporSelec.required'=>'Seleccione un Status',
            'fechIni.required'=>'Ingrese una fecha de inicio',
            'fechFin.required'=>'Ingrese una fecha final',
        ]);
       if($this->tiporepor=="Solicitudes"){
            return Excel::download(new SolicitudExport($this->fechIni, $this->fechFin,$this->reporSelec), 'Reporte Solicitudes.xlsx');
       }
       if($this->tiporepor=="Almacenes"){
        return Excel::download(new AlmacenExpot($this->fechIni, $this->fechFin,$this->reporSelec), 'Reporte Amacenes.xlsx');
       }
       if($this->tiporepor=="Repuestos"){
        return Excel::download(new RepuestoExtport($this->fechIni, $this->fechFin,$this->reporSelec),'Reporte de Repuestos.xlsx');
       }
       if($this->tiporepor=="Zonas"){
        return Excel::download(new ZonaExport($this->fechIni, $this->fechFin,$this->reporSelec),'Reporte de Zonas.xlsx');
       }
       if($this->tiporepor=="Estaciones"){
        return Excel::download(new EstacionExport($this->fechIni, $this->fechFin),'Reporte de Estaciones.xlsx');
       }
       if($this->tiporepor=="Productos"){
        return Excel::download(new ProductoExtport($this->fechIni, $this->fechFin),'Reporte de Productos.xlsx');
       }
       if($this->tiporepor=="Categorias"){
        return Excel::download(new CategoriaExtport($this->fechIni, $this->fechFin),'Reporte de Categorias.xlsx');
       } 
       if($this->tiporepor=="Proveedores"){
        return Excel::download(new ProveedorExport($this->fechIni, $this->fechFin),'Reporte de Proveedores.xlsx');
       }
       if($this->tiporepor=="Gastos"){
        return Excel::download(new GastosGralExport($this->fechIni, $this->fechFin),'Reporte de Gastos.xlsx');
       }
       
    }

    public function updatedTiporepor($isTip)
    {
        if ($isTip == 'Solicitudes') {
            $this->statRepor = [
                'Todos',
                'Solicitado a Compras',
                'Solicitado al Supervisor',
                'Solicitud Aprobada',
                'Solicitud Rechazada'
            ];
        } elseif ($isTip == 'Almacenes') {
            $this->statRepor = [
                'Todos',
                'Solicitado',
                'Aprobado',
                'Rechazado'
            ];
        } elseif ($isTip == 'Repuestos') {
            $this->statRepor = [
                'Todos',
                'Solicitado al Supervisor',
                'Aprobado',
                'Rechazado'
            ];
        } elseif ($isTip == 'Zonas') {
            $this->statRepor = [
                'Todos',
                'Estaciones',
                'Gerentes',
                'Productos'
            ];
        } else {
            $this->statRepor = null;
        }
    }
    public function render()
    {
        return view('livewire.dashboard.generate-reporte');
    }
}