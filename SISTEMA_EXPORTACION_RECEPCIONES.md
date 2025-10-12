# Sistema de Exportación de Reportes de Recepciones

## Descripción General

El sistema de exportación de reportes de recepciones permite generar documentos en formato PDF y Excel para cada recepción individual, incluyendo información detallada sobre los productos recibidos y los datos generales de la recepción.

## Funcionalidades Implementadas

### 1. Exportación Individual

#### PDF
- **Acción**: `exportar_pdf`
- **Icono**: `heroicon-o-document-arrow-down`
- **Color**: `danger`
- **Archivo**: `recepcion_YYYY-MM-DD_ID.pdf`

#### Excel
- **Acción**: `exportar_excel`
- **Icono**: `heroicon-o-table-cells`
- **Color**: `success`
- **Archivo**: `recepcion_YYYY-MM-DD_ID.xlsx`

### 2. Exportación Masiva

#### PDF Masivo
- **Acción**: `exportar_pdf_masivo`
- **Descripción**: Exporta múltiples recepciones seleccionadas
- **Limitación**: Descarga solo el último archivo (para múltiples archivos se necesitaría un ZIP)

#### Excel Masivo
- **Acción**: `exportar_excel_masivo`
- **Descripción**: Exporta múltiples recepciones en un archivo Excel con múltiples hojas
- **Archivo**: `recepciones_YYYY-MM-DD.xlsx`

### 3. Contenido de los Reportes

#### Información de la Recepción
- ID de la recepción
- Fecha de recepción
- Hora de recepción
- Estado (Abierta/Cerrada)
- Usuario responsable
- Total de productos recibidos
- Total de cantidades recibidas
- Fecha de creación
- Observaciones

#### Listado de Productos Recibidos
- Nombre del producto
- Presentación del producto
- Cantidad recibida
- Fecha de registro del producto

## Implementación Técnica

### 1. Clases de Exportación

#### RecepcionPdfExport
```php
<?php

namespace App\Exports;

use App\Models\Recepcion;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\View\View;

class RecepcionPdfExport
{
    protected Recepcion $recepcion;

    public function __construct(Recepcion $recepcion)
    {
        $this->recepcion = $recepcion;
    }

    public function view(): View
    {
        return view('exports.recepcion-pdf', [
            'recepcion' => $this->recepcion,
            'productosRecepcion' => $this->recepcion->productosPorRecepcion()->with('producto.presentacionProducto')->get(),
        ]);
    }

    public function title(): string
    {
        return 'Recepcion_' . $this->recepcion->fecha->format('Y-m-d');
    }
}
```

#### RecepcionExcelExport
```php
<?php

namespace App\Exports;

use App\Models\Recepcion;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RecepcionExcelExport implements FromView, WithTitle, WithColumnWidths, WithStyles
{
    protected Recepcion $recepcion;

    public function __construct(Recepcion $recepcion)
    {
        $this->recepcion = $recepcion;
    }

    public function view(): View
    {
        return view('exports.recepcion-excel', [
            'recepcion' => $this->recepcion,
            'productosRecepcion' => $this->recepcion->productosPorRecepcion()->with('producto.presentacionProducto')->get(),
        ]);
    }

    public function title(): string
    {
        return 'Recepcion_' . $this->recepcion->fecha->format('Y-m-d');
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15, // Código
            'B' => 25, // Nombre del Producto
            'C' => 20, // Presentación
            'D' => 15, // Cantidad
            'E' => 30, // Observaciones
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Estilo para el encabezado
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 14,
                ],
                'alignment' => [
                    'horizontal' => 'center',
                ],
            ],
            // Estilo para los títulos de columna
            3 => [
                'font' => [
                    'bold' => true,
                ],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => [
                        'rgb' => 'E5E7EB',
                    ],
                ],
            ],
        ];
    }
}
```

#### RecepcionesMasivoExcelExport
```php
<?php

namespace App\Exports;

use App\Models\Recepcion;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RecepcionesMasivoExcelExport implements WithMultipleSheets
{
    use Exportable;

    protected $recepciones;

    public function __construct($recepciones)
    {
        $this->recepciones = $recepciones;
    }

    public function sheets(): array
    {
        $sheets = [];

        foreach ($this->recepciones as $recepcion) {
            $sheets[] = new RecepcionExcelExport($recepcion);
        }

        return $sheets;
    }
}
```

