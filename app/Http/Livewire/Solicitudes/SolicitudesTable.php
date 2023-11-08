<?php

namespace App\Http\Livewire\Solicitudes;

use App\Models\Categoria;
use App\Models\Estacion;
use App\Models\Solicitud;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Facades\Notification;
use RealRashid\SweetAlert\Facades\Alert;
use App\Notifications\NotifiAcepRechaSolicitud;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SolicitudesTable extends Component
{
    public $search = '';
    public $sortField;
    public $sortDirection = "asc";

    public $folIs;
    public $isGeren;
    public $isSuper;
    public $allSolicitud;
    public $valid;
    public $estas;
    public $cates;

    public $filterSoli;
    public $filterCat;
    public $categos;

    public function sortBy($field)
    {
        $this->sortDirection = $this->sortField === $field
            ? $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc'
            : 'asc';

        $this->sortField = $field;
    }

    public function aceptarSoliCompr($numId)
    {
        DB::table('solicituds')->where('id', $numId)->update(['status' => 'Solicitud Aprobada']);

        $this->folIs = Solicitud::where('id', $numId)->first();

        $userCom = User::where('permiso_id', 4)->get();
        Notification::send($userCom, new NotifiAcepRechaSolicitud($this->folIs));

        Notification::send($this->folIs->estacion->user, new NotifiAcepRechaSolicitud($this->folIs));

        Notification::send($this->folIs->estacion->supervisor, new NotifiAcepRechaSolicitud($this->folIs));

        Alert::success('Solicitud Aprobada', "Se aprobo la solicitud");

        //return redirect()->route('solicitudes');
        return redirect(request()->header('Referer'));
    }

    public function envAdmin($numId) //compras
    {
        DB::table('solicituds')->where('id', $numId)->update(['status' => 'Enviado a Administración']);

        $this->folIs = Solicitud::where('id', $numId)->first();

        $userAdmin = User::where('permiso_id', 1)->get();
        Notification::send($userAdmin, new NotifiAcepRechaSolicitud($this->folIs));

        Notification::send($this->folIs->estacion->user, new NotifiAcepRechaSolicitud($this->folIs));

        Notification::send($this->folIs->estacion->supervisor, new NotifiAcepRechaSolicitud($this->folIs));

        Alert::success('Solicitud Aprobada', "Se ha enviado a Administración para su revisión");

        //return redirect()->route('solicitudes');
        return redirect(request()->header('Referer'));
    }

    public function aceptarSoli($numId) //supervisores
    {
        DB::table('solicituds')->where('id', $numId)->update(['status' => 'Solicitado a Compras']);

        $this->folIs = Solicitud::where('id', $numId)->first();

        $userCom = User::where('permiso_id', 4)->get();
        Notification::send($userCom, new NotifiAcepRechaSolicitud($this->folIs));

        Notification::send($this->folIs->estacion->user, new NotifiAcepRechaSolicitud($this->folIs));

        Alert::success('Solicitud Aprobada', "Se ha enviado la solicitud a Compras");

        //return redirect()->route('solicitudes');
        return redirect(request()->header('Referer'));
    }

    public function render(Request $request)
    {
        $this->filterSoli == 'Todas' ? $this->filterSoli = null : $this->filterSoli;
        $this->filterCat == 'Todas' ? $this->filterCat = null : $this->filterCat;

        $this->isGeren = Estacion::where('status', 'Activo')->where('user_id', Auth::user()->id)->get();
        $this->isSuper = Estacion::where('status', 'Activo')->where('supervisor_id', Auth::user()->id)->get();
        $this->allSolicitud = Estacion::where('status', 'Activo')->get();
        $this->valid = Auth::user()->permiso->panels->where('id', 1)->first();
        $this->estas = Estacion::where('status', 'Activo')->get();
        $this->cates = Categoria::where('status', 'Activo')->get();

        //Consulta para administradores
        $query = Solicitud::join('estacions as e', 'solicituds.estacion_id', 'e.id')
            ->join('categorias as c', 'solicituds.categoria_id', 'c.id')
            ->leftJoin('producto_solicitud as ps', 'ps.solicitud_id', 'solicituds.id')
            ->leftJoin('producto_extraordinario as pe', 'pe.solicitud_id', 'solicituds.id')
            //->whereNotIn('solicituds.status', ['Solicitado al Supervisor', 'Solicitado a Compras','Solicitud Rechazada'])
            ->selectRaw('solicituds.id as id, solicituds.tipo_compra, solicituds.categoria_id, e.name as estacion, count(if(ps.flag_trash is null or ps.flag_trash = 1, null, ps.flag_trash)) as totprod, count(if(pe.flag_trash is null or pe.flag_trash = 1, null, pe.flag_trash)) as totprodext, solicituds.status, solicituds.created_at as fecha, solicituds.updated_at')
            ->when(Auth::user()->id == 2, function ($query) {
                $query->whereNotIn('solicituds.status', ['Solicitado al Supervisor', 'Solicitado a Compras', 'Solicitud Rechazada', 'Solicitud Aprobada']);
            })
            ->when($this->sortField, function ($query, $sortField) {
                $query->orderBy($sortField, $this->sortDirection);
            })
            ->when($this->filterSoli, function ($query, $filterSoli) {
                $query->where('solicituds.estacion_id', $filterSoli);
            })
            ->when($this->filterCat, function ($query, $filterCat) {
                $query->where('solicituds.categoria_id', $filterCat);
            })
            ->groupBy('solicituds.id', 'estacion', 'solicituds.status', 'fecha', 'tipo_compra', 'categoria_id', 'solicituds.updated_at')
            ->orderByDesc('fecha');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('e.name', 'like', '%' . $search . '%')
                    ->orWhere('solicituds.tipo_compra', 'like', '%' . $search . '%')
                    ->orWhere('c.name', 'like', '%' . $search . '%');
            });
            if ($request->has('filter') && $request->input('filter') != '') {
                $filterSoli = $request->input('filter');
                //dd($filterSoli);
                $query->where('solicituds.estacion_id', $filterSoli);
            }
            if ($request->has('filterc') && $request->input('filterc') != '') {
                $filterCat = $request->input('filterc');
                //dd($filterCat);
                $query->where('solicituds.categoria_id', $filterCat);
            }
        }

        //Consulta para compras
        $queryc = Solicitud::join('estacions as e', 'solicituds.estacion_id', 'e.id')
            ->join('categorias as c', 'solicituds.categoria_id', 'c.id')
            ->leftJoin('producto_solicitud as ps', 'ps.solicitud_id', 'solicituds.id')
            ->leftJoin('producto_extraordinario as pe', 'pe.solicitud_id', 'solicituds.id')
            //->where('solicituds.status', '!=', 'Solicitado al Supervisor')
            ->whereNotIn('solicituds.status', ['Solicitado al Supervisor', 'Solicitud Rechazada'])
            ->selectRaw('solicituds.id as id, solicituds.tipo_compra, solicituds.categoria_id, e.name as estacion, count(if(ps.flag_trash is null or ps.flag_trash = 1, null, ps.flag_trash)) as totprod, count(if(pe.flag_trash is null or pe.flag_trash = 1, null, pe.flag_trash)) as totprodext, solicituds.status, solicituds.created_at as fecha, solicituds.updated_at')
            ->when($this->sortField, function ($queryc, $sortField) {
                $queryc->orderBy($sortField, $this->sortDirection);
            })
            ->when($this->filterSoli, function ($queryc, $filterSoli) {
                $queryc->where('solicituds.estacion_id', $filterSoli);
            })
            ->when($this->filterCat, function ($query, $filterCat) {
                $query->where('solicituds.categoria_id', $filterCat);
            })
            ->groupBy('solicituds.id', 'estacion', 'solicituds.status', 'fecha', 'tipo_compra', 'categoria_id', 'solicituds.updated_at')
            ->orderByDesc('fecha');

        if ($request->has('search')) {
            $search = $request->input('search');
            $queryc->where(function ($q) use ($search) {
                $q->where('e.name', 'like', '%' . $search . '%')
                    ->orWhere('solicituds.tipo_compra', 'like', '%' . $search . '%')
                    ->orWhere('c.name', 'like', '%' . $search . '%');
            });
            if ($request->has('filter') && $request->input('filter') != '') {
                $filterSoli = $request->input('filter');
                $queryc->where('solicituds.estacion_id', $filterSoli);
            }
            if ($request->has('filterc') && $request->input('filterc') != '') {
                $filterCat = $request->input('filterc');
                $query->where('solicituds.categoria_id', $filterCat);
            }
        }

        //Consulta para supervisores
        $querys = Solicitud::join('estacions as e', 'solicituds.estacion_id', 'e.id')
            ->join('categorias as c', 'solicituds.categoria_id', 'c.id')
            ->leftJoin('producto_solicitud as ps', 'ps.solicitud_id', 'solicituds.id')
            ->leftJoin('producto_extraordinario as pe', 'pe.solicitud_id', 'solicituds.id')
            ->where('e.supervisor_id', Auth::user()->id)
            ->selectRaw('solicituds.id as id, solicituds.tipo_compra, solicituds.categoria_id, e.name as estacion, count(if(ps.flag_trash is null or ps.flag_trash = 1, null, ps.flag_trash)) as totprod, count(if(pe.flag_trash is null or pe.flag_trash = 1, null, pe.flag_trash)) as totprodext, solicituds.status, solicituds.created_at as fecha,solicituds.updated_at')
            ->when($this->sortField, function ($querys, $sortField) {
                $querys->orderBy($sortField, $this->sortDirection);
            })
            ->when($this->filterSoli, function ($querys, $filterSoli) {
                $querys->where('solicituds.estacion_id', $filterSoli);
            })
            ->when($this->filterCat, function ($query, $filterCat) {
                $query->where('solicituds.categoria_id', $filterCat);
            })
            ->groupBy('solicituds.id', 'estacion', 'solicituds.status', 'fecha', 'tipo_compra', 'categoria_id', 'solicituds.updated_at')
            ->orderByDesc('fecha');

        if ($request->has('search')) {
            $search = $request->input('search');
            $querys->where(function ($q) use ($search) {
                $q->where('e.name', 'like', '%' . $search . '%')
                    ->orWhere('solicituds.tipo_compra', 'like', '%' . $search . '%')
                    ->orWhere('c.name', 'like', '%' . $search . '%');
            });
            if ($request->has('filter') && $request->input('filter') != '') {
                $filterSoli = $request->input('filter');
                $querys->where('solicituds.estacion_id', $filterSoli);
            }
            if ($request->has('filterc') && $request->input('filterc') != '') {
                $filterCat = $request->input('filterc');
                $query->where('solicituds.categoria_id', $filterCat);
            }
        }

        //Consulta para gerentes
        $queryg = Solicitud::join('estacions as e', 'solicituds.estacion_id', 'e.id')
            ->join('categorias as c', 'solicituds.categoria_id', 'c.id')
            ->leftJoin('producto_solicitud as ps', 'ps.solicitud_id', 'solicituds.id')
            ->leftJoin('producto_extraordinario as pe', 'pe.solicitud_id', 'solicituds.id')
            ->where('e.user_id', Auth::user()->id)
            ->selectRaw('solicituds.id as id, solicituds.tipo_compra, solicituds.categoria_id, e.name as estacion, count(if(ps.flag_trash is null or ps.flag_trash = 1, null, ps.flag_trash)) as totprod, count(if(pe.flag_trash is null or pe.flag_trash = 1, null, pe.flag_trash)) as totprodext, solicituds.status, solicituds.created_at as fecha, solicituds.updated_at')
            ->when($this->sortField, function ($queryg, $sortField) {
                $queryg->orderBy($sortField, $this->sortDirection);
            })
            ->when($this->filterSoli, function ($queryg, $filterSoli) {
                $queryg->where('solicituds.estacion_id', $filterSoli);
            })
            ->when($this->filterCat, function ($query, $filterCat) {
                $query->where('solicituds.categoria_id', $filterCat);
            })
            ->groupBy('solicituds.id', 'estacion', 'solicituds.status', 'fecha', 'tipo_compra', 'categoria_id', 'solicituds.updated_at')
            ->orderByDesc('fecha');

        if ($request->has('search')) {
            $search = $request->input('search');
            $queryg->where(function ($q) use ($search) {
                $q->where('e.name', 'like', '%' . $search . '%')
                    ->orWhere('solicituds.tipo_compra', 'like', '%' . $search . '%')
                    ->orWhere('c.name', 'like', '%' . $search . '%');
            });
            if ($request->has('filter') && $request->input('filter') != '') {
                $filterSoli = $request->input('filter');
                $queryg->where('solicituds.estacion_id', $filterSoli);
            }
            if ($request->has('filterc') && $request->input('filterc') != '') {
                $filterCat = $request->input('filterc');
                $query->where('solicituds.categoria_id', $filterCat);
            }
        }

        $todoSolis = $query->paginate(20)->withQueryString();
        $compraSolis = $queryc->paginate(20)->withQueryString();
        $superSolis = $querys->paginate(20)->withQueryString();
        $gerenSolis = $queryg->paginate(20)->withQueryString();

        $trashed = Solicitud::onlyTrashed()->count();

        return view('livewire.solicitudes.solicitudes-table', [
            'todoSolis' => $todoSolis,
            'compraSolis' => $compraSolis,
            'superSolis' => $superSolis,
            'gerenSolis' => $gerenSolis,
            'trashed' => $trashed,
        ]);
    }
}
