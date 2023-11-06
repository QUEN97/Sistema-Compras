<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Estacion;
use App\Models\Producto;
use App\Models\Solicitud;
use App\Models\User;
use App\Models\Zona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function data()
    {
        $valid = Auth::user()->permiso->panels->where('id', 13)->first();
        $user = Auth::user();
        $totUsers = User::where('status', 'Activo')->count();
        $totZonas = Zona::where('status', 'Activo')->count();
        $totEstas = Estacion::where('status', 'Activo')->count();
        $totCates = Categoria::where('status', 'Activo')->count();
        $totProds = Producto::where('deleted_at', NULL)->count();
        $totSolis = Solicitud::where('deleted_at', NULL)->count();

        date_default_timezone_set('America/Mexico_City'); // Cambiar a la zona horaria requerida
        $hour = Carbon::now()->format('H');
        $date = Carbon::now()->format('m-d');

        $greeting = '';

        // Determina el saludo según la hora del día en la que nos encontremos
        if ($hour >= 5 && $hour < 12) {
            $greeting = '¡Buenos días!';
        } elseif ($hour >= 12 && $hour < 19) {
            $greeting = '¡Buenas tardes!';
        } else {
            $greeting = '¡Buenas noches!';
        }

        // Determina el saludo según la festividad que se celebre
        $festivities = [
            '01-01' => ' - ¡Feliz Año Nuevo!',
            '12-25' => ' - ¡Feliz Navidad!',
            '11-02' => ' - ¡Feliz Día de los Muertos!',
            '02-14' =>' - ¡Feliz Día del Amor y la Amistad',
            '05-10' =>' - ¡Feliz Día de las Madres!',
            // Agrega aquí las festividades que desees
        ];

        if (isset($festivities[$date])) {
            $greeting .= ' ' . $festivities[$date];
        }

        return view('modules.dashboard.dashboard', compact('totZonas', 'totEstas', 'totUsers', 'totCates', 'totProds', 'totSolis', 'user', 'valid', 'greeting'));
    }
}
