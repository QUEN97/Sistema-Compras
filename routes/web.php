<?php

use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EstacionController;
use App\Http\Controllers\FacturasController;
use App\Http\Controllers\ManualController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\RepuestoController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VersionController;
use App\Http\Controllers\ZonaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified','developer'])->group(function () {
    //Dashboard
    Route::get('/dashboard', [DashboardController::class, 'data'])->name('dashboard');

    //Usuarios
    Route::get('/usuarios', [UserController::class, 'index'])->name('users');
    Route::delete('/users{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get("/trashed", [UserController::class, "trashed_users"])->name('users.trashed');
    Route::post("/restoreuser", [UserController::class, "do_restore"])->name('user_restore');
    Route::post("/deleteuser-permanently", [UserController::class, "delete_permanently"])->name('deleteuser_permanently');

    //Zonas
    Route::get('/zonas', [ZonaController::class, 'index'])->name('zonas');
    Route::delete('/zonas{zona}', [ZonaController::class, 'destroy'])->name('zonas.destroy');
    Route::get("/trashedzonas", [ZonaController::class, "trashed_zonas"])->name('zonas.trashedzonas');
    Route::post("/restorezona", [ZonaController::class, "do_restore"])->name('zona_restore');
    Route::post("/deletezona-permanently", [ZonaController::class, "delete_permanently"])->name('deletezona_permanently');

    //Estaciones
    Route::get('/estaciones', [EstacionController::class, 'index'])->name('estaciones');
    Route::delete('/estaciones{estacion}', [EstacionController::class, 'destroy'])->name('estaciones.destroy');
    Route::get("/trashedestaciones", [EstacionController::class, "trashed_estaciones"])->name('estaciones.trashed');
    Route::post("/restoreestacion", [EstacionController::class, "do_restore"])->name('estacion_restore');
    Route::post("/deleteestacion-permanently", [EstacionController::class, "delete_permanently"])->name('deleteestacion_permanently');

    //Categorias
    Route::get('/categorias', [CategoriaController::class, 'index'])->name('categorias');
    Route::delete('/categorias{categoria}', [CategoriaController::class, 'destroy'])->name('categorias.destroy');
    Route::get("/trashedcategorias", [CategoriaController::class, "trashed_categorias"])->name('categorias.trashed');
    Route::post("/restorecategoria", [CategoriaController::class, "do_restore"])->name('categoria_restore');
    Route::post("/deletecategoria-permanently", [CategoriaController::class, "delete_permanently"])->name('deletecategoria_permanently');

    //Productos
    Route::get('/productos', [ProductoController::class, 'index'])->name('productos');
    Route::delete('/productos{producto}', [ProductoController::class, 'destroy'])->name('productos.destroy');
    Route::get("/trashedproductos", [ProductoController::class, "trashed_productos"])->name('productos.trashed');
    Route::post("/restoreproducto", [ProductoController::class, "do_restore"])->name('producto_restore');
    Route::post("/deleteproducto-permanently", [ProductoController::class, "delete_permanently"])->name('deleteproducto_permanently');

    //Facturas
    Route::get('/facturas', [FacturasController::class, "home"])->name('facturas');

    //Proveedores
    Route::get('/proveedores', [ProveedorController::class, "all"])->name('proveedores');
    Route::get('/proveedores/trash', [ProveedorController::class, "trashList"])->name('proveedores.trash');
    Route::get('/proveedores/Search', [ProveedorController::class, "search"])->name('proveedores.search');

    //Solicitudes
    Route::get('/solicitudes', [SolicitudController::class, 'index'])->name('solicitudes');
    Route::delete('/solicitudes{solicitud}', [SolicitudController::class, 'destroy'])->name('solicitudes.destroy');
    Route::get("/trashedsolicitudes", [SolicitudController::class, "trashed_solicitudes"])->name('solicitudes.trashed');
    Route::post("/restoresolicitud", [SolicitudController::class, "do_restore"])->name('solicitud_restore');
    Route::post("/deletesolicitud-permanently", [SolicitudController::class, "delete_permanently"])->name('deletesolicitud_permanently');

    //Almacen
    Route::get('/almacen', [AlmacenController::class, 'index'])->name('almacenes');
    Route::delete('/almacenes{almacen}', [AlmacenController::class, 'destroy'])->name('almacenes.destroy');
    Route::get("/trashedalmacenes", [AlmacenController::class, "trashed_almacenes"])->name('almacenes.trashed');
    Route::post("/restorealmacen", [AlmacenController::class, "do_restore"])->name('almacen_restore');
    Route::post("/deletealmacen-permanently", [AlmacenController::class, "delete_permanently"])->name('deletealmacen_permanently');

    //Repuestos
    Route::get('/repuestos', [RepuestoController::class, 'Index'])->name('repuestos');
    Route::get('/repuestos/trash', [RepuestoController::class, 'TrashList'])->name('repuestos.trash');

    //Permisos
    Route::get('/roles', [PermisoController::class, 'show'])->name('roles');
    Route::put('/roles/{id}', [PermisoController::class, 'asignar'])->name('asignacionpermiso.asignar');

    //Sistema
    Route::get('/versiones', [VersionController::class, 'show'])->name('versiones');
    Route::get('/manuales', [ManualController::class, 'show'])->name('manuales');
    Route::get('/backups', [BackupController::class, 'index'])->name('backups.index');
Route::get('/backups/{backup}', [BackupController::class, 'download'])->name('backups.download');
});
