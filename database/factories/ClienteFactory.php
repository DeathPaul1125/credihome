<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cliente>
 */
class ClienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre_completo' => $this->faker->name(),
            'dpi' => $this->faker->unique()->numerify('#############'),
            'telefono' => $this->faker->phoneNumber(),
            'direccion' => $this->faker->address(),
            'email' => $this->faker->unique()->safeEmail(),
            'fecha_nacimiento' => $this->faker->date('Y-m-d', '-18 years'),
            'estado_civil' => $this->faker->randomElement(['soltero', 'casado', 'divorciado', 'viudo']),
            'ocupacion' => $this->faker->jobTitle(),
            'ingresos_mensuales' => $this->faker->numberBetween(2000, 10000),
            'referencias_personales' => $this->faker->name() . ' - ' . $this->faker->phoneNumber(),
            'estado' => 'activo',
        ];
    }
}
