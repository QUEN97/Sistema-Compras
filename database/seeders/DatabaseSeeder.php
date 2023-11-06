<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        DB::table('permisos')->insert([
            'titulo_permiso' => 'Administrador',
            'descripcion' => 'Control Total del Sistema',
            'flag_trash' => 0,
            'created_at' => now(),
        ]);

        DB::table('permisos')->insert([
            'titulo_permiso' => 'Supervisor',
            'descripcion' => 'Gestión/Control de Compras de Estaciones Asignadas',
            'flag_trash' => 0,
            'created_at' => now(),
        ]);

        DB::table('permisos')->insert([
            'titulo_permiso' => 'Gerente',
            'descripcion' => 'Solicitud de Compras',
            'flag_trash' => 0,
            'created_at' => now(),
        ]);

        DB::table('permisos')->insert([
            'titulo_permiso' => 'Compras',
            'descripcion' => 'Control de Compras y Productos del Sistema',
            'flag_trash' => 0,
            'created_at' => now(),
        ]);

        DB::table('panels')->insert([
            'titulo_panel' => 'Solicitudes',
            'created_at' => now(),
        ]);

        DB::table('panels')->insert([
            'titulo_panel' => 'Almacen',
            'created_at' => now(),
        ]);

        DB::table('panels')->insert([
            'titulo_panel' => 'Repuestos',
            'created_at' => now(),
        ]);

        DB::table('panels')->insert([
            'titulo_panel' => 'Usuarios',
            'created_at' => now(),
        ]);

        DB::table('panels')->insert([
            'titulo_panel' => 'Roles',
            'created_at' => now(),
        ]);

        DB::table('panels')->insert([
            'titulo_panel' => 'Zonas',
            'created_at' => now(),
        ]);

        DB::table('panels')->insert([
            'titulo_panel' => 'Estaciones',
            'created_at' => now(),
        ]);

        DB::table('panels')->insert([
            'titulo_panel' => 'Productos',
            'created_at' => now(),
        ]);

        DB::table('panels')->insert([
            'titulo_panel' => 'Categorias',
            'created_at' => now(),
        ]);

        DB::table('panels')->insert([
            'titulo_panel' => 'Manuales',
            'created_at' => now(),
        ]);

        DB::table('panels')->insert([
            'titulo_panel' => 'Proveedores',
            'created_at' => now(),
        ]);

        DB::table('panels')->insert([
            'titulo_panel' => 'Facturas',
            'created_at' => now(),
        ]);

        DB::table('panels')->insert([
            'titulo_panel' => 'Dashboard',
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 1,
            'panel_id' => 1,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 1,
            'panel_id' => 2,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 1,
            'panel_id' => 3,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 1,
            'panel_id' => 4,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 1,
            'panel_id' => 5,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 1,
            'panel_id' => 6,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 1,
            'panel_id' => 7,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 1,
            'panel_id' => 8,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 1,
            'panel_id' => 9,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 1,
            'panel_id' => 10,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 1,
            'panel_id' => 11,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 1,
            'panel_id' => 12,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 1,
            'panel_id' => 13,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);
        

        DB::table('panel_permiso')->insert([
            'permiso_id' => 2,
            'panel_id' => 1,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 2,
            'panel_id' => 2,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 2,
            'panel_id' => 3,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 2,
            'panel_id' => 4,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 2,
            'panel_id' => 5,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 2,
            'panel_id' => 6,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 2,
            'panel_id' => 7,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 2,
            'panel_id' => 8,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 2,
            'panel_id' => 9,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 2,
            'panel_id' => 10,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 2,
            'panel_id' => 11,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 2,
            'panel_id' => 12,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 2,
            'panel_id' => 13,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 3,
            'panel_id' => 1,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 3,
            'panel_id' => 2,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 3,
            'panel_id' => 3,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 3,
            'panel_id' => 4,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 3,
            'panel_id' => 5,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 3,
            'panel_id' => 6,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 3,
            'panel_id' => 7,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 3,
            'panel_id' => 8,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 3,
            'panel_id' => 9,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 3,
            'panel_id' => 10,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 3,
            'panel_id' => 11,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);
        DB::table('panel_permiso')->insert([
            'permiso_id' => 3,
            'panel_id' => 12,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 3,
            'panel_id' => 13,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 4,
            'panel_id' => 1,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 4,
            'panel_id' => 2,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);
        DB::table('panel_permiso')->insert([
            'permiso_id' => 4,
            'panel_id' => 3,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);
        DB::table('panel_permiso')->insert([
            'permiso_id' => 4,
            'panel_id' => 4,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);
        DB::table('panel_permiso')->insert([
            'permiso_id' => 4,
            'panel_id' => 5,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);
        DB::table('panel_permiso')->insert([
            'permiso_id' => 4,
            'panel_id' => 6,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);
        DB::table('panel_permiso')->insert([
            'permiso_id' => 4,
            'panel_id' => 7,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);
        DB::table('panel_permiso')->insert([
            'permiso_id' => 4,
            'panel_id' => 8,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);
        DB::table('panel_permiso')->insert([
            'permiso_id' => 4,
            'panel_id' => 9,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);
        DB::table('panel_permiso')->insert([
            'permiso_id' => 4,
            'panel_id' => 10,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);
        DB::table('panel_permiso')->insert([
            'permiso_id' => 4,
            'panel_id' => 11,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);
        DB::table('panel_permiso')->insert([
            'permiso_id' => 4,
            'panel_id' => 12,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);
        DB::table('panel_permiso')->insert([
            'permiso_id' => 4,
            'panel_id' => 13,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('zonas')->insert([
            'name' => 'Mérida 1',
            'status' => 'Activo',
            'created_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Desarrollo FullGas',
            'username' => 'Desarrollo',
            'permiso_id' => 1,
            'status' => 'Activo',
            'email' => 'desarrollo@fullgas.com.mx',
            'password' => Hash::make('Desarrollo1.'),
            'created_at' => now()
        ]);


        DB::table('estacions')->insert([
            'name' => 'Estacion Inicio',
            'zona_id' => 1,
            'status' => 'Activo',
            'created_at' => now(),
        ]);

        DB::table('categorias')->insert([
            'name' => 'Limpieza',
            'status' => 'Activo',
            'created_at' => now(),
        ]);

        DB::table('productos')->insert([
            'name' => 'Ácido Muriático',
            'categoria_id' => 1,
            'unidad' => 'Pieza',
            'precio' => 10.00,
            'stock' => 1,
            'status' => 'Activo',
            'created_at' => now(),
        ]);
       
        DB::table('versions')->insert([
            'titulo_version' => 'Versión',
            'version' => 1,
            'status' => 'Actual',
            'flag_trash' => 0,
            'created_at' => now(),
        ]);

    }
}
