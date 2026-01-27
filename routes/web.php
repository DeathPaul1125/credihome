<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() ? redirect('/dashboard') : redirect('/login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    // Rutas de Clientes
    Route::resource('clientes', \App\Http\Controllers\ClienteController::class);
    Route::post('clientes/{cliente}/archivos', [\App\Http\Controllers\ClienteController::class, 'subirArchivo'])->name('clientes.archivos.store');
    Route::delete('clientes/{cliente}/archivos/{archivo}', [\App\Http\Controllers\ClienteController::class, 'eliminarArchivo'])->name('clientes.archivos.destroy');
    Route::post('clientes/search-pdi', [\App\Http\Controllers\ClienteController::class, 'searchPdi'])->name('clientes.search-pdi')->withoutMiddleware(['auth:sanctum', 'auth', 'verified']);

    // Rutas de Aportadores
    Route::get('aportadores/dashboard', [\App\Http\Controllers\AportadorController::class, 'dashboard'])->name('aportadores.dashboard');
    Route::resource('aportadores', \App\Http\Controllers\AportadorController::class);
    Route::post('aportadores/{aportador}/agregar-capital', [\App\Http\Controllers\AportadorController::class, 'agregarCapital'])->name('aportadores.agregar-capital');
    Route::post('aportadores/{aportador}/retirar-capital', [\App\Http\Controllers\AportadorController::class, 'retirarCapital'])->name('aportadores.retirar-capital');

    // Rutas de Productos/Materiales
    Route::resource('productos', \App\Http\Controllers\ProductoController::class);
    Route::get('productos-import/form', [\App\Http\Controllers\ProductoController::class, 'importForm'])->name('productos.import-form');
    Route::post('productos-import', [\App\Http\Controllers\ProductoController::class, 'import'])->name('productos.import');
    Route::get('productos-template/download', [\App\Http\Controllers\ProductoController::class, 'downloadTemplate'])->name('productos.download-template');

    // Rutas de Recetas
    Route::resource('recetas', \App\Http\Controllers\RecetaController::class);
    Route::post('recetas/{receta}/clonar', [\App\Http\Controllers\RecetaController::class, 'clonar'])->name('recetas.clonar');

    // Rutas de Cotizaciones
    Route::resource('cotizaciones', \App\Http\Controllers\CotizacionController::class);
    Route::post('cotizaciones/{cotizacion}/aprobar', [\App\Http\Controllers\CotizacionController::class, 'aprobar'])->name('cotizaciones.aprobar');
    Route::post('cotizaciones/{cotizacion}/convertir-prestamo', [\App\Http\Controllers\CotizacionController::class, 'convertirPrestamo'])->name('cotizaciones.convertir');

    // Rutas de Préstamos
    Route::resource('prestamos', \App\Http\Controllers\PrestamoController::class);
    Route::post('prestamos/{prestamo}/aprobar', [\App\Http\Controllers\PrestamoController::class, 'aprobar'])->name('prestamos.aprobar');

    // Rutas de Pagos
    Route::resource('pagos', \App\Http\Controllers\PagoController::class)->except(['edit', 'update']);

    // Ruta de Reportes
    Route::get('/reportes', [\App\Http\Controllers\ReporteController::class, 'index'])->name('reportes.index');

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
});
