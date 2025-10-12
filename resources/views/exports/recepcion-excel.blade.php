<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Recepción - PAE</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 10pt; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .header { text-align: center; font-size: 14pt; font-weight: bold; margin-bottom: 10pt; }
        .subheader { text-align: center; font-size: 12pt; margin-bottom: 15pt; }
        .info-section h3 { font-size: 11pt; border-bottom: 1px solid #ccc; padding-bottom: 5pt; margin-top: 20pt; margin-bottom: 10pt; }
        .info-item strong { width: 150px; display: inline-block; }
        .total-row { font-weight: bold; background-color: #e0e0e0; }
        .center { text-align: center; }
    </style>
</head>
<body>
    <div class="header">PROGRAMA DE ALIMENTACIÓN ESCOLAR (PAE)</div>
    <div class="subheader">REPORTE DE RECEPCIÓN</div>

    <table>
        <tr><td colspan="2" class="info-section"><h3>Información de la Recepción</h3></td></tr>
        <tr><td><strong>ID de Recepción:</strong></td><td>{{ $recepcion->id }}</td></tr>
        <tr><td><strong>Fecha de Recepción:</strong></td><td>{{ $recepcion->fecha->format('d/m/Y') }}</td></tr>
        <tr><td><strong>Hora de Recepción:</strong></td><td>{{ $recepcion->hora ? $recepcion->hora->format('H:i') : 'N/A' }}</td></tr>
        <tr><td><strong>Estado:</strong></td><td>{{ $recepcion->estado === 'cerrada' ? 'Cerrada' : 'Abierta' }}</td></tr>
        <tr><td><strong>Usuario Responsable:</strong></td><td>{{ $recepcion->usuario->name ?? 'N/A' }}</td></tr>
        <tr><td><strong>Total Productos:</strong></td><td>{{ $productosRecepcion->count() }}</td></tr>
        <tr><td><strong>Total Cantidades:</strong></td><td>{{ $productosRecepcion->sum('cantidad') }}</td></tr>
        <tr><td><strong>Fecha de Creación:</strong></td><td>{{ $recepcion->created_at->format('d/m/Y H:i') }}</td></tr>
        @if($recepcion->observaciones)
        <tr><td><strong>Observaciones:</strong></td><td colspan="6">{{ $recepcion->observaciones }}</td></tr>
        @endif
    </table>

    <table>
        <tr><td colspan="4" class="info-section"><h3>Resumen de Productos</h3></td></tr>
        <tr><td><strong>Total Productos Recibidos:</strong></td><td>{{ $productosRecepcion->count() }}</td></tr>
        <tr><td><strong>Total Cantidades Recibidas:</strong></td><td>{{ $productosRecepcion->sum('cantidad') }}</td></tr>
    </table>

    @if($productosRecepcion->count() > 0)
    <h3>Listado de Productos Recibidos</h3>
    <table>
        <thead>
            <tr style="background-color: #f0f0f0; font-weight: bold;">
                <td>Producto</td>
                <td>Presentación</td>
                <td>Cantidad Recibida</td>
                <td>Fecha de Registro</td>
            </tr>
        </thead>
        <tbody>
            @foreach($productosRecepcion as $productoRecepcion)
            <tr>
                <td>{{ $productoRecepcion->producto->nombre ?? 'N/A' }}</td>
                <td>{{ $productoRecepcion->producto->presentacionProducto->nombre ?? 'N/A' }}</td>
                <td class="center">{{ $productoRecepcion->cantidad }}</td>
                <td>{{ $productoRecepcion->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="2"><strong>Total General:</strong></td>
                <td class="center"><strong>{{ $productosRecepcion->sum('cantidad') }}</strong></td>
                <td></td>
            </tr>
        </tfoot>
    </table>
    @else
    <p>No hay productos registrados para esta recepción.</p>
    @endif

    <p style="text-align: center; margin-top: 20pt; font-size: 8pt; color: #666;">Reporte generado por el Sistema PAE - Fecha: {{ now()->format('d/m/Y H:i') }}</p>
</body>
</html>
