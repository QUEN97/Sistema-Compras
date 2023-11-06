<?php

namespace App\Http\Livewire\Solicitudes;

use App\Models\ProductoExtraordinario;
use Livewire\Component;
use App\Models\Solicitud;
use App\Models\ProductoSolicitud;
use Illuminate\Support\Facades\DB;

class ShowSolicitud extends Component
{
    public $ShowgSolicitud;
    public $solicitud_show_id, $solicitudes, $itsTot, $itsTotExt, $observaciones;
    public $titulo_producto, $name, $products, $productsext, $pdf, $created_at;

    public function mount()
    {
        $this->ShowgSolicitud = false;
    }

    public function confirmShowSolicitud(int $id)
    {
        $solici = Solicitud::where('id', $id)->first();

        $this->solicitudes = Solicitud::where('id', $id)->first();

        $this->products = DB::table('producto_solicitud')
            ->join('solicituds as s', 'producto_solicitud.solicitud_id', 's.id')
            ->where('s.id', $id)
            ->where('producto_solicitud.flag_trash', 0)
            ->count();

        $this->productsext = DB::table('producto_extraordinario')
            ->join('solicituds as s', 'producto_extraordinario.solicitud_id', 's.id')
            ->where('s.id', $id)
            ->where('producto_extraordinario.flag_trash', 0)
            ->get();

        $this->name = $solici->estacion->name;
        $this->observaciones = $solici->observacions->sortByDesc('created_at');
        $this->pdf = $solici->pdf;
        $this->created_at = $solici->created_format;

        $this->itsTot = ProductoSolicitud::where('solicitud_id', $id)->where('flag_trash', 0)->sum('total');
        $this->itsTotExt = ProductoExtraordinario::where('solicitud_id', $id)->where('flag_trash', 0)->sum('total');

        $this->ShowgSolicitud = true;
    }

    public function render()
    {
        return view('livewire.solicitudes.show-solicitud');
    }
}
