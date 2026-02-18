<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Permission;

class AsignarPermisoCotizaciones extends Command
{
    protected $signature = 'permisos:cotizaciones {email?}';
    protected $description = 'Asigna permisos de edición de cotizaciones a un usuario';

    public function handle()
    {
        $email = $this->argument('email');

        if (!$email) {
            // Si no se proporciona email, asignar al primer usuario administrador
            $user = User::first();
            if (!$user) {
                $this->error('No se encontró ningún usuario en el sistema.');
                return 1;
            }
        } else {
            $user = User::where('email', $email)->first();
            if (!$user) {
                $this->error("No se encontró el usuario con email: {$email}");
                return 1;
            }
        }

        // Verificar/crear el permiso
        $permiso = Permission::firstOrCreate(['name' => 'editar-cotizaciones']);

        // Asignar el permiso al usuario
        if (!$user->hasPermissionTo('editar-cotizaciones')) {
            $user->givePermissionTo('editar-cotizaciones');
            $this->info("✓ Permiso 'editar-cotizaciones' asignado a: {$user->name} ({$user->email})");
        } else {
            $this->warn("El usuario {$user->name} ya tiene el permiso 'editar-cotizaciones'");
        }

        return 0;
    }
}
