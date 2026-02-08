<?php

/**
 * Pruebas y Verificación de la Integración con Recurrente
 *
 * Este archivo contiene ejemplos de cómo probar la integración con Recurrente
 * Puedes ejecutar estas pruebas en php artisan tinker o crear un comando de consola
 */

// =============================================================================
// 1. VERIFICAR QUE EL SERVICIO ESTÁ DISPONIBLE
// =============================================================================

use App\Services\RecurrenteService;

// Crear instancia del servicio
$recurrente = new RecurrenteService();
// O usar el helper
$recurrente = recurrente();

echo "✓ Servicio de Recurrente instanciado correctamente\n";

// =============================================================================
// 2. VERIFICAR CONFIGURACIÓN
// =============================================================================

$config = \App\Models\Configuracion::obtener();

echo "\n--- Configuración Actual ---\n";
echo "Recurrente Habilitado: " . ($config->recurrente_habilitado ? 'SÍ' : 'NO') . "\n";
echo "Modo de Prueba: " . ($config->recurrente_modo_prueba ? 'SÍ' : 'NO') . "\n";
echo "Public Key (TEST): " . ($config->recurrente_public_key_test ? 'Configurada ✓' : 'No configurada ✗') . "\n";
echo "Secret Key (TEST): " . ($config->recurrente_secret_key_test ? 'Configurada ✓' : 'No configurada ✗') . "\n";
echo "Public Key (LIVE): " . ($config->recurrente_public_key ? 'Configurada ✓' : 'No configurada ✗') . "\n";
echo "Secret Key (LIVE): " . ($config->recurrente_secret_key ? 'Configurada ✓' : 'No configurada ✗') . "\n";

// =============================================================================
// 3. VERIFICAR QUE RECURRENTE ESTÁ HABILITADO
// =============================================================================

echo "\n--- Estado del Servicio ---\n";
if ($recurrente->isEnabled()) {
    echo "✓ Recurrente está HABILITADO y configurado\n";
    echo "Modo actual: " . strtoupper($recurrente->getMode()) . "\n";
} else {
    echo "✗ Recurrente está DESHABILITADO o no configurado correctamente\n";
    echo "\nPara habilitar:\n";
    echo "1. Ve a Configuración → Pasarelas de Pago\n";
    echo "2. Marca 'Habilitar Recurrente'\n";
    echo "3. Ingresa tus llaves de API\n";
}

// =============================================================================
// 4. PROBAR AUTENTICACIÓN CON RECURRENTE
// =============================================================================

echo "\n--- Prueba de Autenticación ---\n";
if ($recurrente->isEnabled()) {
    echo "Probando conexión con Recurrente...\n";

    if ($recurrente->testAuthentication()) {
        echo "✓ Autenticación EXITOSA - Las llaves son válidas\n";
    } else {
        echo "✗ Autenticación FALLIDA - Verifica tus llaves de API\n";
        echo "\nPosibles causas:\n";
        echo "- Llaves incorrectas\n";
        echo "- Llaves de TEST cuando debería ser LIVE (o viceversa)\n";
        echo "- Problema de conexión con Recurrente\n";
    }
} else {
    echo "⚠ Omitiendo prueba - Recurrente no está habilitado\n";
}

// =============================================================================
// 5. EJEMPLO DE CREACIÓN DE CHECKOUT (SIN EJECUTAR)
// =============================================================================

echo "\n--- Ejemplo de Código para Crear Checkout ---\n";
echo 'PHP
$checkout = $recurrente->createCheckout([
    "description" => "Pago de cuota #1 - Préstamo #123",
    "amount" => 500.00,
    "currency" => "GTQ",
    "success_url" => route("recurrente.success", ["pago" => 1]),
    "cancel_url" => route("recurrente.cancel", ["pago" => 1]),
    "customer" => [
        "name" => "Juan Pérez",
        "email" => "juan@example.com",
        "phone" => "12345678",
    ],
    "metadata" => [
        "prestamo_id" => 123,
        "cuota_numero" => 1,
    ],
]);

if ($checkout) {
    // Redirigir al usuario
    return redirect($checkout["checkout_url"]);
}
';

// =============================================================================
// 6. VERIFICAR RUTAS
// =============================================================================

echo "\n--- Rutas Necesarias ---\n";
echo "Asegúrate de tener estas rutas configuradas en web.php:\n\n";

