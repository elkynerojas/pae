<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Recepción - PAE</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }
        
        .header h2 {
            margin: 5px 0 0 0;
            font-size: 14px;
            color: #555;
        }
        
        .info-section {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        
        .info-section h3 {
            margin-top: 0;
            font-size: 12px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            margin-bottom: 10px;
            color: #333;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        
        .info-item {
            margin-bottom: 8px;
        }
        
        .info-label {
            font-weight: bold;
            display: inline-block;
            width: 120px;
        }
        
        .info-value {
            color: #555;
        }
        
        .estado-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
            color: white;
        }
        
        .estado-abierta {
            background-color: #28a745;
        }
        
        .estado-cerrada {
            background-color: #6c757d;
        }
        
        .productos-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        
        .productos-table th,
        .productos-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        
        .productos-table th {
            background-color: #f2f2f2;
            font-size: 11px;
            font-weight: bold;
        }
        
        .productos-table td {
            font-size: 10px;
        }
        
        .productos-table td:nth-child(4) {
            text-align: center;
        }
        
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 9px;
            color: #777;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        
        .total-row {
            font-weight: bold;
            background-color: #e0e0e0;
        }
        
        .no-data {
            text-align: center;
            color: #666;
            font-style: italic;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Programa de Alimentación Escolar (PAE)</h1>
        <h2>Reporte de Recepción</h2>
        <p>Fecha de Generación: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <div class="info-section">
        <h3>Información de la Recepción</h3>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">ID de Recepción:</span>
                <span class="info-value">{{ $recepcion->id }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Fecha de Recepción:</span>
                <span class="info-value">{{ $recepcion->fecha->format('d/m/Y') }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Hora de Recepción:</span>
                <span class="info-value">{{ $recepcion->hora ? $recepcion->hora->format('H:i') : 'N/A' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Estado:</span>
                <span class="info-value">
                    <span class="estado-badge estado-{{ $recepcion->estado ?? 'abierta' }}">
                        {{ $recepcion->estado === 'cerrada' ? 'Cerrada' : 'Abierta' }}
                    </span>
                </span>
            </div>
            <div class="info-item">
                <span class="info-label">Usuario Responsable:</span>
                <span class="info-value">{{ $recepcion->usuario->name ?? 'N/A' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Total Productos:</span>
                <span class="info-value">{{ $productosRecepcion->count() }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Total Cantidades:</span>
                <span class="info-value">{{ $productosRecepcion->sum('cantidad') }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Fecha de Creación:</span>
                <span class="info-value">{{ $recepcion->created_at->format('d/m/Y H:i') }}</span>
            </div>
        </div>
        @if($recepcion->observaciones)
        <div class="info-item">
            <span class="info-label">Observaciones:</span>
            <span class="info-value">{{ $recepcion->observaciones }}</span>
        </div>
        @endif
    </div>

    <div class="info-section">
        <h3>Listado de Productos Recibidos</h3>
        @if($productosRecepcion->count() > 0)
        <table class="productos-table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Presentación</th>
                    <th>Cantidad Recibida</th>
                    <th>Fecha de Registro</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productosRecepcion as $productoRecepcion)
                <tr>
                    <td>{{ $productoRecepcion->producto->nombre ?? 'N/A' }}</td>
                    <td>{{ $productoRecepcion->producto->presentacionProducto->nombre ?? 'N/A' }}</td>
                    <td style="text-align: center;">{{ $productoRecepcion->cantidad }}</td>
                    <td>{{ $productoRecepcion->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="2"><strong>Total General:</strong></td>
                    <td style="text-align: center;"><strong>{{ $productosRecepcion->sum('cantidad') }}</strong></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
        @else
        <div class="no-data">
            <p>No hay productos registrados para esta recepción.</p>
        </div>
        @endif
    </div>

    <div class="footer">
        <p>Reporte generado por el Sistema PAE</p>
        <p>Programa de Alimentación Escolar - {{ now()->format('Y') }}</p>
    </div>
</body>
</html>
