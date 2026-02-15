<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class FondeoPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear permisos de fondeo
        $permisos = [
            'ver-fondeo-prestamos' => 'Ver préstamos pendientes de fondeo',
            'gestionar-fondeo-prestamos' => 'Asignar aportadores a préstamos',
            'aprobar-fondeo-prestamos' => 'Aprobar fondeo de préstamos',
        ];

        foreach ($permisos as $nombre => $descripcion) {
            Permission::firstOrCreate(
                ['name' => $nombre],
                ['guard_name' => 'web']
            );
        }

        // Asignar permisos a roles con acceso a fondeo
        $roles = ['Super Admin', 'Administrador', 'Gerente'];
        foreach ($roles as $roleName) {
            $role = Role::where('name', $roleName)->first();
            if ($role) {
                $role->givePermissionTo(array_keys($permisos));
                $this->command->info("Permisos de fondeo asignados al rol {$roleName}");
            }
        }

        $this->command->info('Permisos de fondeo creados exitosamente');
    }
}
