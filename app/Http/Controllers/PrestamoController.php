<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Prestamo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PrestamoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Prestamo::with(['cliente', 'usuario'])->latest();

        // Búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('numero_prestamo', 'like', "%{$search}%")
                  ->orWhereHas('cliente', function($q2) use ($search) {
                      $q2->where('nombre_completo', 'like', "%{$search}%");
                  });
            });
        }

        // Filtro por estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        // Filtro por fecha
        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_desembolso', '>=', $request->fecha_desde);
        }
        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_desembolso', '<=', $request->fecha_hasta);
        }

        $prestamos = $query->paginate(15);

        return view('prestamos.index-flowbite', compact('prestamos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $clientes = Cliente::where('estado', 'activo')->orderBy('nombre_completo')->get();

        $clienteSeleccionado = null;
        if ($request->filled('cliente_id')) {
            $clienteSeleccionado = Cliente::find($request->cliente_id);
        }

        return view('prestamos.create-flowbite', compact('clientes', 'clienteSeleccionado'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'monto_prestado' => 'required|numeric|min:500|max:100000',
            'tasa_interes' => 'required|numeric|min:0|max:20',
            'tipo_interes' => 'required|in:simple,compuesto',
            'plazo' => 'required|integer|min:1|max:60',
            'frecuencia_pago' => 'required|in:semanal,quincenal,mensual',
            'fecha_desembolso' => 'required|date',
            'tipo_garantia' => 'required|in:ninguna,prenda,hipoteca,fiador,otro',
            'descripcion_garantia' => 'nullable|string',
            'notas' => 'nullable|string',
        ]);

        $prestamo = new Prestamo($validated);
        $prestamo->user_id = Auth::id();
        $prestamo->estado = 'activo';

        // Convertir valores numéricos a tipos correctos
        $validated['plazo'] = (int) $validated['plazo'];
        $validated['monto_prestado'] = (float) $validated['monto_prestado'];
        $validated['tasa_interes'] = (float) $validated['tasa_interes'];

        // Calcular valores del préstamo
        $prestamo->calcularValores();

        // Calcular fecha del primer pago
        $fechaDesembolso = Carbon::parse($validated['fecha_desembolso']);
        switch ($validated['frecuencia_pago']) {
            case 'semanal':
                $prestamo->fecha_primer_pago = $fechaDesembolso->copy()->addWeek();
                $prestamo->fecha_ultimo_pago = $fechaDesembolso->copy()->addWeeks($validated['plazo']);
                break;
            case 'quincenal':
                $prestamo->fecha_primer_pago = $fechaDesembolso->copy()->addWeeks(2);
                $prestamo->fecha_ultimo_pago = $fechaDesembolso->copy()->addWeeks($validated['plazo'] * 2);
                break;
            case 'mensual':
                $prestamo->fecha_primer_pago = $fechaDesembolso->copy()->addMonth();
                $prestamo->fecha_ultimo_pago = $fechaDesembolso->copy()->addMonths($validated['plazo']);
                break;
        }

        $prestamo->save();

        return redirect()->route('prestamos.show', $prestamo)
            ->with('success', 'Préstamo creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Prestamo $prestamo)
    {
        $prestamo->load(['cliente', 'usuario', 'aprobador', 'pagos.usuario']);

        return view('prestamos.show-flowbite', compact('prestamo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prestamo $prestamo)
    {
        // Solo permitir editar préstamos pendientes
        if ($prestamo->estado !== 'pendiente' && $prestamo->estado !== 'activo') {
            return back()->with('error', 'No se puede editar este préstamo.');
        }

        $clientes = Cliente::where('estado', 'activo')->orderBy('nombre_completo')->get();

        return view('prestamos.edit-flowbite', compact('prestamo', 'clientes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Prestamo $prestamo)
    {
        // Solo permitir actualizar si no tiene pagos
        if ($prestamo->pagos()->exists()) {
            return back()->with('error', 'No se puede editar un préstamo que ya tiene pagos registrados.');
        }

        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'monto_prestado' => 'required|numeric|min:500|max:100000',
            'tasa_interes' => 'required|numeric|min:0|max:20',
            'tipo_interes' => 'required|in:simple,compuesto',
            'plazo' => 'required|integer|min:1|max:60',
            'frecuencia_pago' => 'required|in:semanal,quincenal,mensual',
            'fecha_desembolso' => 'required|date',
            'tipo_garantia' => 'required|in:ninguna,prenda,hipoteca,fiador,otro',
            'descripcion_garantia' => 'nullable|string',
            'estado' => 'required|in:pendiente,activo,cancelado',
            'notas' => 'nullable|string',
        ]);

        $prestamo->fill($validated);

        // Convertir valores numéricos a tipos correctos
        $validated['plazo'] = (int) $validated['plazo'];
        $validated['monto_prestado'] = (float) $validated['monto_prestado'];
        $validated['tasa_interes'] = (float) $validated['tasa_interes'];

        $prestamo->calcularValores();

        // Recalcular fechas
        $fechaDesembolso = Carbon::parse($validated['fecha_desembolso']);
        switch ($validated['frecuencia_pago']) {
            case 'semanal':
                $prestamo->fecha_primer_pago = $fechaDesembolso->copy()->addWeek();
                $prestamo->fecha_ultimo_pago = $fechaDesembolso->copy()->addWeeks($validated['plazo']);
                break;
            case 'quincenal':
                $prestamo->fecha_primer_pago = $fechaDesembolso->copy()->addWeeks(2);
                $prestamo->fecha_ultimo_pago = $fechaDesembolso->copy()->addWeeks($validated['plazo'] * 2);
                break;
            case 'mensual':
                $prestamo->fecha_primer_pago = $fechaDesembolso->copy()->addMonth();
                $prestamo->fecha_ultimo_pago = $fechaDesembolso->copy()->addMonths($validated['plazo']);
                break;
        }

        $prestamo->save();

        return redirect()->route('prestamos.show', $prestamo)
            ->with('success', 'Préstamo actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prestamo $prestamo)
    {
        // Solo permitir eliminar préstamos sin pagos
        if ($prestamo->pagos()->exists()) {
            return back()->with('error', 'No se puede eliminar un préstamo que tiene pagos registrados.');
        }

        $prestamo->delete();

        return redirect()->route('prestamos.index')
            ->with('success', 'Préstamo eliminado exitosamente.');
    }

    /**
     * Aprobar un préstamo
     */
    public function aprobar(Prestamo $prestamo)
    {
        if ($prestamo->estado !== 'pendiente') {
            return back()->with('error', 'Este préstamo ya fue procesado.');
        }

        $prestamo->estado = 'activo';
        $prestamo->aprobado_por = Auth::id();
        $prestamo->fecha_aprobacion = now();
        $prestamo->save();

        return back()->with('success', 'Préstamo aprobado exitosamente.');
    }
}
