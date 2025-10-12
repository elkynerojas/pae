<!DOCTYPE html>
<html>
<head>
    <title>Inventario PAE</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 9px;
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
        
        .summary-section {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        
        .summary-section h3 {
            margin-top: 0;
            font-size: 12px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            margin-bottom: 10px;
            color: #333;
        }
        
        .summary-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr;
            gap: 15px;
        }
        
        .summary-item {
            text-align: center;
            padding: 10px;
            background-color: white;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        
        .summary-value {
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }
        
        .summary-label {
            font-size: 10px;
            color: #666;
            margin-top: 5px;
        }
        
        .inventario-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        
        .inventario-table th,
        .inventario-table td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }
        
        .inventario-table th {
            background-color: #f2f2f2;
            font-size: 10px;
            font-weight: bold;
        }
        
        .inventario-table td {
            font-size: 9px;
        }
        
        .inventario-table td:nth-child(5),
        .inventario-table td:nth-child(6),
        .inventario-table td:nth-child(7) {
            text-align: center;
        }
        
        .inventario-table td:nth-child(8) {
            text-align: center;
        }
        
        .stock-bajo {
            background-color: #ffebee;
            color: #c62828;
            font-weight: bold;
        }
        
        .stock-normal {
            background-color: #e8f5e8;
            color: #2e7d32;
        }
        
        .inactivo {
            background-color: #f5f5f5;
            color: #666;
        }
        
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 8px;
            color: #777;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        
        .no-data {
            text-align: center;
            color: #666;
            font-style: italic;
            padding: 20px;
        }
        
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Programa de Alimentación Escolar (PAE)</h1>
        <h2>Reporte de Inventario General</h2>
        <p>Fecha de Generación: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <div class="summary-section">
        <h3>Resumen del Inventario</h3>
        <div class="summary-grid">
            <div class="summary-item">
                <div class="summary-value">{{ $inventarios->count() }}</div>
                <div class="summary-label">Total Productos</div>
            </div>
            <div class="summary-item">
                <div class="summary-value">{{ $inventarios->where('activo', true)->count() }}</div>
                <div class="summary-label">Productos Activos</div>
            </div>
            <div class="summary-item">
                <div class="summary-value">{{ $inventarios->where('activo', false)->count() }}</div>
                <div class="summary-label">Productos Inactivos</div>
            </div>
            <div class="summary-item">
                <div class="summary-value">{{ $inventarios->filter(function($item) { return $item->cantidad_stock <= $item->cantidad_minima; })->count() }}</div>
                <div class="summary-label">Stock Bajo</div>
            </div>
        </div>
        <div class="summary-grid" style="margin-top: 10px;">
            <div class="summary-item">
                <div class="summary-value">{{ $inventarios->sum('cantidad_stock') }}</div>
                <div class="summary-label">Total en Stock</div>
            </div>
            <div class="summary-item">
                <div class="summary-value">${{ number_format($inventarios->sum(function($item) { return $item->cantidad_stock * $item->precio_unitario; }), 2) }}</div>
                <div class="summary-label">Valor Total</div>
            </div>
            <div class="summary-item">
                <div class="summary-value">{{ $inventarios->where('precio_unitario', '>', 0)->count() }}</div>
                <div class="summary-label">Con Precio</div>
            </div>
            <div class="summary-item">
                <div class="summary-value">{{ $inventarios->where('precio_unitario', 0)->count() }}</div>
                <div class="summary-label">Sin Precio</div>
            </div>
        </div>
    </div>

    <div class="summary-section">
        <h3>Listado de Productos en Inventario</h3>
        @if($inventarios->count() > 0)
        <table class="inventario-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Producto</th>
                    <th>Tipo</th>
                    <th>Presentación</th>
                    <th>Stock</th>
                    <th>Mínimo</th>
                    <th>Precio Unit.</th>
                    <th>Estado</th>
                    <th>Observaciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inventarios as $inventario)
                <tr class="{{ !$inventario->activo ? 'inactivo' : ($inventario->cantidad_stock <= $inventario->cantidad_minima ? 'stock-bajo' : 'stock-normal') }}">
                    <td>{{ $inventario->id }}</td>
                    <td>{{ $inventario->producto->nombre ?? 'N/A' }}</td>
                    <td>{{ $inventario->producto->tipoProducto->nombre ?? 'N/A' }}</td>
                    <td>{{ $inventario->producto->presentacionProducto->nombre ?? 'N/A' }}</td>
                    <td>{{ $inventario->cantidad_stock }}</td>
                    <td>{{ $inventario->cantidad_minima }}</td>
                    <td>${{ number_format($inventario->precio_unitario, 2) }}</td>
                    <td>{{ $inventario->activo ? 'Activo' : 'Inactivo' }}</td>
                    <td>{{ $inventario->observaciones ?? 'N/A' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="no-data">
            <p>No hay productos registrados en el inventario.</p>
        </div>
        @endif
    </div>

    <div class="footer">
        <p>Reporte generado por el Sistema PAE</p>
        <p>Programa de Alimentación Escolar - {{ now()->format('Y') }}</p>
    </div>
</body>
</html>
