<?php

/**
 * Rutas para la integración con Recurrente
 *
 * Agregar estas rutas a tu archivo routes/web.php
 *
 * IMPORTANTE: Estas rutas deben estar dentro del grupo de
 * middleware 'auth' correspondiente
 */

// Grupo de rutas para Recurrente (requiere autenticación)
Route::middleware(['auth'])->group(function () {

    // Iniciar proceso de pago con Recurrente
    Route::post('/pagos/{pago}/recurrente', [RecurrentePaymentController::class, 'initPayment'])
        ->name('recurrente.initPayment');

    // Página de éxito después del pago
    Route::get('/pagos/{pago}/recurrente/success', [RecurrentePaymentController::class, 'success'])
        ->name('recurrente.success');

    // Página de cancelación
    Route::get('/pagos/{pago}/recurrente/cancel', [RecurrentePaymentController::class, 'cancel'])
        ->name('recurrente.cancel');
});

// Webhook de Recurrente (sin autenticación - debe ser accesible públicamente)
Route::post('/webhooks/recurrente', [RecurrentePaymentController::class, 'webhook'])
    ->name('recurrente.webhook');

/**
 * CONFIGURACIÓN DEL WEBHOOK EN RECURRENTE:
 *
 * 1. Ve a tu panel de Recurrente: https://app.recurrente.com
 * 2. Navega a Configuración → Webhooks
 * 3. Agrega una nueva URL de webhook:
 *    https://tu-dominio.com/webhooks/recurrente
 * 4. Selecciona los eventos que quieres recibir:
 *    - checkout.paid (Recomendado)
 *    - checkout.expired (Opcional)
 *    - refund.created (Opcional)
 * 5. Guarda la configuración
 *
 * IMPORTANTE:
 * - La URL debe ser HTTPS en producción
 * - Verifica que el webhook esté activo
 * - Monitorea los logs para asegurar que los eventos se reciben correctamente
 */

/**
 * EJEMPLO DE USO EN VISTAS:
 *
 * En cualquier vista donde quieras mostrar el botón de pago:
 *
 * @include('components.recurrente-button', [
 *     'pago' => $pago,
 *     'text' => 'Pagar con Tarjeta',
 *     'size' => 'md'
 * ])
 *
 * El botón se mostrará automáticamente solo si:
 * - Recurrente está habilitado en la configuración
 * - El pago está en estado 'pendiente'
 * - Las llaves de API están configuradas
 */

/**
 * EJEMPLO DE USO EN CONTROLADORES:
 *
 * use App\Services\RecurrenteService;
 *
 * public function pagarConRecurrente(Pago $pago)
 * {
 *     $recurrente = new RecurrenteService();
 *
 *     if (!$recurrente->isEnabled()) {
 *         return back()->with('error', 'Pagos en línea no disponibles');
 *     }
 *
 *     $checkout = $recurrente->createCheckout([...]);
 *
 *     if ($checkout) {
 *         return redirect($checkout['checkout_url']);
 *     }
 *
 *     return back()->with('error', 'Error al crear el pago');
 * }
 */