### 2. Plantillas Blade

#### PDF (`resources/views/exports/recepcion-pdf.blade.php`)
- **Encabezado**: Título del programa y tipo de reporte
- **Información de Recepción**: Datos principales en formato de cuadrícula
- **Listado de Productos**: Tabla completa con todos los detalles
- **Pie de Página**: Información del sistema y timestamp

#### Excel (`resources/views/exports/recepcion-excel.blade.php`)
- **Encabezado**: Título del programa y fecha
- **Información de Recepción**: Datos principales en filas
- **Tabla de Productos**: Listado completo con encabezados
- **Fila de Total**: Suma total de cantidades
- **Pie de Página**: Información del sistema

### 3. Integración en Filament

#### Acciones Individuales
```php
Tables\Actions\Action::make('exportar_pdf')
    ->label('PDF')
    ->icon('heroicon-o-document-arrow-down')
    ->color('danger')
    ->action(function (Recepcion $record) {
        $pdf = Pdf::loadView('exports.recepcion-pdf', [
            'recepcion' => $record,
            'productosRecepcion' => $record->productosPorRecepcion()->with('producto.presentacionProducto')->get(),
        ]);
        
        $filename = 'recepcion_' . $record->fecha->format('Y-m-d') . '_' . $record->id . '.pdf';
        
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $filename, [
            'Content-Type' => 'application/pdf',
        ]);
    }),

Tables\Actions\Action::make('exportar_excel')
    ->label('Excel')
    ->icon('heroicon-o-table-cells')
    ->color('success')
    ->action(function (Recepcion $record) {
        $filename = 'recepcion_' . $record->fecha->format('Y-m-d') . '_' . $record->id . '.xlsx';
        return Excel::download(new RecepcionExcelExport($record), $filename);
    }),
```

#### Acciones Masivas
```php
Tables\Actions\BulkAction::make('exportar_pdf_masivo')
    ->label('Exportar PDF')
    ->icon('heroicon-o-document-arrow-down')
    ->color('danger')
    ->action(function ($records) {
        foreach ($records as $record) {
            $pdf = Pdf::loadView('exports.recepcion-pdf', [
                'recepcion' => $record,
                'productosRecepcion' => $record->productosPorRecepcion()->with('producto.presentacionProducto')->get(),
            ]);
            
            $filename = 'recepcion_' . $record->fecha->format('Y-m-d') . '_' . $record->id . '.pdf';
            
            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->output();
            }, $filename, [
                'Content-Type' => 'application/pdf',
            ]);
        }
    }),

Tables\Actions\BulkAction::make('exportar_excel_masivo')
    ->label('Exportar Excel')
    ->icon('heroicon-o-table-cells')
    ->color('success')
    ->action(function ($records) {
        $export = new \App\Exports\RecepcionesMasivoExcelExport($records);
        $filename = 'recepciones_' . now()->format('Y-m-d') . '.xlsx';
        return Excel::download($export, $filename);
    }),
```

## Características del Sistema

### Formato PDF
- **Información estructurada**: Secciones claramente definidas
- **Tabla de productos**: Formato tabular fácil de leer
- **Estilos consistentes**: Colores y tipografías uniformes
- **Pie de página**: Información del sistema y fecha de generación

#### Estructura del PDF
1. **Encabezado**: Título del programa y tipo de reporte
2. **Información de Recepción**: Datos principales en formato de cuadrícula
3. **Listado de Productos**: Tabla completa con todos los detalles
4. **Pie de Página**: Información del sistema y timestamp

### Formato Excel
- **Múltiples hojas**: Una hoja por recepción (en exportación masiva)
- **Formato profesional**: Encabezados y estilos aplicados
- **Datos estructurados**: Información organizada en filas y columnas
- **Anchos de columna**: Optimizados para mejor visualización
- **Estilos aplicados**: Encabezados destacados y filas alternadas

#### Estructura del Excel
1. **Encabezado**: Título del programa y fecha
2. **Información de Recepción**: Datos principales en filas
3. **Tabla de Productos**: Listado completo con encabezados
4. **Fila de Total**: Suma total de cantidades
5. **Pie de Página**: Información del sistema

