<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Prestamo;
use App\Services\RecurrenteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Ejemplo de controlador para pagos con Recurrente
 *
 * Este es un ejemplo de implementación. Puedes adaptar estos métodos
 * a tu PagoController existente o crear uno nuevo para pagos online.
 */
class RecurrentePaymentController extends Controller
{
    protected $recurrente;

    public function __construct(RecurrenteService $recurrente)
    {
        $this->recurrente = $recurrente;
    }

    /**
     * Iniciar proceso de pago con Recurrente
     *
     * Ruta sugerida: POST /pagos/{pago}/recurrente
     */
    public function initPayment(Pago $pago)
    {
        // Verificar que Recurrente esté habilitado
        if (!$this->recurrente->isEnabled()) {
            return back()->with('error', 'Los pagos en línea no están disponibles en este momento.');
        }

        // Verificar que el pago esté pendiente
        if ($pago->estado !== 'pendiente') {
            return back()->with('error', 'Este pago ya ha sido procesado.');
        }

        $prestamo = $pago->prestamo;
        $cliente = $prestamo->cliente;

        // Crear checkout en Recurrente
        $checkout = $this->recurrente->createCheckout([
            'description' => "Pago de cuota #{$pago->numero_cuota} - Préstamo #{$prestamo->id}",
            'amount' => $pago->monto_cuota,
            'currency' => 'GTQ',
            'success_url' => route('recurrente.success', ['pago' => $pago->id]),
            'cancel_url' => route('recurrente.cancel', ['pago' => $pago->id]),
            'customer' => [
                'name' => $cliente->nombre_completo,
                'email' => $cliente->email,
                'phone' => $cliente->telefono,
            ],
            'metadata' => [
                'pago_id' => $pago->id,
                'prestamo_id' => $prestamo->id,
                'cuota_numero' => $pago->numero_cuota,
                'sistema' => 'CrediHome',
            ],
        ]);

        if (!$checkout) {
            Log::error('Error al crear checkout de Recurrente', [
                'pago_id' => $pago->id,
                'prestamo_id' => $prestamo->id,
            ]);

            return back()->with('error', 'No se pudo iniciar el proceso de pago. Por favor, intente nuevamente.');
        }

        // Guardar el checkout_id en el pago para referencia
        $pago->update([
            'checkout_id' => $checkout['id'],
            'checkout_url' => $checkout['checkout_url'],
        ]);

        // Redirigir al usuario a Recurrente para completar el pago
        return redirect($checkout['checkout_url']);
    }

    /**
     * Página de éxito después del pago
     *
     * Ruta sugerida: GET /pagos/{pago}/recurrente/success
     */
    public function success(Pago $pago, Request $request)
    {
        try {
            // Obtener el estado actual del checkout
            $checkout = $this->recurrente->getCheckout($pago->checkout_id);

            if ($checkout && $checkout['status'] === 'paid') {
                // Marcar el pago como completado
                $pago->update([
                    'estado' => 'pagado',
                    'fecha_pago' => now(),
                    'monto_pagado' => $checkout['amount'],
                    'metodo_pago' => 'Recurrente - ' . ($checkout['payment_method'] ?? 'Tarjeta'),
                    'notas' => 'Pago procesado con Recurrente. Charge ID: ' . ($checkout['charge_id'] ?? 'N/A'),
                ]);

                // Actualizar el saldo del préstamo
                $prestamo = $pago->prestamo;
                $prestamo->saldo_pendiente -= $pago->monto_pagado;
                $prestamo->total_pagado += $pago->monto_pagado;
                $prestamo->save();

                return view('pagos.recurrente.success', compact('pago'));
            }

            return view('pagos.recurrente.pending', compact('pago'));
        } catch (\Exception $e) {
            Log::error('Error al procesar success de Recurrente: ' . $e->getMessage());
            return view('pagos.recurrente.error', ['message' => 'Error al verificar el pago']);
        }
    }

    /**
     * Página de cancelación
     *
     * Ruta sugerida: GET /pagos/{pago}/recurrente/cancel
     */
    public function cancel(Pago $pago)
    {
        return view('pagos.recurrente.cancel', compact('pago'));
    }

    /**
     * Webhook para recibir notificaciones de Recurrente
     *
     * Ruta sugerida: POST /webhooks/recurrente
     *
     * IMPORTANTE: Configurar esta URL en el panel de Recurrente
     */
    public function webhook(Request $request)
    {
        try {
            $event = $request->input('event');
            $data = $request->input('data');

            Log::info('Webhook de Recurrente recibido', [
                'event' => $event,
                'data' => $data,
            ]);

            // Procesar diferentes tipos de eventos
            switch ($event) {
                case 'checkout.paid':
                    $this->handleCheckoutPaid($data);
                    break;

                case 'checkout.expired':
                    $this->handleCheckoutExpired($data);
                    break;

                case 'refund.created':
                    $this->handleRefundCreated($data);
                    break;

                default:
                    Log::info('Evento de webhook no manejado: ' . $event);
            }

            return response()->json(['received' => true]);
        } catch (\Exception $e) {
            Log::error('Error al procesar webhook de Recurrente: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Manejar evento de pago completado
     */
    protected function handleCheckoutPaid(array $data)
    {
        $checkoutId = $data['id'];
        $metadata = $data['metadata'] ?? [];
        $pagoId = $metadata['pago_id'] ?? null;

        if (!$pagoId) {
            Log::warning('Checkout sin pago_id en metadata', ['checkout_id' => $checkoutId]);
            return;
        }

        $pago = Pago::find($pagoId);

        if (!$pago) {
            Log::warning('Pago no encontrado', ['pago_id' => $pagoId]);
            return;
        }

        // Evitar procesar el mismo pago dos veces
        if ($pago->estado === 'pagado') {
            Log::info('Pago ya procesado', ['pago_id' => $pagoId]);
            return;
        }

        // Actualizar el pago
        $pago->update([
            'estado' => 'pagado',
            'fecha_pago' => now(),
            'monto_pagado' => $data['amount'],
            'metodo_pago' => 'Recurrente - ' . ($data['payment_method'] ?? 'Tarjeta'),
            'notas' => 'Pago procesado con Recurrente. Charge ID: ' . ($data['charge_id'] ?? 'N/A'),
        ]);

        // Actualizar el préstamo
        $prestamo = $pago->prestamo;
        $prestamo->saldo_pendiente -= $pago->monto_pagado;
        $prestamo->total_pagado += $pago->monto_pagado;
        $prestamo->save();

        Log::info('Pago procesado exitosamente vía webhook', [
            'pago_id' => $pagoId,
            'checkout_id' => $checkoutId,
        ]);
    }

    /**
     * Manejar evento de checkout expirado
     */
    protected function handleCheckoutExpired(array $data)
    {
        $checkoutId = $data['id'];

        $pago = Pago::where('checkout_id', $checkoutId)->first();

        if ($pago) {
            $pago->update([
                'notas' => ($pago->notas ?? '') . ' | Link de pago expirado',
            ]);

            Log::info('Checkout expirado', ['pago_id' => $pago->id]);
        }
    }

    /**
     * Manejar evento de reembolso creado
     */
    protected function handleRefundCreated(array $data)
    {
        Log::info('Reembolso creado', ['data' => $data]);

        // Aquí puedes implementar la lógica para manejar reembolsos
        // Por ejemplo: revertir el pago, crear una nota, notificar al usuario, etc.
    }
}
