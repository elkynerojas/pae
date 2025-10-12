<table>
    <tr>
        <td colspan="7" style="text-align: center; font-size: 16px; font-weight: bold; padding: 20px;">
            PROGRAMA DE ALIMENTACIÓN ESCOLAR (PAE)<br>
            REPORTE DE ENTREGA
        </td>
    </tr>
    <tr>
        <td colspan="7" style="text-align: center; font-size: 14px; padding: 10px;">
            {{ $entrega->fecha->format('d/m/Y') }}
        </td>
    </tr>
    <tr>
        <td colspan="7" style="height: 20px;"></td>
    </tr>
    <tr>
        <td style="font-weight: bold;">Fecha de Entrega:</td>
        <td>{{ $entrega->fecha->format('d/m/Y') }}</td>
        <td style="font-weight: bold;">Ración:</td>
        <td>{{ $entrega->racion->nombre ?? 'N/A' }}</td>
        <td style="font-weight: bold;">Estado:</td>
        <td>{{ $entrega->estado === 'cerrada' ? 'Cerrada' : 'Abierta' }}</td>
        <td></td>
    </tr>
    <tr>
        <td style="font-weight: bold;">Total Beneficiarios:</td>
        <td>{{ $beneficiarios->count() }}</td>
        <td style="font-weight: bold;">Total Raciones:</td>
        <td>{{ $beneficiarios->sum('cantidad_raciones') }}</td>
        <td style="font-weight: bold;">Fecha de Cierre:</td>
        <td>{{ $entrega->fecha_cierre ? $entrega->fecha_cierre->format('d/m/Y H:i') : 'N/A' }}</td>
        <td></td>
    </tr>
    @if($entrega->observaciones)
    <tr>
        <td style="font-weight: bold;">Observaciones:</td>
        <td colspan="6">{{ $entrega->observaciones }}</td>
    </tr>
    @endif
    <tr>
        <td colspan="7" style="height: 20px;"></td>
    </tr>
    <tr style="background-color: #f0f0f0; font-weight: bold;">
        <td colspan="7" style="text-align: center; font-size: 14px; padding: 10px;">
            COMPOSICIÓN DE LA RACIÓN
        </td>
    </tr>
    <tr style="background-color: #e0e0e0; font-weight: bold;">
        <td>Producto</td>
        <td>Cantidad por Ración</td>
        <td>Presentación</td>
        <td>Total Distribuido</td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    @if($productosRacion && $productosRacion->count() > 0)
        @foreach($productosRacion as $productoRacion)
        <tr>
            <td>{{ $productoRacion->producto->nombre ?? 'N/A' }}</td>
            <td style="text-align: center;">{{ $productoRacion->cantidad }}</td>
            <td>{{ $productoRacion->producto->presentacionProducto->nombre ?? 'N/A' }}</td>
            <td style="text-align: center;">{{ $productoRacion->cantidad * $beneficiarios->sum('cantidad_raciones') }}</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        @endforeach
    @else
        <tr>
            <td colspan="7" style="text-align: center;">No hay productos registrados para esta ración.</td>
        </tr>
    @endif
    <tr>
        <td colspan="7" style="height: 20px;"></td>
    </tr>
    <tr style="background-color: #f0f0f0; font-weight: bold;">
        <td>Código</td>
        <td>Nombres</td>
        <td>Apellidos</td>
        <td>Grado</td>
        <td>Grupo</td>
        <td>Raciones</td>
        <td>Observaciones</td>
    </tr>
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
    <tr style="background-color: #e0e0e0; font-weight: bold;">
        <td colspan="5">TOTAL</td>
        <td style="text-align: center;">{{ $beneficiarios->sum('cantidad_raciones') }}</td>
        <td></td>
    </tr>
    <tr>
        <td colspan="7" style="height: 30px;"></td>
    </tr>
    <tr>
        <td colspan="7" style="text-align: center; font-size: 10px; color: #666;">
            Reporte generado el {{ now()->format('d/m/Y H:i') }} | Sistema PAE
        </td>
    </tr>
</table>
