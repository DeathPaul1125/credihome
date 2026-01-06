<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpiar la caché de permisos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Definir permisos por categoría
        $permissions = [
            // Usuarios
            'ver-usuarios',
            'crear-usuarios',
            'editar-usuarios',
            'eliminar-usuarios',
            'asignar-roles',

            // Roles y permisos
            'ver-roles',
            'crear-roles',
            'editar-roles',
            'eliminar-roles',
            'asignar-permisos',

            // Clientes
            'ver-clientes',
            'crear-clientes',
            'editar-clientes',
            'eliminar-clientes',

            // Aportadores
            'ver-aportadores',
            'crear-aportadores',
            'editar-aportadores',
            'eliminar-aportadores',
            'agregar-capital-aportadores',
            'retirar-capital-aportadores',

            // Productos/Materiales
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

            // Pagos
            'ver-pagos',
            'registrar-pagos',
            'eliminar-pagos',

            // Reportes
            'ver-reportes',
            'exportar-reportes',

            // Chat
            'ver-chat',
            'enviar-mensajes',

            // Configuración
            'ver-configuracion',
            'editar-configuracion',

            // Dashboard
            'ver-dashboard',
        ];

        // Crear todos los permisos
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Crear roles y asignar permisos

        // Super Admin - Todos los permisos
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin']);
        $superAdmin->syncPermissions(Permission::all());

        // Administrador - Casi todos los permisos excepto gestión de roles
        $administrador = Role::firstOrCreate(['name' => 'Administrador']);
        $administrador->syncPermissions([
            'ver-usuarios',
            'crear-usuarios',
            'editar-usuarios',
            'eliminar-usuarios',
            'asignar-roles',

            'ver-clientes',
            'crear-clientes',
            'editar-clientes',
            'eliminar-clientes',

            'ver-aportadores',
            'crear-aportadores',
            'editar-aportadores',
            'eliminar-aportadores',
            'agregar-capital-aportadores',
            'retirar-capital-aportadores',

            'ver-productos',
            'crear-productos',
            'editar-productos',
            'eliminar-productos',
            'importar-productos',

            'ver-recetas',
            'crear-recetas',
            'editar-recetas',
            'eliminar-recetas',
            'clonar-recetas',

            'ver-cotizaciones',
            'crear-cotizaciones',
            'editar-cotizaciones',
            'eliminar-cotizaciones',
            'aprobar-cotizaciones',
            'convertir-cotizaciones',

            'ver-prestamos',
            'crear-prestamos',
            'editar-prestamos',
            'eliminar-prestamos',
            'aprobar-prestamos',

            'ver-pagos',
            'registrar-pagos',
            'eliminar-pagos',

            'ver-reportes',
            'exportar-reportes',

            'ver-chat',
            'enviar-mensajes',

            'ver-configuracion',
            'editar-configuracion',

            'ver-dashboard',
        ]);

        // Gerente - Permisos de gestión y visualización, sin eliminaciones críticas
        $gerente = Role::firstOrCreate(['name' => 'Gerente']);
        $gerente->syncPermissions([
            'ver-usuarios',
            'crear-usuarios',
            'editar-usuarios',

            'ver-clientes',
            'crear-clientes',
            'editar-clientes',

            'ver-aportadores',
            'agregar-capital-aportadores',
            'retirar-capital-aportadores',

            'ver-productos',
            'crear-productos',
            'editar-productos',

            'ver-recetas',
            'crear-recetas',
            'editar-recetas',
            'clonar-recetas',

            'ver-cotizaciones',
            'crear-cotizaciones',
            'editar-cotizaciones',
            'aprobar-cotizaciones',
            'convertir-cotizaciones',

            'ver-prestamos',
            'crear-prestamos',
            'editar-prestamos',
            'aprobar-prestamos',

            'ver-pagos',
            'registrar-pagos',

            'ver-reportes',
            'exportar-reportes',

            'ver-chat',
            'enviar-mensajes',

            'ver-configuracion',

            'ver-dashboard',
        ]);

        // Asesor - Permisos básicos de visualización y creación
        $asesor = Role::firstOrCreate(['name' => 'Asesor']);
        $asesor->syncPermissions([
            'ver-clientes',
            'crear-clientes',
            'editar-clientes',

            'ver-productos',

            'ver-recetas',

            'ver-cotizaciones',
            'crear-cotizaciones',
            'editar-cotizaciones',

            'ver-prestamos',

            'ver-pagos',
            'registrar-pagos',

            'ver-chat',
            'enviar-mensajes',

            'ver-dashboard',
        ]);

        // Cajero - Permisos enfocados en pagos y consultas
        $cajero = Role::firstOrCreate(['name' => 'Cajero']);
        $cajero->syncPermissions([
            'ver-clientes',

            'ver-prestamos',

            'ver-pagos',
            'registrar-pagos',

            'ver-chat',
            'enviar-mensajes',

            'ver-dashboard',
        ]);
    }
}
