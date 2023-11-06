<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardCharts extends Component
{

    public function render()
    {
        $valid = Auth::user()->permiso->panels->where('id', 13)->first();

        $chartRepuestos= new LarapexChart();
        $chartPR= new LarapexChart();
        $chartSol=new LarapexChart();
        
        $labelsR=[];
        //$datosR=[];
        $labelsPR=[];
        $datosSol=[];
        $labelSol=[];

        $esta = DB::table('repuestos')
        ->join('estacions', 'repuestos.estacion_id','estacions.id')
        ->join('productos', 'repuestos.producto_id','productos.id')
        ->selectRaw('count(repuestos.producto_id) as products, estacions.name as estacion')
        ->where('repuestos.flag_trash', 0)
        ->groupBy('estacion')->orderBy('products', 'desc')->take(5)->get();

        foreach($esta as $es){
            $labelsR[]=$es->estacion;
        }
        $chartRepuestos->setType('pie')
        ->setTitle('Repuestos por Estación')
        ->setSubtitle('Top 5 que más solicitan repuestos.')
        ->setDataset($esta->pluck('products'))
        ->setLabels($labelsR);


        $datPR=DB::table('repuestos')
        ->join('estacions', 'repuestos.estacion_id','estacions.id')
        ->join('productos', 'repuestos.producto_id','productos.id')
        ->selectRaw('count(repuestos.producto_id) as cant, productos.name')
        ->where('repuestos.flag_trash', 0)->groupBy('name')->orderBy('cant', 'desc')->take(5)->get();

        foreach($datPR as $pr){
            $labelsPR[]=$pr->name;
        }
        $chartPR->setTitle('Repuestos Solicitados')
        ->setSubtitle('Top 5 de Repuestos más solicitados')        
        ->setType('bar')->setXAxis($labelsPR)->setGrid(true)->setDataset([[
            'name'  => 'Ventas',
            'data'  =>  $datPR->pluck('cant')
          ]])
        ->setColors(['#FF8F00'])
        ->setHeight(320);

        $sol = DB::table('solicituds')
        ->join('estacions', 'solicituds.estacion_id', '=', 'estacions.id')
        ->selectRaw('count(solicituds.estacion_id) as solicitudes, estacions.name as estacion')
        ->where('solicituds.deleted_at', null)->groupBy('estacion')->orderBy('solicitudes', 'desc')->take(5)->get();
        
        foreach ($sol as $s){
            $labelSol[] = $s->estacion;
        }
        $chartSol->setType('area')
        ->setTitle('Solicitudes por estacion')
        ->setSubtitle('Top 5 Estaciones con mayor número de solicitudes')
        ->setXAxis($labelSol)
        ->setDataset([[
            'name' => 'Prueba',
            'data' =>$sol->pluck('solicitudes')]])
        ->setHeight(320)
        ->setColors(['#FF0049']);

        return view('livewire.dashboard.dashboard-charts',compact('chartRepuestos','esta','chartPR','sol','chartSol'));
    }
}
