<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // Si el usuario está autenticado
    if (auth()->check()) {
        $user = auth()->user();

        // Verificar si es un cliente con portal
        $cliente = \App\Models\Cliente::where('portal_user_id', $user->id)->first();

        if ($cliente && $cliente->portal_activo) {
            return redirect('/portal/dashboard');
        }

        // Si no es cliente, redirigir al dashboard admin
        return redirect('/dashboard');
    }

    // Si no está autenticado, mostrar página de login
    return redirect('/login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Dashboard - redirigir según tipo de usuario
    Route::get('/dashboard', function() {
        $user = auth()->user();

        // Verificar si es un cliente con portal
        $cliente = \App\Models\Cliente::where('portal_user_id', $user->id)->first();

        if ($cliente && $cliente->portal_activo) {
            return redirect('/portal/dashboard');
        }

        // Dashboard admin
        return app(\App\Http\Controllers\DashboardController::class)->index();
    })->name('dashboard');

    // Rutas de Clientes
    Route::resource('clientes', \App\Http\Controllers\ClienteController::class);
    Route::post('clientes/{cliente}/archivos', [\App\Http\Controllers\ClienteController::class, 'subirArchivo'])->name('clientes.archivos.store');
    Route::delete('clientes/{cliente}/archivos/{archivo}', [\App\Http\Controllers\ClienteController::class, 'eliminarArchivo'])->name('clientes.archivos.destroy');
    Route::post('clientes/search-pdi', [\App\Http\Controllers\ClienteController::class, 'searchPdi'])->name('clientes.search-pdi')->withoutMiddleware(['auth:sanctum', 'auth', 'verified']);
    Route::post('clientes/{cliente}/activar-portal', [\App\Http\Controllers\ClienteController::class, 'activarPortal'])->name('clientes.activar-portal');
    Route::post('clientes/{cliente}/desactivar-portal', [\App\Http\Controllers\ClienteController::class, 'desactivarPortal'])->name('clientes.desactivar-portal');
    Route::post('clientes/{cliente}/regenerar-password', [\App\Http\Controllers\ClienteController::class, 'regenerarPassword'])->name('clientes.regenerar-password');

    // Rutas de Fotos del Proyecto
    Route::post('foto-proyecto/{id}/aprobar', [\App\Http\Controllers\ClienteController::class, 'aprobarFotoProyecto'])->name('foto-proyecto.aprobar');
    Route::post('foto-proyecto/{id}/rechazar', [\App\Http\Controllers\ClienteController::class, 'rechazarFotoProyecto'])->name('foto-proyecto.rechazar');

    // Rutas de Aportadores
    Route::get('aportadores/dashboard', [\App\Http\Controllers\AportadorController::class, 'dashboard'])->name('aportadores.dashboard');
    Route::post('aportadores/recalcular', [\App\Http\Controllers\AportadorController::class, 'recalcularTodos'])->name('aportadores.recalcular');
    Route::get('aportadores/{aportador}/movimientos', [\App\Http\Controllers\AportadorController::class, 'movimientos'])->name('aportadores.movimientos');
    Route::resource('aportadores', \App\Http\Controllers\AportadorController::class)->parameters(['aportadores' => 'aportador']);
    Route::post('aportadores/{aportador}/agregar-capital', [\App\Http\Controllers\AportadorController::class, 'agregarCapital'])->name('aportadores.agregar-capital');
    Route::post('aportadores/{aportador}/retirar-capital', [\App\Http\Controllers\AportadorController::class, 'retirarCapital'])->name('aportadores.retirar-capital');

    // Rutas de Aportaciones
    Route::get('aportaciones/{aportacion}/edit', [\App\Http\Controllers\AportacionController::class, 'edit'])->name('aportaciones.edit');
    Route::put('aportaciones/{aportacion}', [\App\Http\Controllers\AportacionController::class, 'update'])->name('aportaciones.update');
    Route::post('aportaciones/{aportacion}/recalcular', [\App\Http\Controllers\AportacionController::class, 'recalcular'])->name('aportaciones.recalcular');

    // Rutas de Productos/Materiales
    Route::resource('productos', \App\Http\Controllers\ProductoController::class);
    Route::get('productos-import/form', [\App\Http\Controllers\ProductoController::class, 'importForm'])->name('productos.import-form');
    Route::post('productos-import', [\App\Http\Controllers\ProductoController::class, 'import'])->name('productos.import');
    Route::get('productos-template/download', [\App\Http\Controllers\ProductoController::class, 'downloadTemplate'])->name('productos.download-template');

    // Rutas de Recetas
    Route::resource('recetas', \App\Http\Controllers\RecetaController::class);
    Route::post('recetas/{receta}/clonar', [\App\Http\Controllers\RecetaController::class, 'clonar'])->name('recetas.clonar');

    // Rutas de Cotizaciones
    Route::resource('cotizaciones', \App\Http\Controllers\CotizacionController::class)->parameters(['cotizaciones' => 'cotizacion']);
    Route::post('cotizaciones/{cotizacion}/aprobar', [\App\Http\Controllers\CotizacionController::class, 'aprobar'])->name('cotizaciones.aprobar');
    Route::post('cotizaciones/{cotizacion}/convertir-prestamo', [\App\Http\Controllers\CotizacionController::class, 'convertirPrestamo'])->name('cotizaciones.convertir');
    Route::get('cotizaciones/{cotizacion}/pdf', [\App\Http\Controllers\CotizacionController::class, 'exportPdf'])->name('cotizaciones.pdf');
    Route::get('cotizaciones/{cotizacion}/pdf-amortizacion', [\App\Http\Controllers\CotizacionController::class, 'exportPdfAmortizacion'])->name('cotizaciones.pdf-amortizacion');

    // Rutas de Préstamos
    Route::resource('prestamos', \App\Http\Controllers\PrestamoController::class);
    Route::post('prestamos/{prestamo}/aprobar', [\App\Http\Controllers\PrestamoController::class, 'aprobar'])->name('prestamos.aprobar');

    // Rutas de Fondeo de Préstamos
    Route::prefix('fondeo')->name('fondeo.')->middleware(['can:ver-fondeo-prestamos'])->group(function () {
        Route::get('/', [\App\Http\Controllers\FondeoController::class, 'index'])->name('index');
        Route::get('/{prestamo}/gestionar', [\App\Http\Controllers\FondeoController::class, 'gestionar'])->name('gestionar')->middleware('can:gestionar-fondeo-prestamos');
        Route::post('/{prestamo}/agregar-aportacion', [\App\Http\Controllers\FondeoController::class, 'agregarAportacion'])->name('agregar-aportacion')->middleware('can:gestionar-fondeo-prestamos');
        Route::delete('/{prestamo}/aportacion/{aportacion}', [\App\Http\Controllers\FondeoController::class, 'eliminarAportacion'])->name('eliminar-aportacion')->middleware('can:gestionar-fondeo-prestamos');
        Route::post('/{prestamo}/aprobar', [\App\Http\Controllers\FondeoController::class, 'aprobar'])->name('aprobar')->middleware('can:aprobar-fondeo-prestamos');
    });

    // Rutas de Pagos
    Route::resource('pagos', \App\Http\Controllers\PagoController::class);
    Route::get('pagos/{pago}/recibo', [\App\Http\Controllers\PagoController::class, 'recibo'])->name('pagos.recibo');

    // Ruta de Reportes
    Route::get('/reportes', [\App\Http\Controllers\ReporteController::class, 'index'])->name('reportes.index');

    // Rutas de Contratistas
    Route::middleware('can:ver-contratistas')->prefix('contratistas')->name('contratistas.')->group(function () {
        Route::get('/', [\App\Http\Controllers\ContratistaController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\ContratistaController::class, 'create'])->name('create')->middleware('can:crear-contratistas');
        Route::post('/', [\App\Http\Controllers\ContratistaController::class, 'store'])->name('store')->middleware('can:crear-contratistas');
        Route::get('/{contratista}', [\App\Http\Controllers\ContratistaController::class, 'show'])->name('show');
        Route::get('/{contratista}/edit', [\App\Http\Controllers\ContratistaController::class, 'edit'])->name('edit')->middleware('can:editar-contratistas');
        Route::put('/{contratista}', [\App\Http\Controllers\ContratistaController::class, 'update'])->name('update')->middleware('can:editar-contratistas');
        Route::delete('/{contratista}', [\App\Http\Controllers\ContratistaController::class, 'destroy'])->name('destroy')->middleware('can:eliminar-contratistas');
        
        // Proyectos
        Route::post('/{contratista}/proyectos', [\App\Http\Controllers\ContratistaController::class, 'agregarProyecto'])->name('agregar-proyecto')->middleware('can:crear-contratistas');
        Route::delete('/{contratista}/proyectos/{proyecto}', [\App\Http\Controllers\ContratistaController::class, 'eliminarProyecto'])->name('eliminar-proyecto')->middleware('can:eliminar-contratistas');
        
        // Archivos
        Route::post('/{contratista}/archivos', [\App\Http\Controllers\ContratistaController::class, 'subirArchivo'])->name('subir-archivo')->middleware('can:crear-contratistas');
        Route::get('/{contratista}/archivos/{archivo}/descargar', [\App\Http\Controllers\ContratistaController::class, 'descargarArchivo'])->name('descargar-archivo');
        Route::delete('/{contratista}/archivos/{archivo}', [\App\Http\Controllers\ContratistaController::class, 'eliminarArchivo'])->name('eliminar-archivo')->middleware('can:eliminar-contratistas');
    });

    // Rutas de Chat
    Route::get('/chat', [\App\Http\Controllers\ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{conversation}', [\App\Http\Controllers\ChatController::class, 'show'])->name('chat.show');
    Route::get('/chat/{conversation}/messages', [\App\Http\Controllers\ChatController::class, 'getMessages'])->name('chat.messages');
    Route::post('/chat/start', [\App\Http\Controllers\ChatController::class, 'startConversation'])->name('chat.start');
    Route::post('/chat/{conversation}/send', [\App\Http\Controllers\ChatController::class, 'sendMessage'])->name('chat.send');
    Route::post('/chat/attachment', [\App\Http\Controllers\ChatController::class, 'storeAttachment'])->name('chat.attachment');
    Route::get('/chat/attachment/{attachment}/download', [\App\Http\Controllers\ChatController::class, 'downloadAttachment'])->name('chat.download');

    // Rutas de Configuración
    Route::get('/configuracion', [\App\Http\Controllers\ConfiguracionController::class, 'edit'])->name('configuracion.edit');
    Route::put('/configuracion', [\App\Http\Controllers\ConfiguracionController::class, 'update'])->name('configuracion.update');

    // Rutas de Usuarios y Roles
    Route::resource('usuarios', \App\Http\Controllers\UserController::class);
    Route::post('usuarios/{user}/asignar-rol', [\App\Http\Controllers\UserController::class, 'asignarRol'])->name('usuarios.asignar-rol');

    // Rutas de Roles y Permisos
    Route::resource('roles', \App\Http\Controllers\RoleController::class);
    Route::post('roles/{role}/permisos', [\App\Http\Controllers\RoleController::class, 'actualizarPermisos'])->name('roles.permisos');

    // Rutas de Comprobantes de Pago (Administrador)
    Route::prefix('admin/comprobantes')->name('admin.comprobantes.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\ComprobantePagoController::class, 'index'])->name('index');
        Route::get('/{id}', [\App\Http\Controllers\Admin\ComprobantePagoController::class, 'show'])->name('show');
        Route::post('/{id}/aprobar', [\App\Http\Controllers\Admin\ComprobantePagoController::class, 'aprobar'])->name('aprobar');
        Route::post('/{id}/rechazar', [\App\Http\Controllers\Admin\ComprobantePagoController::class, 'rechazar'])->name('rechazar');
    });
});

