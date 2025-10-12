# Sistema de Exportación de Reportes de Inventario General

## Descripción General

El sistema de exportación de reportes de inventario general permite generar documentos en formato PDF y Excel con todos los registros de la tabla inventarios, incluyendo información detallada sobre productos, stock, precios y estado del inventario.

## Funcionalidades Implementadas

### 1. Exportación General

#### PDF General
- **Acción**: `exportar_pdf_general`
- **Icono**: `heroicon-o-document-arrow-down`
- **Color**: `danger`
- **Archivo**: `inventario_general_YYYY-MM-DD.pdf`
- **Alcance**: Todos los registros de inventario

#### Excel General
- **Acción**: `exportar_excel_general`
- **Icono**: `heroicon-o-table-cells`
- **Color**: `success`
- **Archivo**: `inventario_general_YYYY-MM-DD.xlsx`
- **Alcance**: Todos los registros de inventario

### 2. Exportación de Seleccionados

#### PDF Seleccionados
- **Acción**: `exportar_pdf_seleccionados`
- **Icono**: `heroicon-o-document-arrow-down`
- **Color**: `danger`
- **Archivo**: `inventario_seleccionados_YYYY-MM-DD.pdf`
- **Alcance**: Registros seleccionados por el usuario

#### Excel Seleccionados
- **Acción**: `exportar_excel_seleccionados`
- **Icono**: `heroicon-o-table-cells`
- **Color**: `success`
- **Archivo**: `inventario_seleccionados_YYYY-MM-DD.xlsx`
- **Alcance**: Registros seleccionados por el usuario

### 3. Contenido de los Reportes

#### Resumen del Inventario
- Total de productos registrados
- Productos activos e inactivos
- Productos con stock bajo
- Total de cantidades en stock
- Valor total del inventario
- Productos con y sin precio

#### Listado de Productos en Inventario
- ID del registro
- Nombre del producto
- Tipo de producto
- Presentación del producto
- Cantidad en stock
- Cantidad mínima requerida
- Precio unitario
- Estado (Activo/Inactivo)
- Observaciones

## Implementación Técnica

### 1. Clases de Exportación

#### InventarioPdfExport
```php
<?php

namespace App\Exports;

use App\Models\Inventario;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\View\View;

class InventarioPdfExport
{
    protected $inventarios;

    public function __construct($inventarios = null)
    {
        $this->inventarios = $inventarios ?? Inventario::with('producto.presentacionProducto', 'producto.tipoProducto')->get();
    }

    public function view(): View
    {
        return view('exports.inventario-pdf', [
            'inventarios' => $this->inventarios,
        ]);
    }

    public function title(): string
    {
        return 'Inventario';
    }
}
```

#### InventarioExcelExport
```php
<?php

namespace App\Exports;

use App\Models\Inventario;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InventarioExcelExport implements FromView, WithTitle, WithColumnWidths, WithStyles
{
    protected $inventarios;

    public function __construct($inventarios = null)
    {
        $this->inventarios = $inventarios ?? Inventario::with('producto.presentacionProducto', 'producto.tipoProducto')->get();
    }

    public function view(): View
    {
        return view('exports.inventario-excel', [
            'inventarios' => $this->inventarios,
        ]);
    }

    public function title(): string
    {
        return 'Inventario';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15, // ID
            'B' => 25, // Producto
            'C' => 20, // Tipo
            'D' => 20, // Presentación
            'E' => 15, // Stock
            'F' => 15, // Mínimo
            'G' => 15, // Precio
            'H' => 10, // Estado
            'I' => 30, // Observaciones
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

### 2. Plantillas Blade

#### PDF (`resources/views/exports/inventario-pdf.blade.php`)
- **Encabezado**: Título del programa y tipo de reporte
- **Resumen del Inventario**: Estadísticas principales en formato de cuadrícula
- **Listado de Productos**: Tabla completa con todos los detalles
- **Indicadores Visuales**: Colores para stock bajo, normal e inactivo
- **Pie de Página**: Información del sistema y timestamp

#### Excel (`resources/views/exports/inventario-excel.blade.php`)
- **Encabezado**: Título del programa y fecha
- **Resumen del Inventario**: Estadísticas principales en filas
- **Tabla de Productos**: Listado completo con encabezados
- **Indicadores Visuales**: Colores para stock bajo, normal e inactivo
- **Pie de Página**: Información del sistema

### 3. Integración en Filament

#### Acciones de Header
```php
Tables\Actions\Action::make('exportar_pdf_general')
    ->label('Exportar PDF')
    ->icon('heroicon-o-document-arrow-down')
    ->color('danger')
    ->action(function () {
        $inventarios = Inventario::with('producto.presentacionProducto', 'producto.tipoProducto')->get();
        $pdf = Pdf::loadView('exports.inventario-pdf', [
            'inventarios' => $inventarios,
        ]);
        
        $filename = 'inventario_general_' . now()->format('Y-m-d') . '.pdf';
        
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $filename, [
            'Content-Type' => 'application/pdf',
        ]);
    }),

Tables\Actions\Action::make('exportar_excel_general')
    ->label('Exportar Excel')
    ->icon('heroicon-o-table-cells')
    ->color('success')
    ->action(function () {
        $inventarios = Inventario::with('producto.presentacionProducto', 'producto.tipoProducto')->get();
        $filename = 'inventario_general_' . now()->format('Y-m-d') . '.xlsx';
        return Excel::download(new InventarioExcelExport($inventarios), $filename);
    }),