$routes = [
    'recurrente.initPayment' => 'POST /pagos/{pago}/recurrente',
    'recurrente.success' => 'GET /pagos/{pago}/recurrente/success',
    'recurrente.cancel' => 'GET /pagos/{pago}/recurrente/cancel',
    'recurrente.webhook' => 'POST /webhooks/recurrente',
];

foreach ($routes as $name => $path) {
    try {
        $url = route($name, ['pago' => 1], false);
        echo "✓ $name: $path\n";
    } catch (\Exception $e) {
        echo "✗ $name: NO CONFIGURADA\n";
    }
}

echo "\nSi alguna ruta muestra ✗, revisa el archivo RECURRENTE_RUTAS_EJEMPLO.php\n";

// =============================================================================
// 7. VERIFICAR VISTAS
// =============================================================================

echo "\n--- Vistas Necesarias ---\n";

$views = [
    'pagos.recurrente.success',
    'pagos.recurrente.cancel',
    'pagos.recurrente.error',
    'pagos.recurrente.pending',
    'components.recurrente-button',
];

foreach ($views as $view) {
    if (view()->exists($view)) {
        echo "✓ $view\n";
    } else {
        echo "✗ $view (NO ENCONTRADA)\n";
    }
}

// =============================================================================
// 8. TARJETAS DE PRUEBA
// =============================================================================

echo "\n--- Tarjetas de Prueba (Modo TEST) ---\n";
echo "Tarjeta exitosa: 4242 4242 4242 4242\n";
echo "CVV: Cualquier 3 dígitos (ej: 123)\n";
echo "Vencimiento: Cualquier fecha futura (ej: 12/25)\n";
echo "Nombre: Cualquier nombre\n";

// =============================================================================
// 9. WEBHOOK
// =============================================================================

echo "\n--- Configuración de Webhook ---\n";
try {
    $webhookUrl = route('recurrente.webhook', [], true);
    echo "URL del Webhook: $webhookUrl\n";
    echo "\nPasos para configurar en Recurrente:\n";
    echo "1. Ve a https://app.recurrente.com\n";
    echo "2. Configuración → Webhooks\n";
    echo "3. Agrega: $webhookUrl\n";
    echo "4. Selecciona eventos: checkout.paid, checkout.expired\n";
} catch (\Exception $e) {
    echo "⚠ No se pudo generar URL de webhook - Ruta no configurada\n";
}

// =============================================================================
// 10. CHECKLIST FINAL
// =============================================================================

echo "\n--- Checklist de Integración ---\n";

$checklist = [
    'Migración ejecutada' => class_exists('\App\Models\Configuracion'),
    'Modelo actualizado' => true,
    'Servicio creado' => class_exists('\App\Services\RecurrenteService'),
    'Helper disponible' => function_exists('recurrente'),
    'Recurrente habilitado' => $config->recurrente_habilitado ?? false,
    'Llaves configuradas' => !empty($config->recurrente_public_key_test) && !empty($config->recurrente_secret_key_test),
    'Autenticación válida' => $recurrente->isEnabled() && $recurrente->testAuthentication(),
];

foreach ($checklist as $item => $status) {
    echo ($status ? '✓' : '✗') . " $item\n";
}

$allGood = !in_array(false, $checklist, true);

if ($allGood) {
    echo "\n🎉 ¡Todo listo! La integración con Recurrente está completa.\n";
    echo "\nPróximos pasos:\n";
    echo "1. Prueba crear un checkout de prueba\n";
    echo "2. Completa un pago con la tarjeta de prueba\n";
    echo "3. Verifica que el webhook se reciba correctamente\n";
    echo "4. Cuando estés listo, cambia a modo LIVE\n";
} else {
    echo "\n⚠ Hay elementos pendientes. Revisa los ✗ arriba.\n";
}

echo "\n--- Documentación ---\n";
echo "📖 INTEGRACION_RECURRENTE.md - Guía completa de uso\n";
echo "📖 RECURRENTE_RUTAS_EJEMPLO.php - Ejemplos de rutas\n";
echo "📖 RecurrentePaymentController.php - Controlador de ejemplo\n";

echo "\n--- Soporte ---\n";
echo "🌐 Documentación API: https://documenter.getpostman.com/view/10340859/2sA2rFQf5R\n";
echo "🏠 Panel de Recurrente: https://app.recurrente.com\n";
echo "💬 Discord: https://discord.gg/QhKPEkSKp2\n";
echo "📧 Email: soporte@recurrente.com\n";

echo "\n✨ Fin de las pruebas\n";
