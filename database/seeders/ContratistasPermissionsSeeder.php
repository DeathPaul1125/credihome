<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ContratistasPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear permisos de contratistas
        $permisos = [
            'ver-contratistas' => 'Ver contratistas',
            'crear-contratistas' => 'Crear nuevos contratistas',
            'editar-contratistas' => 'Editar información de contratistas',
            'eliminar-contratistas' => 'Eliminar contratistas',
        ];

        foreach ($permisos as $nombre => $descripcion) {
            Permission::firstOrCreate(
                ['name' => $nombre],
                ['guard_name' => 'web']
            );
        }

        // Asignar permisos a roles con acceso
        $roles = ['Super Admin', 'Administrador', 'Gerente', 'Asesor'];
        foreach ($roles as $roleName) {
            $role = Role::where('name', $roleName)->first();
            if ($role) {
                $role->givePermissionTo(array_keys($permisos));
                $this->command->info("Permisos de contratistas asignados al rol {$roleName}");
            }
        }

        $this->command->info('Permisos de contratistas creados exitosamente');
    }
}