## Flujo de Trabajo

1. Usuario navega a la lista de recepciones
2. Usuario selecciona una recepción o múltiples recepciones
3. Usuario hace clic en la acción de exportación (PDF o Excel)
4. Sistema genera el reporte con la información correspondiente
5. Usuario descarga el archivo generado
6. Usuario puede archivar o compartir el reporte

## Casos de Uso

### 1. Auditoría de Recepciones
- **Propósito**: Verificar productos recibidos
- **Formato**: PDF para impresión y archivo
- **Contenido**: Lista completa de productos y cantidades

### 2. Análisis de Inventario
- **Propósito**: Analizar patrones de recepción
- **Formato**: Excel para análisis de datos
- **Contenido**: Datos estructurados para análisis

### 3. Documentación Legal
- **Propósito**: Documentar recepciones para auditoría
- **Formato**: PDF para presentación formal
- **Contenido**: Información completa y profesional

### 4. Reportes Gerenciales
- **Propósito**: Informar a la gerencia sobre recepciones
- **Formato**: Excel para análisis y presentación
- **Contenido**: Resúmenes y estadísticas

## Beneficios del Sistema

### Para Usuarios
- **Facilidad de uso**: Un clic para generar reportes
- **Formato profesional**: Reportes listos para presentar
- **Información completa**: Todos los datos en un solo archivo
- **Múltiples formatos**: PDF para impresión, Excel para análisis

### Para Administración
- **Documentación automática**: Reportes generados automáticamente
- **Auditoría facilitada**: Información completa y organizada
- **Trazabilidad**: Historial completo de recepciones
- **Eficiencia**: Proceso automatizado sin intervención manual

### Para el Sistema
- **Integración nativa**: Funciona dentro de Filament
- **Rendimiento optimizado**: Generación eficiente de archivos
- **Escalabilidad**: Soporte para múltiples recepciones
- **Mantenibilidad**: Código modular y bien estructurado

## Consideraciones Técnicas

### Rendimiento
- **Carga diferida**: Productos cargados solo cuando necesario
- **Optimización de consultas**: Uso de `with()` para evitar N+1
- **Memoria eficiente**: Generación de archivos sin cargar todo en memoria

### Seguridad
- **Validación de acceso**: Solo usuarios autorizados pueden exportar
- **Sanitización de datos**: Datos seguros en los reportes
- **Control de descargas**: Archivos generados bajo demanda

### Mantenibilidad
- **Separación de responsabilidades**: Lógica de exportación separada
- **Plantillas reutilizables**: Vistas compartidas entre formatos
- **Configuración centralizada**: Estilos y formatos en un solo lugar

## Archivos Creados/Modificados

### Nuevos Archivos
- `app/Exports/RecepcionPdfExport.php` - Clase de exportación PDF
- `app/Exports/RecepcionExcelExport.php` - Clase de exportación Excel
- `app/Exports/RecepcionesMasivoExcelExport.php` - Clase de exportación masiva
- `resources/views/exports/recepcion-pdf.blade.php` - Plantilla PDF
- `resources/views/exports/recepcion-excel.blade.php` - Plantilla Excel

### Archivos Modificados
- `app/Filament/Resources/RecepcionResource.php` - Agregadas acciones de exportación

## Dependencias

### Paquetes Requeridos
- `barryvdh/laravel-dompdf` - Para generación de PDF
- `maatwebsite/excel` - Para generación de Excel

### Extensiones PHP
- `ext-gd` - Para procesamiento de imágenes (opcional)
- `ext-zip` - Para archivos comprimidos
- `ext-xml` - Para procesamiento XML

## Conclusiones

El sistema de exportación de reportes de recepciones proporciona una solución completa para la generación de documentos profesionales que incluyen información detallada sobre las recepciones y los productos recibidos. El sistema es fácil de usar, eficiente y mantiene la consistencia con el resto de la aplicación PAE.

La implementación sigue las mejores prácticas de Laravel y Filament, asegurando un código mantenible y escalable. Los reportes generados son profesionales y adecuados para uso en auditorías, análisis y documentación oficial.
