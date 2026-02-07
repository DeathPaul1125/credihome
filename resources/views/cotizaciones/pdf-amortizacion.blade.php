<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Amortización - {{ $cotizacion->numero_cotizacion }}</title>
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
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }
        .info-row {
            display: flex;
            margin-bottom: 8px;
        }
        .info-label {
            font-weight: bold;
            width: 180px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: right;
        }
        th {
            background-color: #4a5568;
            color: white;
            font-weight: bold;
        }
        tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        tbody tr:hover {
            background-color: #e2e8f0;
        }
        tfoot tr {
            font-weight: bold;
            background-color: #cbd5e0;
            font-size: 13px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
        .summary-box {
            background-color: #edf2f7;
            border-left: 4px solid #4a5568;
            padding: 15px;
            margin-bottom: 20px;
        }
        .summary-item {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
        }
        .summary-item.highlight {
            font-weight: bold;
            font-size: 14px;
            color: #2d3748;
            border-top: 2px solid #4a5568;
            padding-top: 10px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>TABLA DE AMORTIZACIÓN</h1>
        <p>{{ $cotizacion->numero_cotizacion }}</p>
    </div>

    <div class="info-section">
        <h3 style="margin-top: 0;">Información del Cliente</h3>
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
    </div>

    <div class="summary-box">
        <h3 style="margin-top: 0;">Resumen del Financiamiento</h3>
        <div class="summary-item">
            <span>Monto Total:</span>
            <span>Q{{ number_format($cotizacion->total, 2) }}</span>
        </div>
        @if($cotizacion->enganche > 0)
        <div class="summary-item">
            <span>Enganche:</span>
            <span>Q{{ number_format($cotizacion->enganche, 2) }}</span>
        </div>
        <div class="summary-item">
            <span>Monto a Financiar:</span>
            <span>Q{{ number_format($cotizacion->total - $cotizacion->enganche, 2) }}</span>
        </div>
        @else
        <div class="summary-item">
            <span>Monto a Financiar:</span>
            <span>Q{{ number_format($cotizacion->total, 2) }}</span>
        </div>
        @endif
        <div class="summary-item">
            <span>Plazo:</span>
            <span>{{ $cotizacion->plazo_meses }} meses</span>
        </div>
        <div class="summary-item">
            <span>Tasa de Interés Anual:</span>
            <span>{{ number_format($cotizacion->tasa_interes_anual, 2) }}%</span>
        </div>
        <div class="summary-item">
            <span>Tasa de Interés Mensual:</span>
            <span>{{ number_format($cotizacion->tasa_interes_anual / 12, 2) }}%</span>
        </div>
        <div class="summary-item highlight">
            <span>Cuota Mensual:</span>
            <span>Q{{ number_format($planPagos[0]['cuota'], 2) }}</span>
        </div>
        <div class="summary-item highlight">
            <span>Total a Pagar:</span>
            <span>Q{{ number_format(array_sum(array_column($planPagos, 'cuota')), 2) }}</span>
        </div>
        <div class="summary-item">
            <span>Total de Intereses:</span>
            <span>Q{{ number_format(array_sum(array_column($planPagos, 'interes')), 2) }}</span>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Mes</th>
                <th>Cuota</th>
                <th>Capital</th>
                <th>Interés</th>
                <th>Saldo Restante</th>
            </tr>
        </thead>
        <tbody>
            @foreach($planPagos as $pago)
            <tr>
                <td>{{ $pago['mes'] }}</td>
                <td>Q{{ number_format($pago['cuota'], 2) }}</td>
                <td>Q{{ number_format($pago['capital'], 2) }}</td>
                <td>Q{{ number_format($pago['interes'], 2) }}</td>
                <td>Q{{ number_format($pago['saldo'], 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td>TOTALES</td>
                <td>Q{{ number_format(array_sum(array_column($planPagos, 'cuota')), 2) }}</td>
                <td>Q{{ number_format(array_sum(array_column($planPagos, 'capital')), 2) }}</td>
                <td>Q{{ number_format(array_sum(array_column($planPagos, 'interes')), 2) }}</td>
                <td></td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p><strong>Nota:</strong> Esta tabla de amortización es una estimación basada en el sistema francés de pagos fijos.</p>
        <p>Generado el {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>
