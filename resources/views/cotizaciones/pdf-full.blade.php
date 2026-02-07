<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotización {{ $cotizacion->numero_cotizacion }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        .info-section {
            margin-bottom: 20px;
        }
        .info-row {
            display: flex;
            margin-bottom: 5px;
        }
        .info-label {
            font-weight: bold;
            width: 150px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .totales {
            margin-top: 20px;
            float: right;
            width: 300px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
        }
        .total-row.grand-total {
            font-weight: bold;
            font-size: 14px;
            border-top: 2px solid #333;
            padding-top: 10px;
        }
        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }
        .financing-section {
            margin-top: 40px;
            page-break-before: always;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #333;
            border-bottom: 1px solid #333;
            padding-bottom: 5px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>COTIZACIÓN</h1>
        <p>{{ $cotizacion->numero_cotizacion }}</p>
    </div>

    <div class="info-section">
        <h3>Información del Cliente</h3>
        <div class="info-row">
            <span class="info-label">Cliente:</span>
            <span>{{ $cotizacion->cliente->nombre_completo }}</span>
        </div>
        @if($cotizacion->cliente->email)
        <div class="info-row">
            <span class="info-label">Email:</span>
            <span>{{ $cotizacion->cliente->email }}</span>
        </div>
        @endif
        @if($cotizacion->cliente->telefono)
        <div class="info-row">
            <span class="info-label">Teléfono:</span>
            <span>{{ $cotizacion->cliente->telefono }}</span>
        </div>
        @endif
        @if($cotizacion->cliente->direccion)
        <div class="info-row">
            <span class="info-label">Dirección:</span>
            <span>{{ $cotizacion->cliente->direccion }}</span>
        </div>
        @endif
    </div>

    <div class="info-section">
        <h3>Información de la Cotización</h3>
        <div class="info-row">
            <span class="info-label">Fecha de Emisión:</span>
            <span>{{ $cotizacion->fecha_emision->format('d/m/Y') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Fecha de Vencimiento:</span>
            <span>{{ $cotizacion->fecha_vencimiento->format('d/m/Y') }}</span>
        </div>
        @if($cotizacion->receta)
        <div class="info-row">
            <span class="info-label">Plan de Construcción:</span>
            <span>{{ $cotizacion->receta->nombre }}</span>
        </div>
        @endif
        <div class="info-row">
            <span class="info-label">Estado:</span>
            <span style="text-transform: uppercase;">{{ $cotizacion->estado }}</span>
        </div>
    </div>

    <h3 class="section-title">Productos/Servicios</h3>
    <table>
        <thead>
            <tr>
                <th>Descripción</th>
                <th class="text-right">Cantidad</th>
                <th>Unidad</th>
                <th class="text-right">Precio Unit.</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cotizacion->items as $item)
            <tr>
                <td>{{ $item->descripcion }}</td>
                <td class="text-right">{{ number_format($item->cantidad, 2) }}</td>
                <td>{{ $item->unidad }}</td>
                <td class="text-right">Q{{ number_format($item->precio_unitario, 2) }}</td>
                <td class="text-right">Q{{ number_format($item->subtotal, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="clearfix">
        <div class="totales">
            <div class="total-row">
                <span>Subtotal:</span>
                <span>Q{{ number_format($cotizacion->subtotal, 2) }}</span>
            </div>
            @if($cotizacion->descuento > 0)
            <div class="total-row">
                <span>Descuento:</span>
                <span>Q{{ number_format($cotizacion->descuento, 2) }}</span>
            </div>
            @endif
            <div class="total-row grand-total">
                <span>TOTAL:</span>
                <span>Q{{ number_format($cotizacion->total, 2) }}</span>
            </div>
        </div>
    </div>

    @if($planPagos && count($planPagos) > 0)
    <div class="financing-section">
        <h3 class="section-title">Plan de Financiamiento</h3>

        <div class="info-section">
            <div class="info-row">
                <span class="info-label">Monto Total:</span>
                <span>Q{{ number_format($cotizacion->total, 2) }}</span>
            </div>
            @if($cotizacion->enganche > 0)
            <div class="info-row">
                <span class="info-label">Enganche:</span>
                <span>Q{{ number_format($cotizacion->enganche, 2) }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Monto a Financiar:</span>
                <span>Q{{ number_format($cotizacion->total - $cotizacion->enganche, 2) }}</span>
            </div>
            @else
            <div class="info-row">
                <span class="info-label">Monto a Financiar:</span>
                <span>Q{{ number_format($cotizacion->total, 2) }}</span>
            </div>
            @endif
            <div class="info-row">
                <span class="info-label">Plazo:</span>
                <span>{{ $cotizacion->plazo_meses }} meses</span>
            </div>
            <div class="info-row">
                <span class="info-label">Tasa de Interés:</span>
                <span>{{ number_format($cotizacion->tasa_interes_anual, 2) }}% anual</span>
            </div>
            <div class="info-row">
                <span class="info-label">Cuota Mensual:</span>
                <span>Q{{ number_format($planPagos[0]['cuota'], 2) }}</span>
            </div>
        </div>

        <h4>Tabla de Amortización</h4>
        <table>
            <thead>
                <tr>
                    <th class="text-right">Mes</th>
                    <th class="text-right">Cuota</th>
                    <th class="text-right">Capital</th>
                    <th class="text-right">Interés</th>
                    <th class="text-right">Saldo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($planPagos as $pago)
                <tr>
                    <td class="text-right">{{ $pago['mes'] }}</td>
                    <td class="text-right">Q{{ number_format($pago['cuota'], 2) }}</td>
                    <td class="text-right">Q{{ number_format($pago['capital'], 2) }}</td>
                    <td class="text-right">Q{{ number_format($pago['interes'], 2) }}</td>
                    <td class="text-right">Q{{ number_format($pago['saldo'], 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr style="font-weight: bold; background-color: #f8f9fa;">
                    <td class="text-right">TOTALES</td>
                    <td class="text-right">Q{{ number_format(array_sum(array_column($planPagos, 'cuota')), 2) }}</td>
                    <td class="text-right">Q{{ number_format(array_sum(array_column($planPagos, 'capital')), 2) }}</td>
                    <td class="text-right">Q{{ number_format(array_sum(array_column($planPagos, 'interes')), 2) }}</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
    @endif

    @if($cotizacion->notas)
    <div class="info-section">
        <h3>Notas</h3>
        <p>{{ $cotizacion->notas }}</p>
    </div>
    @endif

    @if($cotizacion->terminos_condiciones)
    <div class="info-section">
        <h3>Términos y Condiciones</h3>
        <p>{{ $cotizacion->terminos_condiciones }}</p>
    </div>
    @endif

    <div class="footer">
        <p>Generado el {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</body>
</html>
