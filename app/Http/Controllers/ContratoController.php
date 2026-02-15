<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Contratista;
use App\Models\Contrato;
use App\Models\Prestamo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContratoController extends Controller
{
    /**
     * Listado de contratos
     */
    public function index(Request $request)
    {
        $query = Contrato::with(['cliente', 'prestamo', 'contratista', 'creador']);

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('numero_contrato', 'like', "%{$buscar}%")
                  ->orWhere('titulo', 'like', "%{$buscar}%")
                  ->orWhereHas('cliente', fn($c) => $c->where('nombre_completo', 'like', "%{$buscar}%"))
                  ->orWhereHas('contratista', fn($c) => $c->where('nombre_completo', 'like', "%{$buscar}%"));
            });
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $contratos = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('contratos.index', compact('contratos'));
    }

    /**
     * Formulario de creación
     */
    public function create()
    {
        $clientes = Cliente::whereHas('prestamos', function ($q) {
            $q->whereIn('estado', ['activo', 'en_mora']);
        })->where('estado', 'activo')->orderBy('nombre_completo')->get();

        $contratistas = Contratista::where('estado', 'activo')->orderBy('nombre_completo')->get();

        return view('contratos.create', compact('clientes', 'contratistas'));
    }

    /**
     * Obtener préstamos de un cliente (AJAX)
     */
    public function getPrestamosCliente($clienteId)
    {
        $prestamos = Prestamo::where('cliente_id', $clienteId)
            ->whereIn('estado', ['activo', 'en_mora'])
            ->select('id', 'numero_prestamo', 'monto_prestado', 'saldo_pendiente', 'monto_total')
            ->get();

        return response()->json($prestamos);
    }

    /**
     * Guardar nuevo contrato
     */
    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'prestamo_id' => 'required|exists:prestamos,id',
            'contratista_id' => 'required|exists:contratistas,id',
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'fecha_contrato' => 'required|date',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'monto_contrato' => 'nullable|numeric|min:0',
            'notas' => 'nullable|string',
            'estado' => 'required|in:borrador,activo,finalizado,cancelado',
        ]);

        // Verificar que el préstamo pertenece al cliente
        $prestamo = Prestamo::where('id', $request->prestamo_id)
            ->where('cliente_id', $request->cliente_id)
            ->firstOrFail();

        $contrato = Contrato::create([
            'numero_contrato' => Contrato::generateNumero(),
            'cliente_id' => $request->cliente_id,
            'prestamo_id' => $request->prestamo_id,
            'contratista_id' => $request->contratista_id,
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
            'estado' => $request->estado,
            'fecha_contrato' => $request->fecha_contrato,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'monto_contrato' => $request->monto_contrato,
            'notas' => $request->notas,
            'creado_por' => Auth::id(),
        ]);

        return redirect()->route('contratos.show', $contrato)->with('success', 'Contrato creado exitosamente.');
    }

    /**
     * Mostrar contrato
     */
    public function show(Contrato $contrato)
    {
        $contrato->load(['cliente', 'prestamo', 'contratista', 'creador']);

        return view('contratos.show', compact('contrato'));
    }

    /**
     * Formulario de edición
     */
    public function edit(Contrato $contrato)
    {
        $contrato->load(['cliente', 'prestamo', 'contratista']);

        $clientes = Cliente::whereHas('prestamos', function ($q) {
            $q->whereIn('estado', ['activo', 'en_mora']);
        })->where('estado', 'activo')->orderBy('nombre_completo')->get();

        // Incluir al cliente actual aunque no tenga préstamos activos
        if (!$clientes->contains('id', $contrato->cliente_id)) {
            $clientes->push($contrato->cliente);
        }

        $contratistas = Contratista::where('estado', 'activo')->orderBy('nombre_completo')->get();
        if (!$contratistas->contains('id', $contrato->contratista_id)) {
            $contratistas->push($contrato->contratista);
        }

        $prestamos = Prestamo::where('cliente_id', $contrato->cliente_id)->get();

        return view('contratos.edit', compact('contrato', 'clientes', 'contratistas', 'prestamos'));
    }

    /**
     * Actualizar contrato
     */
    public function update(Request $request, Contrato $contrato)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'prestamo_id' => 'required|exists:prestamos,id',
            'contratista_id' => 'required|exists:contratistas,id',
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'fecha_contrato' => 'required|date',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'monto_contrato' => 'nullable|numeric|min:0',
            'notas' => 'nullable|string',
            'estado' => 'required|in:borrador,activo,finalizado,cancelado',
        ]);

        $contrato->update($request->only([
            'cliente_id', 'prestamo_id', 'contratista_id', 'titulo',
            'contenido', 'estado', 'fecha_contrato', 'fecha_inicio',
            'fecha_fin', 'monto_contrato', 'notas',
        ]));

        return redirect()->route('contratos.show', $contrato)->with('success', 'Contrato actualizado exitosamente.');
    }

    /**
     * Eliminar contrato
     */
    public function destroy(Contrato $contrato)
    {
        $contrato->delete();

        return redirect()->route('contratos.index')->with('success', 'Contrato eliminado exitosamente.');
    }
}
