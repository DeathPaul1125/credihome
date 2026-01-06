<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Crear permisos
        $permissions = [
            // Clientes
            'ver-clientes',
            'crear-clientes',
            'editar-clientes',
            'eliminar-clientes',

            // Productos
            'ver-productos',
            'crear-productos',
            'editar-productos',
            'eliminar-productos',
            'importar-productos',

            // Recetas
            'ver-recetas',
            'crear-recetas',
            'editar-recetas',
            'eliminar-recetas',
            'clonar-recetas',

            // Cotizaciones
            'ver-cotizaciones',
            'crear-cotizaciones',
            'editar-cotizaciones',
            'eliminar-cotizaciones',
            'aprobar-cotizaciones',
            'convertir-cotizaciones',

            // Préstamos
            'ver-prestamos',
            'crear-prestamos',
            'editar-prestamos',
            'eliminar-prestamos',
            'aprobar-prestamos',
            'rechazar-prestamos',

            // Pagos
            'ver-pagos',
            'registrar-pagos',
            'editar-pagos',
            'eliminar-pagos',

            // Aportadores
            'ver-aportadores',
            'crear-aportadores',
            'editar-aportadores',
            'eliminar-aportadores',
            'gestionar-capital-aportadores',

            // Reportes
            'ver-reportes',
            'exportar-reportes',

            // Configuración
            'ver-configuracion',
            'editar-configuracion',

            // Usuarios
            'ver-usuarios',
            'crear-usuarios',
            'editar-usuarios',
            'eliminar-usuarios',
            'asignar-roles',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Crear roles y asignar permisos

        // Super Admin - Tiene todos los permisos
        $superAdmin = Role::create(['name' => 'Super Admin']);
        $superAdmin->givePermissionTo(Permission::all());

        // Administrador - Todos excepto gestión de roles del super admin
        $admin = Role::create(['name' => 'Administrador']);
        $admin->givePermissionTo([
            'ver-clientes', 'crear-clientes', 'editar-clientes', 'eliminar-clientes',
            'ver-productos', 'crear-productos', 'editar-productos', 'eliminar-productos', 'importar-productos',
            'ver-recetas', 'crear-recetas', 'editar-recetas', 'eliminar-recetas', 'clonar-recetas',
            'ver-cotizaciones', 'crear-cotizaciones', 'editar-cotizaciones', 'eliminar-cotizaciones', 'aprobar-cotizaciones', 'convertir-cotizaciones',
            'ver-prestamos', 'crear-prestamos', 'editar-prestamos', 'eliminar-prestamos', 'aprobar-prestamos', 'rechazar-prestamos',
            'ver-pagos', 'registrar-pagos', 'editar-pagos', 'eliminar-pagos',
            'ver-aportadores', 'crear-aportadores', 'editar-aportadores', 'eliminar-aportadores', 'gestionar-capital-aportadores',
            'ver-reportes', 'exportar-reportes',
            'ver-configuracion', 'editar-configuracion',
            'ver-usuarios', 'crear-usuarios', 'editar-usuarios',
        ]);

        // Gerente - Aprueba préstamos y cotizaciones, ve todo
        $gerente = Role::create(['name' => 'Gerente']);
        $gerente->givePermissionTo([
            'ver-clientes', 'crear-clientes', 'editar-clientes',
            'ver-productos', 'crear-productos', 'editar-productos',
            'ver-recetas', 'crear-recetas', 'editar-recetas', 'clonar-recetas',
            'ver-cotizaciones', 'crear-cotizaciones', 'editar-cotizaciones', 'aprobar-cotizaciones', 'convertir-cotizaciones',
            'ver-prestamos', 'crear-prestamos', 'editar-prestamos', 'aprobar-prestamos', 'rechazar-prestamos',
            'ver-pagos', 'registrar-pagos',
            'ver-aportadores', 'crear-aportadores', 'editar-aportadores', 'gestionar-capital-aportadores',
            'ver-reportes', 'exportar-reportes',
            'ver-configuracion',
        ]);

        // Asesor - Crea clientes, cotizaciones, productos pero no aprueba
        $asesor = Role::create(['name' => 'Asesor']);
        $asesor->givePermissionTo([
            'ver-clientes', 'crear-clientes', 'editar-clientes',
            'ver-productos', 'crear-productos', 'editar-productos',
            'ver-recetas', 'crear-recetas', 'editar-recetas', 'clonar-recetas',
            'ver-cotizaciones', 'crear-cotizaciones', 'editar-cotizaciones',
            'ver-prestamos',
            'ver-pagos',
            'ver-aportadores',
            'ver-reportes',
            'ver-configuracion',
        ]);

        // Cobrador - Solo ve préstamos y registra pagos
        $cobrador = Role::create(['name' => 'Cobrador']);
        $cobrador->givePermissionTo([
            'ver-clientes',
            'ver-prestamos',
            'ver-pagos', 'registrar-pagos',
            'ver-reportes',
        ]);

        // Crear usuario Super Admin por defecto
        $user = User::first();
        if ($user) {
            $user->assignRole('Super Admin');
        }
    }
}