// Rutas del Portal de Clientes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->prefix('portal')->name('portal.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\PortalClienteController::class, 'dashboard'])->name('dashboard');
    Route::get('/prestamo/{id}', [\App\Http\Controllers\PortalClienteController::class, 'verPrestamo'])->name('prestamo');
    Route::get('/prestamo/{prestamo_id}/subir-comprobante', [\App\Http\Controllers\PortalClienteController::class, 'subirComprobanteForm'])->name('subir-comprobante');
    Route::post('/prestamo/{prestamo_id}/comprobante', [\App\Http\Controllers\PortalClienteController::class, 'guardarComprobante'])->name('guardar-comprobante');
    Route::get('/mis-comprobantes', [\App\Http\Controllers\PortalClienteController::class, 'misComprobantes'])->name('mis-comprobantes');
    Route::get('/comprobante/{id}', [\App\Http\Controllers\PortalClienteController::class, 'verComprobante'])->name('comprobante');
    
    // Rutas para fotos de avance del proyecto
    Route::get('/mis-avances', [\App\Http\Controllers\PortalClienteController::class, 'misAvances'])->name('mis-avances');
    Route::post('/avance', [\App\Http\Controllers\PortalClienteController::class, 'guardarAvance'])->name('guardar-avance');
    Route::delete('/avance/{id}', [\App\Http\Controllers\PortalClienteController::class, 'eliminarAvance'])->name('eliminar-avance');
});