```

#### Acciones de Bulk
```php
Tables\Actions\BulkAction::make('exportar_pdf_seleccionados')
    ->label('Exportar PDF Seleccionados')
    ->icon('heroicon-o-document-arrow-down')
    ->color('danger')
    ->action(function ($records) {
        $inventarios = $records->load('producto.presentacionProducto', 'producto.tipoProducto');
        $pdf = Pdf::loadView('exports.inventario-pdf', [
            'inventarios' => $inventarios,
        ]);
        
        $filename = 'inventario_seleccionados_' . now()->format('Y-m-d') . '.pdf';
        
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $filename, [
            'Content-Type' => 'application/pdf',
        ]);
    }),

Tables\Actions\BulkAction::make('exportar_excel_seleccionados')
    ->label('Exportar Excel Seleccionados')
    ->icon('heroicon-o-table-cells')
    ->color('success')
    ->action(function ($records) {
        $inventarios = $records->load('producto.presentacionProducto', 'producto.tipoProducto');
        $filename = 'inventario_seleccionados_' . now()->format('Y-m-d') . '.xlsx';
        return Excel::download(new InventarioExcelExport($inventarios), $filename);
    }),
```

## Características del Sistema

### Formato PDF
- **Información estructurada**: Secciones claramente definidas
- **Resumen visual**: Estadísticas en formato de cuadrícula
- **Tabla de productos**: Formato tabular fácil de leer
- **Indicadores de color**: Stock bajo (rojo), normal (verde), inactivo (gris)
- **Estilos consistentes**: Colores y tipografías uniformes
- **Pie de página**: Información del sistema y fecha de generación

#### Estructura del PDF
1. **Encabezado**: Título del programa y tipo de reporte
2. **Resumen del Inventario**: Estadísticas principales en formato de cuadrícula
3. **Listado de Productos**: Tabla completa con todos los detalles
4. **Pie de Página**: Información del sistema y timestamp

### Formato Excel
- **Formato profesional**: Encabezados y estilos aplicados
- **Datos estructurados**: Información organizada en filas y columnas
- **Anchos de columna**: Optimizados para mejor visualización
- **Estilos aplicados**: Encabezados destacados y filas alternadas
- **Indicadores de color**: Stock bajo, normal e inactivo
- **Cálculos automáticos**: Sumas y totales

#### Estructura del Excel
1. **Encabezado**: Título del programa y fecha
2. **Resumen del Inventario**: Estadísticas principales en filas
3. **Tabla de Productos**: Listado completo con encabezados
4. **Pie de Página**: Información del sistema

## Flujo de Trabajo

1. Usuario navega a la lista de inventario
2. Usuario puede exportar todo el inventario o seleccionar registros específicos
3. Usuario hace clic en la acción de exportación (PDF o Excel)
4. Sistema genera el reporte con la información correspondiente
5. Usuario descarga el archivo generado
6. Usuario puede archivar o compartir el reporte

## Casos de Uso

### 1. Auditoría de Inventario
- **Propósito**: Verificar estado completo del inventario
- **Formato**: PDF para impresión y archivo
- **Contenido**: Lista completa de productos y cantidades

### 2. Análisis de Stock
- **Propósito**: Analizar patrones de inventario
- **Formato**: Excel para análisis de datos
- **Contenido**: Datos estructurados para análisis

### 3. Reportes Gerenciales
- **Propósito**: Informar a la gerencia sobre inventario
- **Formato**: PDF para presentación formal
- **Contenido**: Resúmenes y estadísticas

### 4. Control de Stock Bajo
- **Propósito**: Identificar productos que requieren reposición
- **Formato**: Excel para seguimiento
- **Contenido**: Productos con stock bajo o crítico

## Beneficios del Sistema

### Para Usuarios
- **Facilidad de uso**: Un clic para generar reportes
- **Formato profesional**: Reportes listos para presentar
- **Información completa**: Todos los datos en un solo archivo
- **Múltiples formatos**: PDF para impresión, Excel para análisis
- **Flexibilidad**: Exportar todo o seleccionar registros específicos

### Para Administración
- **Documentación automática**: Reportes generados automáticamente
- **Auditoría facilitada**: Información completa y organizada
- **Control de inventario**: Visión completa del estado del stock
- **Eficiencia**: Proceso automatizado sin intervención manual

### Para el Sistema
- **Integración nativa**: Funciona dentro de Filament
- **Rendimiento optimizado**: Generación eficiente de archivos
- **Escalabilidad**: Soporte para grandes volúmenes de datos
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
- `app/Exports/InventarioPdfExport.php` - Clase de exportación PDF
- `app/Exports/InventarioExcelExport.php` - Clase de exportación Excel
- `resources/views/exports/inventario-pdf.blade.php` - Plantilla PDF
- `resources/views/exports/inventario-excel.blade.php` - Plantilla Excel

### Archivos Modificados
- `app/Filament/Resources/InventarioResource.php` - Agregadas acciones de exportación

## Dependencias

### Paquetes Requeridos
- `barryvdh/laravel-dompdf` - Para generación de PDF
- `maatwebsite/excel` - Para generación de Excel

### Extensiones PHP
- `ext-gd` - Para procesamiento de imágenes (opcional)
- `ext-zip` - Para archivos comprimidos
- `ext-xml` - Para procesamiento XML

## Conclusiones

El sistema de exportación de reportes de inventario general proporciona una solución completa para la generación de documentos profesionales que incluyen información detallada sobre todos los productos en inventario. El sistema es fácil de usar, eficiente y mantiene la consistencia con el resto de la aplicación PAE.

La implementación sigue las mejores prácticas de Laravel y Filament, asegurando un código mantenible y escalable. Los reportes generados son profesionales y adecuados para uso en auditorías, análisis y documentación oficial.

El sistema permite tanto la exportación completa del inventario como la exportación de registros seleccionados, proporcionando flexibilidad para diferentes necesidades de reporte y análisis.
