<?php

namespace App\Http\Controllers;

use App\Models\Configuracion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ConfiguracionController extends Controller
{
    public function edit()
    {
        $configuracion = Configuracion::obtener();
        return view('configuracion.edit', compact('configuracion'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nombre_aplicacion' => 'required|string|max:255',
            'slogan' => 'nullable|string|max:500',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'direccion' => 'nullable|string|max:500',
            'logo_login' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'logo_sidebar' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'logo_reportes' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'favicon' => 'nullable|image|mimes:png,jpg,jpeg,ico|max:1024',
            'pdf_orientacion' => 'required|in:portrait,landscape',
            'pdf_tamano' => 'required|in:letter,legal,a4',
            'pdf_footer' => 'nullable|string|max:500',
            'pdf_terminos_condiciones' => 'nullable|string',
            'color_primario' => 'nullable|string|max:7',
            'color_secundario' => 'nullable|string|max:7',
            'tasa_interes_default' => 'required|numeric|min:0|max:100',
            'plazo_default' => 'required|integer|min:1|max:120',
            'dias_vencimiento_cotizacion' => 'required|integer|min:1|max:90',
            'moneda' => 'required|string|max:10',
            'moneda_nombre' => 'required|string|max:50',
        ]);

        $configuracion = Configuracion::obtener();
        $data = $request->except(['logo_login', 'logo_sidebar', 'logo_reportes', 'favicon']);

        // Manejo de checkboxes
        $data['pdf_mostrar_logo'] = $request->has('pdf_mostrar_logo');
        $data['pdf_mostrar_fecha'] = $request->has('pdf_mostrar_fecha');
        $data['pdf_mostrar_usuario'] = $request->has('pdf_mostrar_usuario');
        $data['notificar_stock_bajo'] = $request->has('notificar_stock_bajo');
        $data['notificar_pagos_pendientes'] = $request->has('notificar_pagos_pendientes');
        $data['notificar_cotizaciones_vencidas'] = $request->has('notificar_cotizaciones_vencidas');

        // Manejo de imágenes
        if ($request->hasFile('logo_login')) {
            if ($configuracion->logo_login) {
                Storage::disk('public')->delete($configuracion->logo_login);
            }
            $data['logo_login'] = $request->file('logo_login')->store('logos', 'public');
        }

        if ($request->hasFile('logo_sidebar')) {
            if ($configuracion->logo_sidebar) {
                Storage::disk('public')->delete($configuracion->logo_sidebar);
            }
            $data['logo_sidebar'] = $request->file('logo_sidebar')->store('logos', 'public');
        }

        if ($request->hasFile('logo_reportes')) {
            if ($configuracion->logo_reportes) {
                Storage::disk('public')->delete($configuracion->logo_reportes);
            }
            $data['logo_reportes'] = $request->file('logo_reportes')->store('logos', 'public');
        }

        if ($request->hasFile('favicon')) {
            if ($configuracion->favicon) {
                Storage::disk('public')->delete($configuracion->favicon);
            }
            $data['favicon'] = $request->file('favicon')->store('logos', 'public');
        }

        $configuracion->update($data);

        return redirect()->route('configuracion.edit')
            ->with('success', 'Configuración actualizada correctamente.');
    }
}
