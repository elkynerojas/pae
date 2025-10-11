# Modelos Eloquent del Sistema PAE

Este documento describe los modelos Eloquent creados para el sistema PAE (Programa de Alimentación Escolar).

## Modelos Principales

### 1. TipoProducto
- **Tabla**: `tipos_productos`
- **Campos**: id, nombre, descripcion, activo, timestamps
- **Relaciones**:
  - `productos()` - HasMany con Producto

### 2. PresentacionProducto
- **Tabla**: `presentaciones_productos`
- **Campos**: id, nombre, descripcion, activo, timestamps
- **Relaciones**:
  - `productos()` - HasMany con Producto

### 3. Producto
- **Tabla**: `productos`
- **Campos**: id, nombre, descripcion, activo, tipo_producto_id, presentacion_producto_id, timestamps
- **Relaciones**:
  - `tipoProducto()` - BelongsTo TipoProducto
  - `presentacionProducto()` - BelongsTo PresentacionProducto
  - `raciones()` - BelongsToMany con Racion (pivot: productos_por_racion)
  - `recepciones()` - BelongsToMany con Recepcion (pivot: productos_por_recepcion)
  - `productosPorRacion()` - HasMany ProductoPorRacion
  - `productosPorRecepcion()` - HasMany ProductoPorRecepcion

### 4. Racion
- **Tabla**: `raciones`
- **Campos**: id, nombre, descripcion, activo, timestamps
- **Relaciones**:
  - `productos()` - BelongsToMany con Producto (pivot: productos_por_racion)
  - `entregas()` - HasMany Entrega
  - `productosPorRacion()` - HasMany ProductoPorRacion

### 5. Recepcion
- **Tabla**: `recepciones`
- **Campos**: id, fecha, hora, usuario_id, observaciones, timestamps
- **Relaciones**:
  - `usuario()` - BelongsTo User
  - `productos()` - BelongsToMany con Producto (pivot: productos_por_recepcion)
  - `productosPorRecepcion()` - HasMany ProductoPorRecepcion

### 6. Beneficiario
- **Tabla**: `beneficiarios`
- **Campos**: id, codigo, nombres, apellidos, fecha_nacimiento, genero, grado, grupo, observaciones, activo, timestamps
- **Relaciones**:
  - `entregas()` - BelongsToMany con Entrega (pivot: beneficiarios_por_entrega)
  - `beneficiariosPorEntrega()` - HasMany BeneficiarioPorEntrega

### 7. Entrega
- **Tabla**: `entregas`
- **Campos**: id, fecha, racion_id, observaciones, timestamps
- **Relaciones**:
  - `racion()` - BelongsTo Racion
  - `beneficiarios()` - BelongsToMany con Beneficiario (pivot: beneficiarios_por_entrega)
  - `beneficiariosPorEntrega()` - HasMany BeneficiarioPorEntrega

### 8. Inventario
- **Tabla**: `inventario`
- **Campos**: id, timestamps (pendiente de completar migración)
- **Relaciones**: Por definir cuando se complete la migración

## Modelos Pivot

### 9. ProductoPorRacion
- **Tabla**: `productos_por_racion`
- **Campos**: id, producto_id, racion_id, cantidad, timestamps
- **Relaciones**:
  - `producto()` - BelongsTo Producto
  - `racion()` - BelongsTo Racion

### 10. ProductoPorRecepcion
- **Tabla**: `productos_por_recepcion`
- **Campos**: id, producto_id, recepcion_id, cantidad, timestamps
- **Relaciones**:
  - `producto()` - BelongsTo Producto
  - `recepcion()` - BelongsTo Recepcion

### 11. BeneficiarioPorEntrega
- **Tabla**: `beneficiarios_por_entrega`
- **Campos**: id, beneficiario_id, entrega_id, cantidad_raciones, observaciones, timestamps
- **Relaciones**:
  - `beneficiario()` - BelongsTo Beneficiario
  - `entrega()` - BelongsTo Entrega

## Scopes Disponibles

### TipoProducto
- `activos()` - Solo tipos activos

### PresentacionProducto
- `activos()` - Solo presentaciones activas

### Producto
- `activos()` - Solo productos activos

### Racion
- `activos()` - Solo raciones activas

### Beneficiario
- `activos()` - Solo beneficiarios activos
- `porGrado($grado)` - Por grado específico
- `porGrupo($grupo)` - Por grupo específico
- `buscar($termino)` - Búsqueda por código o nombre

### Recepcion
- `porFecha($fecha)` - Por fecha específica
- `porUsuario($usuarioId)` - Por usuario específico

### Entrega
- `porFecha($fecha)` - Por fecha específica
- `porRacion($racionId)` - Por ración específica
- `porRangoFechas($fechaInicio, $fechaFin)` - Por rango de fechas

## Accessors

### Beneficiario
- `nombreCompleto` - Combina nombres y apellidos

## Uso de los Modelos

```php
// Ejemplo de uso básico
$productos = Producto::activos()->with(['tipoProducto', 'presentacionProducto'])->get();

$beneficiarios = Beneficiario::porGrado('primero')->activos()->get();

$entregas = Entrega::porFecha('2025-01-15')->with(['racion', 'beneficiarios'])->get();

// Crear una nueva recepción
$recepcion = Recepcion::create([
    'fecha' => now()->toDateString(),
    'hora' => now()->toTimeString(),
    'usuario_id' => auth()->id(),
    'observaciones' => 'Recepción de productos del proveedor XYZ'
]);

// Agregar productos a la recepción
$recepcion->productos()->attach($productoId, ['cantidad' => 100]);
```

## Notas Importantes

1. Todos los modelos incluyen timestamps automáticos
2. Los campos booleanos `activo` están configurados como casts
3. Las fechas están configuradas con casts apropiados
4. Las relaciones many-to-many incluyen campos pivot adicionales
5. Se incluyen scopes útiles para consultas comunes
6. Los modelos están listos para usar con factories y seeders
