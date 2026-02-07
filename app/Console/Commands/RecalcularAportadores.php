<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Aportador;
use App\Models\Aportacion;

class RecalcularAportadores extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aportadores:recalcular {--aportador= : ID del aportador específico a recalcular}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalcula las estadísticas de capital de los aportadores basándose en sus aportaciones activas';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $aportadorId = $this->option('aportador');

        if ($aportadorId) {
            $this->recalcularAportador($aportadorId);
        } else {
            $this->recalcularTodos();
        }

        return 0;
    }

    private function recalcularTodos()
    {
        $this->info('Recalculando todos los aportadores...');

        $aportadores = Aportador::all();
        $bar = $this->output->createProgressBar($aportadores->count());

        foreach ($aportadores as $aportador) {
            $this->recalcularAportador($aportador->id, false);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('✓ Recalculación completada para ' . $aportadores->count() . ' aportadores');
    }

    private function recalcularAportador($aportadorId, $showInfo = true)
    {
        $aportador = Aportador::find($aportadorId);

        if (!$aportador) {
            $this->error("Aportador con ID {$aportadorId} no encontrado");
            return;
        }

        if ($showInfo) {
            $this->info("Recalculando aportador: {$aportador->nombre} (ID: {$aportador->id})");
            $this->line('Valores actuales:');
            $this->line("  Capital Disponible: Q " . number_format($aportador->capital_disponible, 2));
            $this->line("  Capital Invertido: Q " . number_format($aportador->capital_invertido, 2));
            $this->line("  Capital Recuperado: Q " . number_format($aportador->capital_recuperado, 2));
            $this->line("  Ganancias Totales: Q " . number_format($aportador->ganancias_totales, 2));
        }

        // Calcular valores desde las aportaciones
        $aportacionesActivas = Aportacion::where('aportador_id', $aportador->id)
            ->whereIn('estado', ['Activo', 'Recuperado'])
            ->get();

        $capitalInvertido = $aportacionesActivas->sum('monto_aportado');
        $capitalRecuperado = $aportacionesActivas->sum('monto_recuperado');
        $gananciasTotales = $aportacionesActivas->sum('intereses_ganados');

        // El capital disponible no lo recalculamos desde aportaciones,
        // solo ajustamos invertido, recuperado y ganancias
        $aportador->capital_invertido = $capitalInvertido;
        $aportador->capital_recuperado = $capitalRecuperado;
        $aportador->ganancias_totales = $gananciasTotales;
        $aportador->save();

        if ($showInfo) {
            $this->newLine();
            $this->line('Valores recalculados:');
            $this->line("  Capital Invertido: Q " . number_format($aportador->capital_invertido, 2));
            $this->line("  Capital Recuperado: Q " . number_format($aportador->capital_recuperado, 2));
            $this->line("  Ganancias Totales: Q " . number_format($aportador->ganancias_totales, 2));
            $this->info('✓ Recalculación completada');
        }
    }
}

