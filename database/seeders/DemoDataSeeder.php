<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Receta;
use App\Models\RecetaItem;
use App\Models\Cotizacion;
use App\Models\CotizacionItem;
use App\Models\Prestamo;
use App\Models\Pago;
use App\Models\Aportador;
use App\Models\Aportacion;
use App\Models\Contratista;
use App\Models\ContratistaProyecto;
use App\Models\ContratistaArchivo;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🚀 Iniciando carga de datos de demostración...');

        DB::beginTransaction();
        try {
            // 1. Crear usuarios demo
            $this->createDemoUsers();
            
            // 2. Crear clientes
            $clientes = $this->createClientes(20);
            
            // 3. Crear productos
            $productos = $this->createProductos(50);
            
            // 4. Crear recetas
            $recetas = $this->createRecetas($productos, 15);
            
            // 5. Crear cotizaciones
            $cotizaciones = $this->createCotizaciones($clientes, $productos, $recetas, 30);
            
            // 6. Crear aportadores
            $aportadores = $this->createAportadores(10);
            
            // 7. Crear préstamos
            $prestamos = $this->createPrestamos($clientes, $cotizaciones, $aportadores, 25);
            
            // 8. Crear pagos
            $this->createPagos($prestamos, 100);
            
            // 9. Crear contratistas
            $contratistas = $this->createContratistas(15);
            
            // 10. Crear proyectos de contratistas
            $this->createProyectosContratistas($contratistas, 40);

            DB::commit();
            
            $this->command->info('');
            $this->command->info('✅ Datos de demostración cargados exitosamente!');
            $this->command->info('');
            $this->command->info('📊 Resumen:');
            $this->command->info('   - Usuarios: ' . User::where('email', 'LIKE', '%@demo.com')->count());
            $this->command->info('   - Clientes: ' . Cliente::count());
            $this->command->info('   - Productos: ' . Producto::count());
            $this->command->info('   - Recetas: ' . Receta::count());
            $this->command->info('   - Cotizaciones: ' . Cotizacion::count());
            $this->command->info('   - Aportadores: ' . Aportador::count());
            $this->command->info('   - Préstamos: ' . Prestamo::count());
            $this->command->info('   - Pagos: ' . Pago::count());
            $this->command->info('   - Contratistas: ' . Contratista::count());
            $this->command->info('   - Proyectos: ' . ContratistaProyecto::count());
            $this->command->info('');
            $this->command->info('👤 Usuario demo: demo@demo.com / password');
            $this->command->info('');
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('❌ Error al cargar datos: ' . $e->getMessage());
            throw $e;
        }
    }

    private function createDemoUsers()
    {
        $this->command->info('👤 Creando usuarios demo...');
        
        User::firstOrCreate(
            ['email' => 'demo@demo.com'],
            [
                'name' => 'Usuario Demo',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        )->assignRole('Administrador');
    }

    private function createClientes($cantidad)
    {
        $this->command->info('👥 Creando ' . $cantidad . ' clientes...');
        
        $clientes = [];
        $faker = \Faker\Factory::create('es_ES');
        $demoUser = User::where('email', 'demo@demo.com')->first();
        
        $departamentos = ['Guatemala', 'Alta Verapaz', 'Baja Verapaz', 'Chimaltenango', 'Chiquimula', 'El Progreso', 'Escuintla', 'Huehuetenango', 'Izabal', 'Jalapa', 'Jutiapa', 'Petén', 'Quetzaltenango', 'Quiché', 'Retalhuleu', 'Sacatepéquez', 'San Marcos', 'Santa Rosa', 'Sololá', 'Suchitepéquez', 'Totonicapán', 'Zacapa'];
        $municipiosGuate = ['Guatemala', 'Mixco', 'Villa Nueva', 'San Miguel Petapa', 'Villa Canales', 'Amatitlán', 'Chinautla', 'San Juan Sacatepéquez', 'San Pedro Ayampuc', 'Fraijanes'];
        
        for ($i = 0; $i < $cantidad; $i++) {
            $departamento = $faker->randomElement($departamentos);
            $municipio = $departamento == 'Guatemala' ? $faker->randomElement($municipiosGuate) : $faker->city;
            
            $clientes[] = Cliente::create([
                'nombre_completo' => $faker->name,
                'dpi' => $faker->numerify('#############'),
                'fecha_nacimiento' => $faker->dateTimeBetween('-60 years', '-22 years'),
                'genero' => $faker->randomElement(['masculino', 'femenino']),
                'estado_civil' => $faker->randomElement(['soltero', 'casado', 'union_libre', 'divorciado', 'viudo']),
                'telefono' => $faker->numerify('+502 ####-####'),
                'telefono_alternativo' => $faker->optional(0.6)->numerify('+502 ####-####'),
                'email' => $faker->unique()->safeEmail,
                'departamento' => $departamento,
                'municipio' => $municipio,
                'direccion_completa' => $faker->address,
                'zona' => $departamento == 'Guatemala' ? $faker->numberBetween(1, 25) : null,
                'profesion' => $faker->randomElement(['Ingeniero', 'Contador', 'Médico', 'Maestro', 'Comerciante', 'Abogado', 'Arquitecto', 'Albañil', 'Electricista', 'Plomero']),
                'lugar_trabajo' => $faker->company,
                'puesto_trabajo' => $faker->randomElement(['Gerente', 'Supervisor', 'Técnico', 'Asistente', 'Operario', 'Administrador']),
                'ingreso_mensual' => $faker->randomFloat(2, 3000, 15000),
                'referencia_nombre_1' => $faker->name,
                'referencia_telefono_1' => $faker->numerify('+502 ####-####'),
                'referencia_parentesco_1' => $faker->randomElement(['Padre', 'Madre', 'Hermano', 'Hermana', 'Tío', 'Tía', 'Amigo', 'Vecino']),
                'referencia_nombre_2' => $faker->optional(0.7)->name,
                'referencia_telefono_2' => $faker->optional(0.7)->numerify('+502 ####-####'),
                'referencia_parentesco_2' => $faker->optional(0.7)->randomElement(['Padre', 'Madre', 'Hermano', 'Hermana', 'Tío', 'Tía', 'Amigo', 'Vecino']),
                'estado' => $faker->randomElement(['activo', 'activo', 'activo', 'inactivo']), // 75% activos
                'notas' => $faker->optional(0.3)->sentence,
                'user_id' => $demoUser->id,
            ]);
        }
        
        return $clientes;
    }

    private function createProductos($cantidad)
    {
        $this->command->info('📦 Creando ' . $cantidad . ' productos...');
        
        $productos = [];
        $categorias = ['Cemento', 'Varilla', 'Block', 'Arena', 'Piedrin', 'Madera', 'Puertas', 'Ventanas', 'Pintura', 'Electricidad', 'Plomería'];
        $unidades = ['unidad', 'saco', 'metro', 'metro cuadrado', 'galon', 'libra', 'quintal', 'm3', 'm2'];
        $marcas = ['Progreso', 'Cementos Tolteca', 'Gypsum', 'Lafarge', 'CEMEX', 'Holcim', 'Ferreterías El Constructor', 'Aceros de Guatemala', 'Materiales Pérez'];
        $demoUser = User::where('email', 'demo@demo.com')->first();
        
        $nombresProductos = [
            'Cemento Portland 50kg', 'Varilla 3/8"', 'Varilla 1/2"', 'Block 15x20x40',
            'Block 10x20x40', 'Arena de río m³', 'Piedrin m³', 'Cal hidratada',
            'Tabla 1x12x10', 'Regla 2x4x10', 'Puerta tambor 80x200',
            'Ventana aluminio 1x1', 'Pintura latex galon', 'Pintura aceite galon',
            'Cable eléctrico 12 AWG', 'Cable eléctrico 14 AWG', 'Tubo PVC 1/2"',
            'Tubo PVC 3/4"', 'Llave lavamanos', 'Llave fregadero',
            'Inodoro blanco', 'Lavamanos', 'Cerámica 33x33', 'Cerámica 40x40',
            'Alambre de amarre', 'Clavo 2"', 'Clavo 3"', 'Tornillo 1/4"',
            'Bisagra 3"', 'Chapa de seguridad', 'Candado', 'Zinc liso calibre 26',
            'Zinc ondulado', 'Teja francesa', 'Panel yeso 4x8', 'Masilla',
            'Lija para madera', 'Lija para pared', 'Thinner galon', 'Diluyente',
            'Brocha 2"', 'Brocha 4"', 'Rodillo 9"', 'Plafón',
            'Foco LED 9W', 'Foco LED 15W', 'Tubo fluorescente', 'Socket',
            'Interruptor simple', 'Interruptor doble'
        ];
        
        for ($index = 0; $index < min(count($nombresProductos), $cantidad); $index++) {
            $nombre = $nombresProductos[$index];
            $categoria = $categorias[array_rand($categorias)];
            $unidad = $unidades[array_rand($unidades)];
            $marca = $marcas[array_rand($marcas)];
            
            $productos[] = Producto::create([
                'codigo' => 'PROD-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                'nombre' => $nombre,
                'categoria' => $categoria,
                'descripcion' => 'Producto de alta calidad para construcción',
                'unidad_medida' => $unidad,
                'precio_unitario' => rand(10, 500) + (rand(0, 99) / 100),
                'stock_actual' => rand(10, 500),
                'stock_minimo' => rand(5, 20),
                'marca' => $marca,
                'estado' => 'activo',
                'user_id' => $demoUser->id,
            ]);
        }
        
        return $productos;
    }

    private function createRecetas($productos, $cantidad)
    {
        $this->command->info('📋 Creando ' . $cantidad . ' recetas...');
        
        $recetas = [];
        $faker = \Faker\Factory::create('es_ES');
        $demoUser = User::where('email', 'demo@demo.com')->first();
        
        // Asegurar que $productos sea una colección
        $productosCollection = collect($productos);
        
        $tiposReceta = [
            'Casa de 1 nivel 6x8 mts',
            'Casa de 2 niveles 8x10 mts',
            'Ampliación habitación 4x4 mts',
            'Construcción cocina 3x4 mts',
            'Baño completo 2x3 mts',
            'Muro perimetral 30 mts lineales',
            'Piso cerámico 50 m²',
            'Techo zinc 60 m²',
            'Repello y cernido 100 m²',
            'Instalación eléctrica básica',
            'Instalación plomería completa',
            'Puertas y ventanas casa pequeña',
            'Pintura interior 100 m²',
            'Construcción tanque elevado',
            'Fundición losa 40 m²',
        ];
        
        foreach ($tiposReceta as $index => $nombre) {
            $receta = Receta::create([
                'nombre' => $nombre,
                'descripcion' => 'Material necesario para ' . strtolower($nombre),
                'tipo_vivienda' => $faker->randomElement(['casa_basica', 'casa_mediana', 'casa_grande', 'ampliacion']),
                'estado' => 'activo',
                'user_id' => $demoUser->id,
            ]);
            
            // Agregar items a la receta (5-15 productos)
            $cantidadItems = rand(5, 15);
            $productosSeleccionados = $productosCollection->random($cantidadItems);
            
            foreach ($productosSeleccionados as $producto) {
                $cantidad = rand(1, 20) + (rand(0, 50) / 100);
                $precioUnitario = $producto->precio_unitario;
                $subtotal = $cantidad * $precioUnitario;
                
                RecetaItem::create([
                    'receta_id' => $receta->id,
                    'producto_id' => $producto->id,
                    'cantidad' => $cantidad,
                    'precio_unitario' => $precioUnitario,
                    'subtotal' => $subtotal,
                ]);
            }
            
            $recetas[] = $receta;
        }
        
        return collect($recetas);
    }

    private function createCotizaciones($clientes, $productos, $recetas, $cantidad)
    {
        $this->command->info('💰 Creando ' . $cantidad . ' cotizaciones...');
        
        $cotizaciones = [];
        $faker = \Faker\Factory::create('es_ES');
        
        // Asegurar que sean colecciones
        $productosCollection = collect($productos);
        
        for ($i = 0; $i < $cantidad; $i++) {
            $cliente = $clientes[array_rand($clientes)];
            $tipoVenta = $faker->randomElement(['contado', 'credito', 'credito']);
            $esReceta = rand(1, 10) > 5; // 50% con receta
            
            $subtotal = 0;
            
            $fechaEmision = Carbon::now()->subDays(rand(1, 90));
            $fechaVencimiento = $fechaEmision->copy()->endOfMonth();
            
            $cotizacion = Cotizacion::create([
                'cliente_id' => $cliente->id,
                'user_id' => 1,
                'numero_cotizacion' => 'COT-2026-' . str_pad($i + 1, 5, '0', STR_PAD_LEFT),
                'fecha_emision' => $fechaEmision,
                'fecha_vencimiento' => $fechaVencimiento,
                'descuento' => rand(0, 10),
                'estado' => $faker->randomElement(['pendiente', 'aprobada', 'rechazada', 'convertida']),
            ]);
            
            // Agregar items (productos o receta)
            if ($esReceta && $recetas->isNotEmpty()) {
                $receta = $recetas->random();
                $cotizacion->update(['receta_id' => $receta->id]);
                
                foreach ($receta->items as $recetaItem) {
                    $precioUnitario = $recetaItem->producto->precio_unitario;
                    $cantidad = $recetaItem->cantidad;
                    $total = $precioUnitario * $cantidad;
                    $subtotal += $total;
                    
                    CotizacionItem::create([
                        'cotizacion_id' => $cotizacion->id,
                        'producto_id' => $recetaItem->producto_id,
                        'descripcion' => $recetaItem->producto->nombre,
                        'unidad' => $recetaItem->producto->unidad_medida,
                        'cantidad' => $cantidad,
                        'precio_unitario' => $precioUnitario,
                        'subtotal' => $total,
                    ]);
                }
            } else {
                // Items individuales
                $cantidadItems = rand(3, 10);
                $productosSeleccionados = $productosCollection->random($cantidadItems);
                
                foreach ($productosSeleccionados as $producto) {
                    $cantidad = rand(1, 20);
                    $precioUnitario = $producto->precio_unitario;
                    $total = $precioUnitario * $cantidad;
                    $subtotal += $total;
                    
                    CotizacionItem::create([
                        'cotizacion_id' => $cotizacion->id,
                        'producto_id' => $producto->id,
                        'descripcion' => $producto->nombre,
                        'unidad' => $producto->unidad_medida,
                        'cantidad' => $cantidad,
                        'precio_unitario' => $precioUnitario,
                        'subtotal' => $total,
                    ]);
                }
            }
            
            // Calcular totales
            $descuentoMonto = ($subtotal * $cotizacion->descuento) / 100;
            $total = $subtotal - $descuentoMonto;
            
            $cotizacion->update([
                'subtotal' => $subtotal,
                'total' => $total,
            ]);
            
            $cotizaciones[] = $cotizacion;
        }
        
        return collect($cotizaciones);
    }

    private function createAportadores($cantidad)
    {
        $this->command->info('💵 Creando ' . $cantidad . ' aportadores/inversionistas...');
        
        $aportadores = [];
        $faker = \Faker\Factory::create('es_ES');
        $demoUser = User::where('email', 'demo@demo.com')->first();
        
        for ($i = 0; $i < $cantidad; $i++) {
            $capitalDisponible = rand(50000, 500000);
            $capitalInvertido = rand(0, $capitalDisponible * 0.3);
            
            $aportadores[] = Aportador::create([
                'nombre' => $faker->name,
                'dpi' => $faker->numerify('#############'),
                'nit' => $faker->numerify('########-#'),
                'telefono' => $faker->numerify('####-####'),
                'email' => $faker->unique()->safeEmail,
                'direccion' => $faker->address,
                'capital_disponible' => $capitalDisponible,
                'capital_invertido' => $capitalInvertido,
                'ganancias_totales' => rand(0, 50000),
                'estado' => 'Activo',
                'usuario_id' => $demoUser->id,
            ]);
        }
        
        return collect($aportadores);
    }

    private function createPrestamos($clientes, $cotizaciones, $aportadores, $cantidad)
    {
        $this->command->info('🏦 Creando ' . $cantidad . ' préstamos...');
        
        $prestamos = [];
        $faker = \Faker\Factory::create('es_ES');
        
        // Convertir algunas cotizaciones aprobadas en préstamos
        $cotizacionesConvertibles = $cotizaciones->where('estado', 'aprobada')->take(10);
        
        foreach ($cotizacionesConvertibles as $cotizacion) {
            // Monto prestado será entre 50-90% del total de la cotización
            $montoPrestado = $cotizacion->total * (rand(50, 90) / 100);
            
            $prestamo = $this->crearPrestamo(
                $cotizacion->cliente,
                $montoPrestado,
                $aportadores,
                $cotizacion
            );
            
            // Marcar cotización como convertida
            $cotizacion->update([
                'estado' => 'convertida',
                'prestamo_id' => $prestamo->id,
            ]);
            
            $prestamos[] = $prestamo;
        }
        
        // Crear préstamos adicionales sin cotización
        $prestamosRestantes = $cantidad - count($prestamos);
        
        for ($i = 0; $i < $prestamosRestantes; $i++) {
            $cliente = $clientes[array_rand($clientes)];
            $montoPrestado = rand(5000, 100000);
            
            $prestamos[] = $this->crearPrestamo(
                $cliente,
                $montoPrestado,
                $aportadores,
                null
            );
        }
        
        return collect($prestamos);
    }

    private function crearPrestamo($cliente, $montoPrestado, $aportadores, $cotizacion = null)
    {
        $faker = \Faker\Factory::create('es_ES');
        
        // Generar número de préstamo
        $year = date('Y');
        $lastPrestamo = Prestamo::withTrashed()
            ->where('numero_prestamo', 'like', "P-{$year}-%")
            ->orderBy('numero_prestamo', 'desc')
            ->first();
        
        $nextNumber = $lastPrestamo ? ((int) substr($lastPrestamo->numero_prestamo, -5)) + 1 : 1;
        $numeroPrestamo = 'P-' . $year . '-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
        
        // Datos del préstamo
        $tasaInteres = rand(18, 30);
        $tipoInteres = $faker->randomElement(['simple', 'compuesto']);
        $plazo = rand(6, 24);
        $frecuenciaPago = $faker->randomElement(['semanal', 'quincenal', 'mensual']);
        $fechaDesembolso = Carbon::now()->subDays(rand(10, 180));
        
        // Calcular interés y cuota
        if ($tipoInteres === 'simple') {
            $interesTotal = $montoPrestado * ($tasaInteres / 100) * ($plazo / 12);
        } else {
            $interesTotal = $montoPrestado * (pow(1 + ($tasaInteres / 1200), $plazo) - 1);
        }
        
        $montoTotal = $montoPrestado + $interesTotal;
        $montoCuota = $montoTotal / $plazo;
        
        // Calcular fechas
        switch ($frecuenciaPago) {
            case 'semanal':
                $fechaPrimerPago = $fechaDesembolso->copy()->addWeek();
                $fechaUltimoPago = $fechaDesembolso->copy()->addWeeks($plazo);
                break;
            case 'quincenal':
                $fechaPrimerPago = $fechaDesembolso->copy()->addWeeks(2);
                $fechaUltimoPago = $fechaDesembolso->copy()->addWeeks($plazo * 2);
                break;
            default: // mensual
                $fechaPrimerPago = $fechaDesembolso->copy()->addMonth();
                $fechaUltimoPago = $fechaDesembolso->copy()->addMonths($plazo);
        }
        
        // Crear préstamo
        $prestamo = Prestamo::create([
            'cliente_id' => $cliente->id,
            'user_id' => 1,
            'numero_prestamo' => $numeroPrestamo,
            'monto_prestado' => $montoPrestado,
            'tasa_interes' => $tasaInteres,
            'tipo_interes' => $tipoInteres,
            'interes_total' => $interesTotal,
            'monto_total' => $montoTotal,
            'monto_cuota' => $montoCuota,
            'plazo' => $plazo,
            'frecuencia_pago' => $frecuenciaPago,
            'fecha_desembolso' => $fechaDesembolso,
            'fecha_primer_pago' => $fechaPrimerPago,
            'fecha_ultimo_pago' => $fechaUltimoPago,
            'saldo_pendiente' => $montoTotal,
            'tipo_garantia' => $faker->randomElement(['ninguna', 'prenda', 'hipoteca', 'fiador']),
            'descripcion_garantia' => $faker->sentence(),
            'estado' => $faker->randomElement(['activo', 'activo', 'activo', 'pagado', 'en_mora']),
        ]);
        
        // Asignar aportadores para fondear el préstamo
        $aportadoresDisponibles = $aportadores->where('capital_disponible', '>', 0)->shuffle();
        $montoRestante = $montoPrestado;
        
        foreach ($aportadoresDisponibles as $aportador) {
            if ($montoRestante <= 0) break;
            
            $montoAportar = min($montoRestante, $aportador->capital_disponible * 0.5);
            $montoAportar = round($montoAportar, 2);
            
            if ($montoAportar > 0) {
                // Calcular ganancia proporcional
                $porcentajeParticipacion = ($montoAportar / $montoPrestado) * 100;
                $interesesEstimados = ($interesTotal * $porcentajeParticipacion) / 100;
                
                Aportacion::create([
                    'prestamo_id' => $prestamo->id,
                    'aportador_id' => $aportador->id,
                    'monto_aportado' => $montoAportar,
                    'porcentaje_participacion' => $porcentajeParticipacion,
                    'intereses_ganados' => 0,
                    'monto_recuperado' => 0,
                    'saldo_pendiente' => $montoAportar,
                    'fecha_aportacion' => $fechaDesembolso,
                    'estado' => 'Activo',
                ]);
                
                // Actualizar capital del aportaddr
                $aportador->capital_disponible -= $montoAportar;
                $aportador->capital_invertido += $montoAportar;
                $aportador->save();
                
                $montoRestante -= $montoAportar;
            }
        }
        
        return $prestamo;
    }

    private function createPagos($prestamos, $cantidadMax)
    {
        $this->command->info('💳 Creando pagos...');
        
        $totalPagos = 0;
        $faker = \Faker\Factory::create('es_ES');
        
        foreach ($prestamos as $prestamo) {
            if ($prestamo->estado === 'pagado') {
                // Préstamos completados tienen todos sus pagos
                $numeroPagos = $prestamo->plazo;
            } elseif ($prestamo->estado === 'activo') {
                // Préstamos activos tienen algunos pagos
                $numeroPagos = rand(1, min($prestamo->plazo - 1, 10));
            } else {
                continue; // Préstamos en mora o pendientes sin pagos
            }
            
            $fechaVencimiento = Carbon::parse($prestamo->fecha_primer_pago);
            $saldoActual = $prestamo->monto_total;
            
            for ($i = 0; $i < $numeroPagos && $totalPagos < $cantidadMax; $i++) {
                // Generar número de recibo único
                $year = date('Y');
                $numeroRecibo = 'REC-' . $year . '-' . str_pad($totalPagos + 1, 6, '0', STR_PAD_LEFT);
                
                // Calcular si el pago es atrasado (20% de probabilidad)
                $diasAtraso = rand(0, 100) > 80 ? rand(1, 15) : 0;
                $fechaPago = $fechaVencimiento->copy()->addDays($diasAtraso);
                
                // Calcular mora si hay atraso
                $mora = $diasAtraso > 0 ? rand(50, 500) : 0;
                
                // Estado del pago
                $estadoPago = $diasAtraso > 0 ? 'atrasado' : 'puntual';
                
                // Monto a pagar
                $montoPagado = $prestamo->monto_cuota;
                $saldoNuevo = $saldoActual - $montoPagado;
                
                Pago::create([
                    'numero_recibo' => $numeroRecibo,
                    'prestamo_id' => $prestamo->id,
                    'cliente_id' => $prestamo->cliente_id,
                    'user_id' => 1,
                    'numero_cuota' => $i + 1,
                    'monto_cuota_esperado' => $prestamo->monto_cuota,
                    'monto_pagado' => $montoPagado,
                    'mora' => $mora,
                    'fecha_vencimiento' => $fechaVencimiento->copy(),
                    'fecha_pago' => $fechaPago,
                    'dias_atraso' => $diasAtraso,
                    'estado' => $estadoPago,
                    'tipo_pago' => $faker->randomElement(['efectivo', 'transferencia', 'cheque', 'deposito']),
                    'saldo_anterior' => $saldoActual,
                    'saldo_nuevo' => $saldoNuevo,
                    'observaciones' => $mora > 0 ? 'Pago con mora' : null,
                ]);
                
                // Actualizar saldo para el siguiente pago
                $saldoActual = $saldoNuevo;
                
                // Siguiente fecha según frecuencia
                switch ($prestamo->frecuencia_pago) {
                    case 'semanal':
                        $fechaVencimiento->addWeek();
                        break;
                    case 'quincenal':
                        $fechaVencimiento->addWeeks(2);
                        break;
                    default:
                        $fechaVencimiento->addMonth();
                }
                
                $totalPagos++;
            }
            
            // Actualizar préstamo
            $prestamo->saldo_pendiente = $saldoActual;
            if ($prestamo->estado === 'pagado') {
                $prestamo->saldo_pendiente = 0;
            }
            $prestamo->save();
        }
        
        $this->command->info('   Total de pagos creados: ' . $totalPagos);
    }

    private function createContratistas($cantidad)
    {
        $this->command->info('👷 Creando ' . $cantidad . ' contratistas...');
        
        $contratistas = [];
        $faker = \Faker\Factory::create('es_ES');
        
        $especialidades = [
            'Construcción de viviendas',
            'Construcción comercial',
            'Remodelaciones integrales',
            'Acabados y pintura',
            'Instalaciones eléctricas',
            'Instalaciones de plomería',
            'Techos y cubiertas',
            'Albañilería general',
            'Herrería y metal',
            'Carpintería',
        ];
        
        for ($i = 0; $i < $cantidad; $i++) {
            $contratistas[] = Contratista::create([
                'codigo' => 'CONT-' . date('Y') . '-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'nombre_completo' => $faker->name,
                'nombre_empresa' => rand(0, 10) > 5 ? $faker->company : null,
                'dpi' => $faker->numerify('#############'),
                'nit' => $faker->numerify('########-#'),
                'direccion' => $faker->address,
                'municipio' => $faker->city,
                'departamento' => $faker->randomElement(['Guatemala', 'Sacatepéquez', 'Escuintla', 'Chimaltenango']),
                'telefono1' => $faker->numerify('####-####'),
                'telefono2' => rand(0, 10) > 5 ? $faker->numerify('####-####') : null,
                'email' => $faker->safeEmail,
                'especialidad' => $especialidades[array_rand($especialidades)],
                'tipo_servicio' => $faker->randomElement(['construccion', 'remodelacion', 'ambos']),
                'servicios_ofrecidos' => $faker->sentence(10),
                'anos_experiencia' => rand(2, 25),
                'calificacion' => rand(30, 50) / 10, // 3.0 a 5.0
                'estado' => $faker->randomElement(['activo', 'activo', 'activo', 'inactivo']),
            ]);
        }
        
        return collect($contratistas);
    }

    private function createProyectosContratistas($contratistas, $cantidad)
    {
        $this->command->info('🏗️  Creando ' . $cantidad . ' proyectos...');
        
        $faker = \Faker\Factory::create('es_ES');
        
        $nombresProyectos = [
            'Casa de habitación sector norte',
            'Ampliación residencia familiar',
            'Construcción muro perimetral',
            'Remodelación cocina y baño',
            'Segunda planta vivienda',
            'Local comercial',
            'Bodega industrial',
            'Techo nuevo vivienda',
            'Repello y pintura exterior',
            'Instalación eléctrica completa',
        ];
        
        $proyectosCreados = 0;
        
        foreach ($contratistas as $contratista) {
            $numeroProyectos = rand(1, 5);
            
            for ($i = 0; $i < $numeroProyectos && $proyectosCreados < $cantidad; $i++) {
                $fechaInicio = Carbon::now()->subDays(rand(30, 730));
                $duracionDias = rand(15, 180);
                $fechaFin = $fechaInicio->copy()->addDays($duracionDias);
                $estado = $fechaFin->isPast() ? 'completado' : $faker->randomElement(['en_proceso', 'en_proceso', 'completado']);
                
                ContratistaProyecto::create([
                    'contratista_id' => $contratista->id,
                    'nombre_proyecto' => $nombresProyectos[array_rand($nombresProyectos)],
                    'descripcion' => $faker->sentence(12),
                    'ubicacion' => $faker->city . ', ' . $faker->randomElement(['Guatemala', 'Sacatepéquez', 'Escuintla']),
                    'cliente' => $faker->name,
                    'tipo_proyecto' => $faker->randomElement(['construccion_nueva', 'remodelacion', 'ampliacion', 'otro']),
                    'monto_proyecto' => rand(10000, 250000),
                    'fecha_inicio' => $fechaInicio,
                    'fecha_fin' => $estado === 'completado' ? $fechaFin : null,
                    'estado' => $estado,
                    'duracion_dias' => $estado === 'completado' ? $duracionDias : null,
                    'materiales_utilizados' => 'Cemento, varilla, block, arena, piedrin',
                ]);
                
                $proyectosCreados++;
            }
        }
    }
}
