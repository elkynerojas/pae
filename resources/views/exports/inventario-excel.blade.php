<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Inventario PAE</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 10pt; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .header { text-align: center; font-size: 14pt; font-weight: bold; margin-bottom: 10pt; }
        .subheader { text-align: center; font-size: 12pt; margin-bottom: 15pt; }
        .summary-section h3 { font-size: 11pt; border-bottom: 1px solid #ccc; padding-bottom: 5pt; margin-top: 20pt; margin-bottom: 10pt; }
        .summary-item strong { width: 150px; display: inline-block; }
        .center { text-align: center; }
        .stock-bajo { background-color: #ffebee; color: #c62828; font-weight: bold; }
        .stock-normal { background-color: #e8f5e8; color: #2e7d32; }
        .inactivo { background-color: #f5f5f5; color: #666; }
    </style>
</head>
<body>
    <div class="header">PROGRAMA DE ALIMENTACIÓN ESCOLAR (PAE)</div>
    <div class="subheader">REPORTE DE INVENTARIO GENERAL</div>

    <table>
        <tr><td colspan="2" class="summary-section"><h3>Resumen del Inventario</h3></td></tr>
        <tr><td><strong>Total Productos:</strong></td><td>{{ $inventarios->count() }}</td></tr>
        <tr><td><strong>Productos Activos:</strong></td><td>{{ $inventarios->where('activo', true)->count() }}</td></tr>
        <tr><td><strong>Productos Inactivos:</strong></td><td>{{ $inventarios->where('activo', false)->count() }}</td></tr>
        <tr><td><strong>Productos con Stock Bajo:</strong></td><td>{{ $inventarios->filter(function($item) { return $item->cantidad_stock <= $item->cantidad_minima; })->count() }}</td></tr>
        <tr><td><strong>Total en Stock:</strong></td><td>{{ $inventarios->sum('cantidad_stock') }}</td></tr>
        <tr><td><strong>Valor Total del Inventario:</strong></td><td>${{ number_format($inventarios->sum(function($item) { return $item->cantidad_stock * $item->precio_unitario; }), 2) }}</td></tr>
        <tr><td><strong>Productos con Precio:</strong></td><td>{{ $inventarios->where('precio_unitario', '>', 0)->count() }}</td></tr>
        <tr><td><strong>Productos sin Precio:</strong></td><td>{{ $inventarios->where('precio_unitario', 0)->count() }}</td></tr>
    </table>

    @if($inventarios->count() > 0)
    <h3>Listado de Productos en Inventario</h3>
    <table>
        <thead>
            <tr style="background-color: #f0f0f0; font-weight: bold;">
                <td>ID</td>
                <td>Producto</td>
                <td>Tipo</td>
                <td>Presentación</td>
                <td>Stock</td>
                <td>Mínimo</td>
                <td>Precio Unit.</td>
                <td>Estado</td>
                <td>Observaciones</td>
            </tr>
        </thead>
        <tbody>
            @foreach($inventarios as $inventario)
            <tr class="{{ !$inventario->activo ? 'inactivo' : ($inventario->cantidad_stock <= $inventario->cantidad_minima ? 'stock-bajo' : 'stock-normal') }}">
                <td>{{ $inventario->id }}</td>
                <td>{{ $inventario->producto->nombre ?? 'N/A' }}</td>
                <td>{{ $inventario->producto->tipoProducto->nombre ?? 'N/A' }}</td>
                <td>{{ $inventario->producto->presentacionProducto->nombre ?? 'N/A' }}</td>
                <td class="center">{{ $inventario->cantidad_stock }}</td>
                <td class="center">{{ $inventario->cantidad_minima }}</td>
                <td class="center">${{ number_format($inventario->precio_unitario, 2) }}</td>
                <td class="center">{{ $inventario->activo ? 'Activo' : 'Inactivo' }}</td>
                <td>{{ $inventario->observaciones ?? 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>No hay productos registrados en el inventario.</p>
    @endif

    <p style="text-align: center; margin-top: 20pt; font-size: 8pt; color: #666;">Reporte generado por el Sistema PAE - Fecha: {{ now()->format('d/m/Y H:i') }}</p>
</body>
</html>
