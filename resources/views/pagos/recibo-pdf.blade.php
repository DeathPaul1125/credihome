<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Recibo de Pago #{{ $pago->numero_recibo ?? $pago->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            color: #333;
            line-height: 1.4;
        }

        .container {
            max-width: 750px;
            margin: 0 auto;
            padding: 30px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #2563eb;
        }

        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 5px;
        }

        .document-title {
            font-size: 18px;
            font-weight: bold;
            color: #374151;
            margin-top: 15px;
        }

        .receipt-number {
            font-size: 14px;
            color: #6b7280;
            margin-top: 5px;
        }

        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 25px;
        }

        .info-row {
            display: table-row;
        }

        .info-label {
            display: table-cell;
            padding: 8px 10px;
            font-weight: bold;
            background-color: #f3f4f6;
            border: 1px solid #e5e7eb;
            width: 35%;
        }

        .info-value {
            display: table-cell;
            padding: 8px 10px;
            border: 1px solid #e5e7eb;
            width: 65%;
        }

        .section {
            margin-bottom: 25px;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 2px solid #e5e7eb;
        }

        .amount-box {
            background-color: #dbeafe;
            border: 2px solid #3b82f6;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin: 25px 0;
        }

        .amount-label {
            font-size: 12px;
            color: #1e40af;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .amount-value {
            font-size: 32px;
            font-weight: bold;
            color: #1e3a8a;
        }

        .amount-words {
            font-size: 10px;
            color: #475569;
            margin-top: 8px;
            font-style: italic;
        }

        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
        }

        .signature-section {
            margin-top: 60px;
            display: table;
            width: 100%;
        }

        .signature-box {
            display: table-cell;
            width: 48%;
            text-align: center;
            padding: 10px;
        }

        .signature-line {
            border-top: 2px solid #000;
            margin-top: 50px;
            padding-top: 10px;
            font-size: 10px;
        }

        .notes-box {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin-top: 20px;
            font-size: 10px;
        }

        .footer-text {
            text-align: center;
            font-size: 9px;
            color: #6b7280;
            margin-top: 20px;
        }

        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
        }

        .badge-success {
            background-color: #d1fae5;
            color: #065f46;
        }

        .badge-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 120px;
            color: rgba(37, 99, 235, 0.05);
            font-weight: bold;
            z-index: -1;
        }
    </style>
</head>
<body>
    <div class="watermark">CREDIHOME</div>

    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="company-name">CREDIHOME</div>
            <div style="font-size: 10px; color: #6b7280;">Sistema de Gestión de Préstamos</div>
            <div class="document-title">RECIBO DE PAGO</div>
            <div class="receipt-number">N° {{ $pago->numero_recibo ?? str_pad($pago->id, 8, '0', STR_PAD_LEFT) }}</div>
        </div>

        <!-- Información del Recibo -->
        <div class="section">
            <div class="section-title">INFORMACIÓN DEL RECIBO</div>
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">Fecha de Pago:</div>
                    <div class="info-value">{{ $pago->fecha_pago->format('d/m/Y') }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Hora:</div>
                    <div class="info-value">{{ $pago->created_at->format('H:i:s') }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Método de Pago:</div>
                    <div class="info-value">{{ strtoupper($pago->tipo_pago ?? $pago->metodo_pago ?? 'N/A') }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Estado:</div>
                    <div class="info-value">
                        @if(($pago->estado ?? 'completado') === 'completado')
                        <span class="badge badge-success">COMPLETADO</span>
                        @else
                        <span class="badge badge-pending">{{ strtoupper($pago->estado ?? 'PENDIENTE') }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Información del Cliente -->
        <div class="section">
            <div class="section-title">DATOS DEL CLIENTE</div>
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">Nombre Completo:</div>
                    <div class="info-value">{{ $pago->prestamo->cliente->nombre_completo ?? 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">DPI/NIT:</div>
                    <div class="info-value">{{ $pago->prestamo->cliente->dpi ?? $pago->prestamo->cliente->nit ?? 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Teléfono:</div>
                    <div class="info-value">{{ $pago->prestamo->cliente->telefono ?? 'N/A' }}</div>
                </div>
            </div>
        </div>

        <!-- Información del Préstamo -->
        <div class="section">
            <div class="section-title">DATOS DEL PRÉSTAMO</div>
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">Número de Préstamo:</div>
                    <div class="info-value">{{ $pago->prestamo->numero_prestamo }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Fecha de Desembolso:</div>
                    <div class="info-value">{{ $pago->prestamo->fecha_desembolso->format('d/m/Y') }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Monto del Préstamo:</div>
                    <div class="info-value">Q {{ number_format($pago->prestamo->monto_prestado, 2) }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Saldo Anterior:</div>
                    <div class="info-value">Q {{ number_format($pago->saldo_anterior ?? $pago->prestamo->saldo_pendiente + $pago->monto_pagado, 2) }}</div>
                </div>
            </div>
        </div>

        <!-- Monto Pagado -->
        <div class="amount-box">
            <div class="amount-label">MONTO PAGADO</div>
            <div class="amount-value">Q {{ number_format($pago->monto_pagado, 2) }}</div>
            <div class="amount-words">
                {{ ucfirst(\NumberFormatter::create('es', \NumberFormatter::SPELLOUT)->format($pago->monto_pagado)) }} quetzales
                {{ round(($pago->monto_pagado - floor($pago->monto_pagado)) * 100) }}/100
            </div>
        </div>

        <!-- Saldo Restante -->
        <div class="section">
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">Saldo Restante:</div>
                    <div class="info-value" style="font-weight: bold; color: #1e40af; font-size: 16px;">
                        Q {{ number_format($pago->prestamo->saldo_pendiente, 2) }}
                    </div>
                </div>
            </div>
        </div>

        @if($pago->observaciones)
        <!-- Notas -->
        <div class="notes-box">
            <strong>Observaciones:</strong><br>
            {{ $pago->observaciones }}
        </div>
        @endif

        <!-- Firmas -->
        <div class="signature-section">
            <div class="signature-box">
                <div class="signature-line">
                    Firma del Cliente
                </div>
            </div>
            <div class="signature-box">
                <div class="signature-line">
                    {{ $pago->usuario->name ?? 'Cajero' }}<br>
                    Recibido por
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-text">
                Este documento es un comprobante válido de pago.<br>
                Generado el {{ now()->format('d/m/Y H:i:s') }}<br>
                <strong>CREDIHOME</strong> - Sistema de Gestión de Préstamos
            </div>
        </div>
    </div>
</body>
</html>
