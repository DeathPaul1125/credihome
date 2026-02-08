# Integración con Recurrente

Esta aplicación incluye una integración con [Recurrente](https://recurrente.com), una pasarela de pagos para Guatemala.

## Configuración

### 1. Habilitar Recurrente

Ve a **Configuración → Pasarelas de Pago** y:

1. ✅ Marca la casilla "Habilitar Recurrente"
2. Selecciona el modo de operación:
   - **Modo Prueba (Sandbox)**: Para desarrollo y testing
   - **Modo Producción (Live)**: Para pagos reales

### 2. Configurar Llaves de API

Obtén tus llaves de API desde tu [panel de Recurrente](https://app.recurrente.com):

**Configuración → Llaves API**

#### Llaves de Prueba (TEST)
- Public Key Test: `pk_test_...`
- Secret Key Test: `sk_test_...`
- Para simular pagos exitosos usa: **4242 4242 4242 4242**

#### Llaves de Producción (LIVE)
- Public Key Live: `pk_live_...`
- Secret Key Live: `sk_live_...`
- ⚠️ **Nunca compartas tu Secret Key**

## Uso del Servicio

### Crear un Checkout de Pago

```php
use App\Services\RecurrenteService;

$recurrente = new RecurrenteService();

// Verificar si está habilitado
if ($recurrente->isEnabled()) {
    $checkout = $recurrente->createCheckout([
        'description' => 'Pago de cuota #1 - Préstamo #123',
        'amount' => 500.00, // Monto en quetzales
        'currency' => 'GTQ',
        'success_url' => route('pagos.success'),
        'cancel_url' => route('pagos.cancel'),
        'customer' => [
            'name' => 'Juan Pérez',
            'email' => 'juan@example.com',
            'phone' => '12345678',
        ],
        'metadata' => [
            'prestamo_id' => 123,
            'cuota_numero' => 1,
        ],
    ]);
    
    if ($checkout) {
        // Redirigir al usuario al link de pago
        return redirect($checkout['checkout_url']);
    }
}
```

### Verificar Estado de un Pago

```php
$recurrente = new RecurrenteService();

$checkout = $recurrente->getCheckout($checkoutId);

if ($checkout) {
    if ($checkout['status'] === 'paid') {
        // Pago completado exitosamente
        // Actualizar el estado del pago en tu sistema
    }
}
```

### Crear un Reembolso

```php
$recurrente = new RecurrenteService();

// Reembolso total
$refund = $recurrente->createRefund($chargeId);

// Reembolso parcial
$refund = $recurrente->createRefund($chargeId, 250.00);
```

### Crear un Cliente

```php
$recurrente = new RecurrenteService();

$customer = $recurrente->createCustomer([
    'name' => 'María López',
    'email' => 'maria@example.com',
    'phone' => '87654321',
]);
```

### Probar Autenticación

```php
$recurrente = new RecurrenteService();

if ($recurrente->testAuthentication()) {
    echo "Conexión exitosa con Recurrente";
} else {
    echo "Error: Verifica tus llaves de API";
}
```

## Webhooks

Para recibir notificaciones automáticas de Recurrente cuando un pago se complete, configura un webhook en tu panel de Recurrente apuntando a:

```
https://tu-dominio.com/webhooks/recurrente
```

Ejemplo de controlador para webhook:

```php
public function handleWebhook(Request $request)
{
    // Verificar firma del webhook (recomendado)
    
    $event = $request->input('event');
    $data = $request->input('data');
    
    if ($event === 'checkout.paid') {
        $checkoutId = $data['id'];
        $metadata = $data['metadata'];
        
        // Actualizar tu sistema
        // Por ejemplo, marcar un pago como completado
        $pago = Pago::where('checkout_id', $checkoutId)->first();
        if ($pago) {
            $pago->update([
                'estado' => 'completado',
                'fecha_pago' => now(),
            ]);
        }
    }
    
    return response()->json(['received' => true]);
}
```

## Flujo de Pago Recomendado

### Para Pagos de Cuotas

1. **Cliente selecciona pagar cuota**
   - Mostrar monto a pagar
   - Botón "Pagar con Recurrente"

2. **Crear checkout**
   ```php
   $checkout = $recurrente->createCheckout([...]);
   ```

3. **Redirigir a Recurrente**
   ```php
   return redirect($checkout['checkout_url']);
   ```

4. **Cliente completa el pago**
   - Recurrente procesa la tarjeta
   - Redirige a `success_url` o `cancel_url`

5. **Webhook confirma pago**
   - Tu sistema recibe notificación
   - Actualiza estado del pago

## Seguridad

✅ **Buenas Prácticas:**
- Usa siempre HTTPS en producción
- Valida webhooks con la firma
- No expongas las Secret Keys en el frontend
- Usa el modo de prueba durante desarrollo
- Reembolsa los pagos de prueba el mismo día

⚠️ **No hagas:**
- Compartir tus Secret Keys
- Usar llaves de producción en desarrollo
- Guardar información de tarjetas

## Recursos

- 📚 [Documentación API](https://documenter.getpostman.com/view/10340859/2sA2rFQf5R)
- 🏠 [Panel de Recurrente](https://app.recurrente.com)
- 💬 [Discord de Soporte](https://discord.gg/QhKPEkSKp2)
- 📧 Email: soporte@recurrente.com

## Testing

### Tarjetas de Prueba

| Tarjeta | Resultado |
|---------|-----------|
| 4242 4242 4242 4242 | ✅ Pago exitoso |

Usa cualquier CVV de 3 dígitos y cualquier fecha futura para expiración.

## Monedas Soportadas

- GTQ (Quetzales) - Por defecto
- USD (Dólares)
- Otras monedas según tu cuenta

## Comisiones

Las comisiones dependen de tu plan en Recurrente. Consulta tu panel para ver las tarifas aplicables.

---

**Nota:** Esta integración requiere una cuenta activa en Recurrente. Si aún no tienes una, regístrate en [recurrente.com](https://recurrente.com).
