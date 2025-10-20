<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Entregas - Sistema PAE</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #1f2937;
            padding-bottom: 20px;
        }
        
        .header h1 {
            color: #1f2937;
            margin: 0;
            font-size: 24px;
        }
        
        .header p {
            margin: 5px 0;
            color: #6b7280;
        }
        
        .filters {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }
        
        .filters h3 {
            margin: 0 0 10px 0;
            color: #1f2937;
            font-size: 14px;
        }
        
        .filter-row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        
        .filter-item {
            flex: 1;
            min-width: 200px;
        }
        
        .filter-label {
            font-weight: bold;
            color: #374151;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .table th {
            background-color: #1f2937;
            color: white;
            padding: 10px 8px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #374151;
        }
        
        .table td {
            padding: 8px;
            border: 1px solid #d1d5db;
            vertical-align: top;
        }
        
        .table tr:nth-child(even) {
            background-color: #f9fafb;
        }
        
        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .status-abierta {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .status-cerrada {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .summary {
            background-color: #f0f9ff;
            border: 1px solid #0ea5e9;
            border-radius: 8px;
            padding: 15px;
            margin-top: 20px;
        }
        
        .summary h3 {
            margin: 0 0 15px 0;
            color: #0c4a6e;
            font-size: 16px;
        }
        
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
        }
        
        .summary-item {
            text-align: center;
            padding: 10px;
            background-color: white;
            border-radius: 6px;
            border: 1px solid #e0f2fe;
        }
        
        .summary-number {
            font-size: 20px;
            font-weight: bold;
            color: #0c4a6e;
        }
        
        .summary-label {
            font-size: 11px;
            color: #0369a1;
            margin-top: 5px;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
            padding-top: 15px;
        }
        
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reporte de Entregas</h1>
        <p>Sistema PAE - Brighton Pamplona</p>
        <p>Generado el: {{ $fecha_generacion->format('d/m/Y H:i:s') }}</p>
    </div>

    @if(!empty($filtros))
        <div class="filters">
            <h3>Filtros Aplicados</h3>
            <div class="filter-row">
                @if(!empty($filtros['fecha_inicio']))
                    <div class="filter-item">
                        <span class="filter-label">Fecha Inicio:</span> {{ \Carbon\Carbon::parse($filtros['fecha_inicio'])->format('d/m/Y') }}
                    </div>
                @endif
                
                @if(!empty($filtros['fecha_fin']))
                    <div class="filter-item">
                        <span class="filter-label">Fecha Fin:</span> {{ \Carbon\Carbon::parse($filtros['fecha_fin'])->format('d/m/Y') }}
                    </div>
                @endif
                
                @if(!empty($filtros['estado']) && $filtros['estado'] !== 'todas')
                    <div class="filter-item">
                        <span class="filter-label">Estado:</span> {{ ucfirst($filtros['estado']) }}
                    </div>
                @endif
                
                @if(!empty($filtros['racion_id']))
                    <div class="filter-item">
                        <span class="filter-label">Ración:</span> {{ \App\Models\Racion::find($filtros['racion_id'])->nombre ?? 'N/A' }}
                    </div>
                @endif
                
                @if(!empty($filtros['beneficiario_id']))
                    <div class="filter-item">
                        <span class="filter-label">Beneficiario:</span> {{ \App\Models\Beneficiario::find($filtros['beneficiario_id'])->nombre_completo ?? 'N/A' }}
                    </div>
                @endif
                
                @if(!empty($filtros['grado']))
                    <div class="filter-item">
                        <span class="filter-label">Grado:</span> {{ $filtros['grado'] }}
                    </div>
                @endif
                
                @if(!empty($filtros['grupo']))
                    <div class="filter-item">
                        <span class="filter-label">Grupo:</span> {{ $filtros['grupo'] }}
                    </div>
                @endif
            </div>
        </div>
    @endif

    @if($entregas->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Ración</th>
                    <th>Estado</th>
                    <th>Beneficiarios</th>
                    <th>Total Raciones</th>
                    <th>Fecha Cierre</th>
                    <th>Usuario Cierre</th>
                    <th>Observaciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($entregas as $entrega)
                    <tr>
                        <td>{{ $entrega->fecha->format('d/m/Y') }}</td>
                        <td>{{ $entrega->racion->nombre ?? 'N/A' }}</td>
                        <td>
                            <span class="status-badge status-{{ $entrega->estado }}">
                                {{ $entrega->estado === 'cerrada' ? 'Cerrada' : 'Abierta' }}
                            </span>
                        </td>
                        <td>{{ $entrega->beneficiarios->count() }}</td>
                        <td>{{ $entrega->beneficiarios->sum('pivot.cantidad_raciones') }}</td>
                        <td>{{ $entrega->fecha_cierre ? $entrega->fecha_cierre->format('d/m/Y H:i') : 'N/A' }}</td>
                        <td>{{ $entrega->usuarioCierre->name ?? 'N/A' }}</td>
                        <td>{{ $entrega->observaciones ?? '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="summary">
            <h3>Resumen del Reporte</h3>
            <div class="summary-grid">
                <div class="summary-item">
                    <div class="summary-number">{{ $entregas->count() }}</div>
                    <div class="summary-label">Total Entregas</div>
                </div>
                
                <div class="summary-item">
                    <div class="summary-number">{{ $entregas->where('estado', 'cerrada')->count() }}</div>
                    <div class="summary-label">Entregas Cerradas</div>
                </div>
                
                <div class="summary-item">
                    <div class="summary-number">{{ $entregas->where('estado', 'abierta')->count() }}</div>
                    <div class="summary-label">Entregas Abiertas</div>
                </div>
                
                <div class="summary-item">
                    <div class="summary-number">{{ $entregas->sum(function($entrega) { return $entrega->beneficiarios->count(); }) }}</div>
                    <div class="summary-label">Total Beneficiarios</div>
                </div>
                
                <div class="summary-item">
                    <div class="summary-number">{{ $entregas->sum(function($entrega) { return $entrega->beneficiarios->sum('pivot.cantidad_raciones'); }) }}</div>
                    <div class="summary-label">Total Raciones</div>
                </div>
            </div>
        </div>
    @else
        <div style="text-align: center; padding: 40px; color: #6b7280;">
            <h3>No se encontraron entregas</h3>
            <p>No hay entregas que coincidan con los filtros aplicados.</p>
        </div>
    @endif

    <div class="footer">
        <p>Sistema PAE - Brighton Pamplona | Página generada automáticamente</p>
    </div>
</body>
</html>
