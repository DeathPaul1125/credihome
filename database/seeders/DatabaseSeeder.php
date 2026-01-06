<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Primero crear roles y permisos
        $this->call(RoleSeeder::class);

        // Crear usuarios con roles específicos

        // Super Admin
        $superAdmin = User::factory()->create([
            'name' => 'Pablo Aceituno',
            'email' => 'civernet@gmail.com',
            'password' => bcrypt('admin123'),
        ]);
        $superAdmin->assignRole('Super Admin');

        // Administrador
        $admin = User::factory()->create([
            'name' => 'Carlos Administrador',
            'email' => 'admin@credihome.com',
            'password' => bcrypt('admin123'),
        ]);
        $admin->assignRole('Administrador');

        // Gerente
        $gerente = User::factory()->create([
            'name' => 'María Gerente',
            'email' => 'gerente@credihome.com',
            'password' => bcrypt('gerente123'),
        ]);
        $gerente->assignRole('Gerente');

        // Asesores
        $asesor1 = User::factory()->create([
            'name' => 'Juan Asesor',
            'email' => 'asesor1@credihome.com',
            'password' => bcrypt('asesor123'),
        ]);
        $asesor1->assignRole('Asesor');

        $asesor2 = User::factory()->create([
            'name' => 'Ana Asesora',
            'email' => 'asesor2@credihome.com',
            'password' => bcrypt('asesor123'),
        ]);
        $asesor2->assignRole('Asesor');

        // Cajero
        $cajero = User::factory()->create([
            'name' => 'Pedro Cajero',
            'email' => 'cajero@credihome.com',
            'password' => bcrypt('cajero123'),
        ]);
        $cajero->assignRole('Cajero');

        $this->command->info('✅ Usuarios creados exitosamente:');
        $this->command->info('   - Super Admin: civernet@gmail.com / admin123');
        $this->command->info('   - Administrador: admin@credihome.com / admin123');
        $this->command->info('   - Gerente: gerente@credihome.com / gerente123');
        $this->command->info('   - Asesor 1: asesor1@credihome.com / asesor123');
        $this->command->info('   - Asesor 2: asesor2@credihome.com / asesor123');
        $this->command->info('   - Cajero: cajero@credihome.com / cajero123');
    }
}
