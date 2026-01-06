<?php

use App\Models\Cliente;
use App\Models\Prestamo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('usuario puede crear un prestamo', function () {
    // Crear usuario y cliente de prueba
    $user = User::factory()->create();
    $cliente = Cliente::factory()->create();

    // Datos del préstamo
    $prestamoData = [
        'cliente_id' => $cliente->id,
        'monto_prestado' => 5000.00,
        'tasa_interes' => 15.00,
        'tipo_interes' => 'simple',
        'plazo' => 12,
        'frecuencia_pago' => 'mensual',
        'fecha_desembolso' => '2024-01-15',
        'tipo_garantia' => 'ninguna',
        'descripcion_garantia' => '',
        'notas' => 'Préstamo de prueba',
    ];

    // Hacer la petición como usuario autenticado
    $response = $this->actingAs($user)
        ->post(route('prestamos.store'), $prestamoData);

    // Verificar que redirige correctamente
    $response->assertRedirect(route('prestamos.index'));

    // Verificar que el préstamo se creó en la base de datos
    $this->assertDatabaseHas('prestamos', [
        'cliente_id' => $cliente->id,
        'monto_prestado' => 5000.00,
        'tasa_interes' => 15.00,
        'tipo_interes' => 'simple',
        'plazo' => 12,
        'frecuencia_pago' => 'mensual',
        'tipo_garantia' => 'ninguna',
        'estado' => 'activo',
    ]);
});
