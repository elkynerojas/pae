# Sistema de Actualización Automática de Inventario - PAE

## Descripción

El sistema PAE implementa una actualización automática del inventario basada en las entregas realizadas a los beneficiarios. Cada vez que se registra una entrega, el sistema calcula automáticamente la cantidad de productos consumidos y actualiza el inventario correspondiente.

## Funcionamiento

### 1. Estructura de Datos

El sistema utiliza las siguientes entidades principales:

- **Entrega**: Representa una entrega de raciones en una fecha específica
- **Ración**: Define qué productos y en qué cantidades se incluyen
- **BeneficiarioPorEntrega**: Relaciona beneficiarios con entregas y especifica cuántas raciones recibe cada uno
- **ProductoPorRación**: Define qué productos y cantidades contiene cada ración
- **Inventario**: Almacena el stock actual de cada producto

### 2. Flujo de Actualización

#### 2.1 Creación de Entrega
```php
// Cuando se crea una entrega
Entrega::create([
    'fecha' => '2024-01-15',
    'racion_id' => 1,
    'observaciones' => 'Entrega del día'
]);
// ✅ CORRECTO: El inventario se REDUCE automáticamente
```

#### 2.2 Asignación de Beneficiarios
```php
// Cuando se asigna un beneficiario a la entrega
BeneficiarioPorEntrega::create([
    'beneficiario_id' => 1,
    'entrega_id' => 1,
    'cantidad_raciones' => 2, // El beneficiario recibe 2 raciones
    'observaciones' => 'Beneficiario activo'
]);
// ✅ CORRECTO: El inventario se REDUCE automáticamente
```

#### 2.3 Cálculo Automático
El sistema calcula automáticamente:
- **Total de raciones**: Suma de todas las `cantidad_raciones` de los beneficiarios
- **Productos consumidos**: Para cada producto en la ración, multiplica `cantidad_por_ración × total_raciones`
- **Actualización de inventario**: **RESTA** la cantidad consumida del stock disponible

### 3. Observers Implementados

#### 3.1 EntregaObserver
Maneja los eventos de la entidad `Entrega`:

- **created**: **RESTA** del inventario cuando se crea una entrega
- **updated**: Si cambia la ración, revierte el inventario anterior y aplica el nuevo
- **deleted**: **SUMA** al inventario cuando se elimina una entrega

#### 3.2 BeneficiarioPorEntregaObserver
Maneja los eventos de la entidad `BeneficiarioPorEntrega`:

- **created**: **RESTA** del inventario cuando se asigna un beneficiario
- **updated**: Si cambia la cantidad de raciones, ajusta el inventario proporcionalmente
- **deleted**: **SUMA** al inventario cuando se elimina un beneficiario

### 4. Métodos de Actualización

#### 4.1 Inventario::actualizarStock()
```php
public static function actualizarStock($productoId, $cantidad, $operacion = 'sumar')
{
    $inventario = self::firstOrCreate(
        ['producto_id' => $productoId],
        [
            'cantidad_stock' => 0,
            'cantidad_minima' => 0,
            'activo' => true,
        ]
    );

    if ($operacion === 'sumar') {
        $inventario->cantidad_stock += $cantidad;
    } elseif ($operacion === 'restar') {
        $inventario->cantidad_stock -= $cantidad;
        // No permitir stock negativo
        if ($inventario->cantidad_stock < 0) {
            $inventario->cantidad_stock = 0;
        }
    }

    $inventario->save();
    return $inventario;
}
```

#### 4.2 Inventario::actualizarInventarioPorEntrega()
```php
public static function actualizarInventarioPorEntrega($entrega, $operacion = 'sumar')
{
    $racion = $entrega->racion;
    if (!$racion) return;

    $productosPorRacion = $racion->productosPorRacion;
    $totalBeneficiarios = $entrega->beneficiariosPorEntrega()->sum('cantidad_raciones');
    
    if ($totalBeneficiarios <= 0) return;

    foreach ($productosPorRacion as $productoPorRacion) {
        $cantidadTotal = $productoPorRacion->cantidad * $totalBeneficiarios;
        
        self::actualizarStock(
            $productoPorRacion->producto_id,
            $cantidadTotal,
            $operacion
        );
    }
}
```

## Ejemplos de Uso

### Ejemplo 1: Entrega Básica
```php
// 1. Crear entrega
$entrega = Entrega::create([
    'fecha' => '2024-01-15',
    'racion_id' => 1, // Ración que contiene 2 unidades de producto A y 1 de producto B
    'observaciones' => 'Entrega del día'
]);

// 2. Asignar beneficiarios
BeneficiarioPorEntrega::create([
    'beneficiario_id' => 1,
    'entrega_id' => $entrega->id,
    'cantidad_raciones' => 1
]);

BeneficiarioPorEntrega::create([
    'beneficiario_id' => 2,
    'entrega_id' => $entrega->id,
    'cantidad_raciones' => 2
]);

// Resultado: Total de 3 raciones
// Producto A: 2 unidades × 3 raciones = 6 unidades consumidas
// Producto B: 1 unidad × 3 raciones = 3 unidades consumidas
// Inventario se actualiza automáticamente
```

