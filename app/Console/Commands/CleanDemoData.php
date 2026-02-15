<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Receta;
use App\Models\RecetaItem;
use App\Models\Cotizacion;
use App\Models\CotizacionItem;
use App\Models\Prestamo;
use App\Models\Pago;
use App\Models\Aportador;
use App\Models\Aportacion;
use App\Models\Contratista;
use App\Models\ContratistaProyecto;
use App\Models\ContratistaArchivo;
use App\Models\User;

class CleanDemoData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:clean {--force : Forzar eliminación sin confirmación}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Elimina todos los datos de demostración del sistema';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('');
        $this->warn('⚠️  ADVERTENCIA: Esta acción eliminará TODOS los datos de demostración del sistema.');
        $this->info('');
        
        // Mostrar resumen de datos a eliminar
        $this->info('📊 Datos que serán eliminados:');
        $this->line('   - Usuarios demo: ' . User::where('email', 'LIKE', '%@demo.com')->count());
        $this->line('   - Clientes: ' . Cliente::count());
        $this->line('   - Productos: ' . Producto::count());
        $this->line('   - Recetas: ' . Receta::count());
        $this->line('   - Cotizaciones: ' . Cotizacion::count());
        $this->line('   - Aportadores: ' . Aportador::count());
        $this->line('   - Préstamos: ' . Prestamo::count());
        $this->line('   - Pagos: ' . Pago::count());
        $this->line('   - Contratistas: ' . Contratista::count());
        $this->line('   - Proyectos: ' . ContratistaProyecto::count());
        $this->line('   - Archivos: ' . ContratistaArchivo::count());
        $this->info('');

        // Confirmar acción
        if (!$this->option('force')) {
            if (!$this->confirm('¿Está seguro de que desea eliminar todos estos datos?')) {
                $this->info('Operación cancelada.');
                return 0;
            }
        }

        $this->warn('🗑️  Eliminando datos...');
        $this->info('');

        DB::beginTransaction();
        try {
            // Eliminar en orden correcto (de dependientes a principales)
            
            // 1. Archivos de contratistas
            $this->deleteWithProgress('Archivos de contratistas', function() {
                // Eliminar archivos físicos primero
                $archivos = ContratistaArchivo::all();
                foreach ($archivos as $archivo) {
                    if (\Storage::disk('public')->exists($archivo->ruta_archivo)) {
                        \Storage::disk('public')->delete($archivo->ruta_archivo);
                    }
                }
                return ContratistaArchivo::query()->delete();
            });

            // 2. Proyectos de contratistas
            $this->deleteWithProgress('Proyectos de contratistas', function() {
                return ContratistaProyecto::query()->delete();
            });

            // 3. Contratistas
            $this->deleteWithProgress('Contratistas', function() {
                return Contratista::query()->delete();
            });

            // 4. Aportaciones
            $this->deleteWithProgress('Aportaciones', function() {
                return Aportacion::query()->delete();
            });

            // 5. Pagos
            $this->deleteWithProgress('Pagos', function() {
                return Pago::query()->delete();
            });

            // 6. Préstamos
            $this->deleteWithProgress('Préstamos', function() {
                return Prestamo::withTrashed()->forceDelete();
            });

            // 7. Items de cotizaciones
            $this->deleteWithProgress('Items de cotizaciones', function() {
                return CotizacionItem::query()->delete();
            });

            // 8. Cotizaciones
            $this->deleteWithProgress('Cotizaciones', function() {
                return Cotizacion::query()->delete();
            });

            // 9. Items de recetas
            $this->deleteWithProgress('Items de recetas', function() {
                return RecetaItem::query()->delete();
            });

            // 10. Recetas
            $this->deleteWithProgress('Recetas', function() {
                return Receta::query()->delete();
            });

            // 11. Productos
            $this->deleteWithProgress('Productos', function() {
                return Producto::query()->delete();
            });

            // 12. Aportadores (restaurar capital)
            $this->deleteWithProgress('Aportadores', function() {
                return Aportador::query()->delete();
            });

            // 13. Clientes
            $this->deleteWithProgress('Clientes', function() {
                return Cliente::query()->delete();
            });

            // 14. Usuarios demo
            $this->deleteWithProgress('Usuarios demo', function() {
                return User::where('email', 'LIKE', '%@demo.com')->delete();
            });

            // Reiniciar auto-increment de todas las tablas
            $this->info('');
            $this->warn('🔄 Reiniciando contadores de ID...');
            
            $tables = [
                'clientes', 'productos', 'recetas', 'receta_items', 'cotizaciones', 'cotizacion_items',
                'prestamos', 'pagos', 'aportadores', 'aportaciones', 'contratistas', 
                'contratista_proyectos', 'contratista_archivos'
            ];
            
            foreach ($tables as $table) {
                DB::statement("ALTER TABLE {$table} AUTO_INCREMENT = 1");
            }

            DB::commit();

            $this->info('');
            $this->info('✅ Todos los datos de demostración han sido eliminados exitosamente.');
            $this->info('');
            $this->info('💡 Puede volver a cargar datos demo ejecutando:');
            $this->info('   php artisan db:seed --class=DemoDataSeeder');
            $this->info('');

            return 0;

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('');
            $this->error('❌ Error al eliminar datos: ' . $e->getMessage());
            $this->error('');
            return 1;
        }
    }

    /**
     * Eliminar registros con barra de progreso
     */
    private function deleteWithProgress($nombre, $callback)
    {
        $this->info("   Eliminando {$nombre}...");
        $count = $callback();
        $this->line("   ✓ {$count} registros eliminados");
    }
}
