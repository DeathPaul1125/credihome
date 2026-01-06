<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Cliente::with('usuario')->latest();

        // Búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre_completo', 'like', "%{$search}%")
                  ->orWhere('dpi', 'like', "%{$search}%")
                  ->orWhere('telefono', 'like', "%{$search}%");
            });
        }

        // Filtro por estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $clientes = $query->paginate(15);

        return view('clientes.index-flowbite', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clientes.create-flowbite');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'dpi' => 'required|string|size:13|unique:clientes,dpi',
            'fecha_nacimiento' => 'required|date|before:today',
            'genero' => 'required|in:masculino,femenino,otro',
            'estado_civil' => 'required|in:soltero,casado,union_libre,divorciado,viudo',
            'telefono' => 'required|string|max:20',
            'telefono_alternativo' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'departamento' => 'required|string|max:255',
            'municipio' => 'required|string|max:255',
            'direccion_completa' => 'required|string',
            'zona' => 'nullable|string|max:50',
            'profesion' => 'nullable|string|max:255',
            'lugar_trabajo' => 'nullable|string|max:255',
            'puesto_trabajo' => 'nullable|string|max:255',
            'ingreso_mensual' => 'nullable|numeric|min:0',
            'referencia_nombre_1' => 'nullable|string|max:255',
            'referencia_telefono_1' => 'nullable|string|max:20',
            'referencia_parentesco_1' => 'nullable|string|max:100',
            'referencia_nombre_2' => 'nullable|string|max:255',
            'referencia_telefono_2' => 'nullable|string|max:20',
            'referencia_parentesco_2' => 'nullable|string|max:100',
            'notas' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['estado'] = 'activo';

        Cliente::create($validated);

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        $cliente->load(['prestamos.pagos', 'usuario']);

        return view('clientes.show-flowbite', compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        return view('clientes.edit-flowbite', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente)
    {
        $validated = $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'dpi' => 'required|string|size:13|unique:clientes,dpi,' . $cliente->id,
            'fecha_nacimiento' => 'required|date|before:today',
            'genero' => 'required|in:masculino,femenino,otro',
            'estado_civil' => 'required|in:soltero,casado,union_libre,divorciado,viudo',
            'telefono' => 'required|string|max:20',
            'telefono_alternativo' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'departamento' => 'required|string|max:255',
            'municipio' => 'required|string|max:255',
            'direccion_completa' => 'required|string',
            'zona' => 'nullable|string|max:50',
            'profesion' => 'nullable|string|max:255',
            'lugar_trabajo' => 'nullable|string|max:255',
            'puesto_trabajo' => 'nullable|string|max:255',
            'ingreso_mensual' => 'nullable|numeric|min:0',
            'referencia_nombre_1' => 'nullable|string|max:255',
            'referencia_telefono_1' => 'nullable|string|max:20',
            'referencia_parentesco_1' => 'nullable|string|max:100',
            'referencia_nombre_2' => 'nullable|string|max:255',
            'referencia_telefono_2' => 'nullable|string|max:20',
            'referencia_parentesco_2' => 'nullable|string|max:100',
            'estado' => 'required|in:activo,inactivo,bloqueado',
            'notas' => 'nullable|string',
        ]);

        $cliente->update($validated);

        return redirect()->route('clientes.show', $cliente)
            ->with('success', 'Cliente actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        // Verificar si tiene préstamos activos
        if ($cliente->prestamos()->whereIn('estado', ['activo', 'en_mora', 'vencido'])->exists()) {
            return back()->with('error', 'No se puede eliminar un cliente con préstamos activos.');
        }

        $cliente->delete();

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente eliminado exitosamente.');
    }
}
