<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Entrega - {{ $entrega->fecha->format('d/m/Y') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        .header h2 {
            margin: 5px 0 0 0;
            font-size: 18px;
            color: #666;
        }
        .info-section {
            margin-bottom: 25px;
        }
        .info-section h3 {
            background-color: #f5f5f5;
            padding: 8px;
            margin: 0 0 10px 0;
            font-size: 14px;
            border-left: 4px solid #007bff;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 15px;
        }
        .info-item {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            border-bottom: 1px dotted #ccc;
        }
        .info-label {
            font-weight: bold;
            color: #555;
        }
        .info-value {
            color: #333;
        }
        .beneficiarios-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .beneficiarios-table th,
        .beneficiarios-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .beneficiarios-table th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #333;
        }
        .beneficiarios-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .total-row {
            background-color: #e9ecef !important;
            font-weight: bold;
        }
        .estado-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .estado-abierta {
            background-color: #d4edda;
            color: #155724;
        }
        .estado-cerrada {
            background-color: #f8d7da;
            color: #721c24;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Programa de Alimentación Escolar (PAE)</h1>
        <h2>Reporte de Entrega</h2>
    </div>

    <div class="info-section">
        <h3>Información de la Entrega</h3>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Fecha de Entrega:</span>
                <span class="info-value">{{ $entrega->fecha->format('d/m/Y') }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Ración:</span>
                <span class="info-value">{{ $entrega->racion->nombre ?? 'N/A' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Estado:</span>
                <span class="info-value">
                    <span class="estado-badge estado-{{ $entrega->estado ?? 'abierta' }}">
                        {{ $entrega->estado === 'cerrada' ? 'Cerrada' : 'Abierta' }}
                    </span>
                </span>
            </div>
            <div class="info-item">
                <span class="info-label">Total Beneficiarios:</span>
                <span class="info-value">{{ $beneficiarios->count() }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Total Raciones:</span>
                <span class="info-value">{{ $beneficiarios->sum('cantidad_raciones') }}</span>
            </div>
            @if($entrega->estaCerrada())
            <div class="info-item">
                <span class="info-label">Fecha de Cierre:</span>
                <span class="info-value">{{ $entrega->fecha_cierre ? $entrega->fecha_cierre->format('d/m/Y H:i') : 'N/A' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Cerrado por:</span>
                <span class="info-value">{{ $entrega->usuarioCierre->name ?? 'N/A' }}</span>
            </div>
            @endif
        </div>
        @if($entrega->observaciones)
        <div class="info-item">
            <span class="info-label">Observaciones:</span>
            <span class="info-value">{{ $entrega->observaciones }}</span>
        </div>
        @endif
    </div>

    <div class="info-section">
        <h3>Composición de la Ración</h3>
        @if($productosRacion && $productosRacion->count() > 0)
        <table class="beneficiarios-table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad por Ración</th>
                    <th>Presentación</th>
                    <th>Total Distribuido</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productosRacion as $productoRacion)
                <tr>
                    <td>{{ $productoRacion->producto->nombre ?? 'N/A' }}</td>
                    <td style="text-align: center;">{{ $productoRacion->cantidad }}</td>
                    <td>{{ $productoRacion->producto->presentacionProducto->nombre ?? 'N/A' }}</td>
                    <td style="text-align: center;">{{ $productoRacion->cantidad * $beneficiarios->sum('cantidad_raciones') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p>No hay productos registrados para esta ración.</p>
        @endif
    </div>

    <div class="info-section">
        <h3>Listado de Beneficiarios</h3>
        @if($beneficiarios->count() > 0)
        <table class="beneficiarios-table">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Grado</th>
                    <th>Grupo</th>
                    <th>Raciones</th>
                    <th>Observaciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($beneficiarios as $beneficiario)
                <tr>
                    <td>{{ $beneficiario->beneficiario->codigo ?? 'N/A' }}</td>
                    <td>{{ $beneficiario->beneficiario->nombres ?? 'N/A' }}</td>
                    <td>{{ $beneficiario->beneficiario->apellidos ?? 'N/A' }}</td>
                    <td>{{ ucfirst($beneficiario->beneficiario->grado ?? 'N/A') }}</td>
                    <td>{{ $beneficiario->beneficiario->grupo ?? 'N/A' }}</td>
                    <td style="text-align: center;">{{ $beneficiario->cantidad_raciones }}</td>
                    <td>{{ $beneficiario->observaciones ?? '-' }}</td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="5"><strong>TOTAL</strong></td>
                    <td style="text-align: center;"><strong>{{ $beneficiarios->sum('cantidad_raciones') }}</strong></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        @else
        <p>No hay beneficiarios registrados para esta entrega.</p>
        @endif
    </div>

    <div class="footer">
        <p>Reporte generado el {{ now()->format('d/m/Y H:i') }} | Sistema PAE</p>
    </div>
</body>
</html>