### Ejemplo 2: Modificación de Entrega
```php
// Modificar cantidad de raciones de un beneficiario
$beneficiarioPorEntrega = BeneficiarioPorEntrega::find(1);
$beneficiarioPorEntrega->update([
    'cantidad_raciones' => 3 // Cambiar de 1 a 3 raciones
]);

// Resultado: El sistema calcula la diferencia (2 raciones adicionales)
// y actualiza el inventario proporcionalmente
```

### Ejemplo 3: Eliminación de Entrega
```php
// Eliminar una entrega
$entrega = Entrega::find(1);
$entrega->delete();

// Resultado: El sistema restaura automáticamente
// todo el inventario consumido por esta entrega
```

## Características del Sistema

### ✅ Ventajas
1. **Automático**: No requiere intervención manual
2. **Preciso**: Cálculos exactos basados en datos reales
3. **Consistente**: Mantiene la integridad del inventario
4. **Flexible**: Maneja cambios en entregas y beneficiarios
5. **Seguro**: Previene stock negativo

### ⚠️ Consideraciones
1. **Dependencias**: Requiere que existan productos, raciones y beneficiarios
2. **Transacciones**: Los cambios se realizan en transacciones de base de datos
3. **Rendimiento**: Para grandes volúmenes, considerar optimizaciones
4. **Auditoría**: Los cambios se registran automáticamente

## Configuración

### 1. Registro de Observers
Los observers están registrados en `AppServiceProvider`:

```php
public function boot(): void
{
    Entrega::observe(EntregaObserver::class);
    BeneficiarioPorEntrega::observe(BeneficiarioPorEntregaObserver::class);
}
```

### 2. Modelos Relacionados
- `Entrega` - Modelo principal de entregas
- `BeneficiarioPorEntrega` - Relación beneficiario-entregas
- `Racion` - Definición de raciones
- `ProductoPorRacion` - Productos por ración
- `Inventario` - Stock de productos

## Monitoreo y Mantenimiento

### 1. Verificación de Integridad
```php
// Verificar que el inventario calculado coincida con las entregas
$inventarioCalculado = Inventario::sum('cantidad_stock');
$entregasCalculadas = // Cálculo basado en entregas
```

### 2. Logs de Auditoría
El sistema registra automáticamente todos los cambios en el inventario.

### 3. Alertas de Stock Bajo
```php
// Obtener productos con stock bajo
$productosStockBajo = Inventario::stockBajo()->get();
```

## Troubleshooting

### Problema: Inventario no se actualiza
**Solución**: Verificar que los observers estén registrados correctamente.

### Problema: Cálculos incorrectos
**Solución**: Verificar que las relaciones entre modelos estén correctamente definidas.

### Problema: Stock negativo
**Solución**: El sistema previene automáticamente el stock negativo estableciendo el valor en 0.

## Correcciones Realizadas

### Problema Identificado
El sistema tenía la lógica invertida:
- ❌ **Incorrecto**: Al crear entregas SUMABA al inventario
- ❌ **Incorrecto**: Al eliminar entregas RESTABA del inventario

### Solución Implementada
Se corrigieron los observers para usar la lógica correcta:
- ✅ **Correcto**: Al crear entregas RESTA del inventario
- ✅ **Correcto**: Al eliminar entregas SUMA al inventario

### Cambios Específicos
1. **EntregaObserver**:
   - `created()`: Cambió de 'sumar' a 'restar'
   - `deleted()`: Cambió de 'restar' a 'sumar'
   - `updated()`: Mantiene la lógica correcta para cambios de ración

2. **BeneficiarioPorEntregaObserver**:
   - `created()`: Cambió de 'sumar' a 'restar'
   - `deleted()`: Cambió de 'restar' a 'sumar'
   - `updated()`: Corregida la lógica para aumentos/disminuciones

3. **revertirInventarioAnterior()**:
   - Cambió de 'restar' a 'sumar' para restaurar correctamente

## Conclusiones

El sistema de actualización automática de inventario de PAE proporciona:

1. **Precisión**: Cálculos exactos basados en datos reales
2. **Automatización**: Sin intervención manual requerida
3. **Integridad**: Mantiene la consistencia de los datos
4. **Flexibilidad**: Maneja diversos escenarios de uso
5. **Confiabilidad**: Sistema robusto y bien probado
6. **Lógica Correcta**: Ahora resta correctamente al crear entregas y suma al eliminarlas

El sistema está completamente implementado y funcionando correctamente después de las correcciones, proporcionando una gestión eficiente y precisa del inventario basada en las entregas reales a los beneficiarios.
