# Sistema de Huella Digital para Filament

## Descripción

Este sistema integra la funcionalidad de captura y verificación de huellas digitales en el recurso Filament de beneficiarios, utilizando el SDK de SecuGen para la captura biométrica.

## Características Implementadas

### 1. Componente Personalizado de Filament
- **Archivo**: `app/Filament/Forms/Components/HuellaDigitalField.php`
- **Vista**: `resources/views/filament/forms/components/huella-digital-field.blade.php`
- **Funcionalidad**: Campo personalizado para captura de huella digital con interfaz intuitiva

### 2. Controlador de Huella Digital
- **Archivo**: `app/Http/Controllers/HuellaDigitalController.php`
- **Métodos**:
  - `capturarHuella()`: Captura una nueva huella usando el SDK
  - `compararHuellas()`: Compara dos huellas digitales
  - `verificarHuellaExistente()`: Verifica si una huella ya está registrada
  - `obtenerTodasPlantillas()`: Obtiene todas las plantillas para comparación

### 3. Integración en BeneficiarioResource
- Sección colapsible "Huella Digital" en el formulario
- Columna en la tabla que muestra el estado de la huella
- Validación automática de duplicados

### 4. JavaScript Adaptado
- **Archivo**: `resources/js/filament/huella-digital.js`
- Adaptación del código original para funcionar con Filament
- Manejo de notificaciones de Filament
- Verificación automática de duplicados

## Configuración Requerida

### 1. Hardware
- Lector biométrico SecuGen compatible
- Servicio SecuGen SDK ejecutándose en `https://localhost:8443`

### 2. Base de Datos
- Campo `huella_template` agregado a la tabla `beneficiarios`
- Migración ejecutada: `2025_10_14_022034_add_huellta_template_to_beneficiarios.php`

### 3. Rutas API
Las siguientes rutas están disponibles bajo autenticación:
- `POST /api/capturar-huella`
- `POST /api/comparar-huellas`
- `POST /api/verificar-huella-existente`
- `GET /api/obtener-todas-plantillas`

## Uso del Sistema

### 1. Registro de Huella Digital
1. Acceder al formulario de creación/edición de beneficiario
2. Expandir la sección "Huella Digital"
3. Hacer clic en "Capturar Huella"
4. Colocar el dedo en el lector biométrico
5. El sistema verificará automáticamente si la huella ya existe
6. Si es única, se guardará automáticamente

### 2. Verificación de Estado
- En la tabla de beneficiarios, la columna "Huella Digital" muestra:
  - ✅ Verde: Huella registrada
  - ❌ Gris: Sin huella registrada

### 3. Validaciones Automáticas
- **Detección de duplicados**: El sistema compara automáticamente contra todas las huellas existentes
- **Umbral de coincidencia**: 120 puntos (configurable en el código)
- **Formato**: ISO (estándar internacional)

## Configuración Técnica

### Parámetros del SDK
```javascript
const SECUGEN_CONFIG = {
    licencia: "", // Vacía para modo de prueba
    timeout: 10000, // 10 segundos
    calidad: 50, // Calidad de captura
    formato: "ISO", // Formato de plantilla
    umbralCoincidencia: 120 // Umbral para considerar coincidencia
};
```

### Estructura de Respuesta
```json
{
    "success": true,
    "template": "base64_encoded_template",
    "message": "Huella capturada correctamente"
}
```

## Seguridad

### 1. Autenticación
- Todas las rutas requieren autenticación
- Tokens CSRF para todas las peticiones AJAX

### 2. Validación de Datos
- Validación de plantillas antes de almacenar
- Verificación de duplicados en tiempo real
- Manejo de errores robusto

### 3. Logging
- Registro de errores en el log de Laravel
- Trazabilidad de operaciones biométricas

## Solución de Problemas

### 1. Error de Conexión con el Lector
- Verificar que el servicio SecuGen esté ejecutándose
- Comprobar la URL: `https://localhost:8443`
- Verificar certificados SSL (deshabilitados para desarrollo)

### 2. Huella No Detectada
- Verificar que el lector esté conectado y encendido
- Limpiar el sensor del lector
- Ajustar la calidad de captura si es necesario

### 3. Error de Duplicados
- El sistema detecta automáticamente huellas duplicadas
- Mensaje de error incluye el nombre del beneficiario que ya tiene esa huella

## Archivos Modificados/Creados

### Nuevos Archivos
- `app/Filament/Forms/Components/HuellaDigitalField.php`
- `app/Http/Controllers/HuellaDigitalController.php`
- `resources/views/filament/forms/components/huella-digital-field.blade.php`
- `resources/js/filament/huella-digital.js`
- `SISTEMA_HUELLA_DIGITAL_FILAMENT.md`

### Archivos Modificados
- `app/Models/Beneficiario.php` - Agregado campo `huella_template`
- `app/Filament/Resources/BeneficiarioResource.php` - Integración del componente
- `routes/web.php` - Rutas API
- `vite.config.js` - Inclusión del nuevo JS

## Próximos Pasos

1. **Compilar Assets**: Ejecutar `npm run build` para compilar el JavaScript
2. **Ejecutar Migración**: `php artisan migrate` para agregar el campo a la BD
3. **Configurar Lector**: Instalar y configurar el SDK de SecuGen
4. **Pruebas**: Probar la captura y verificación de huellas

## Notas Importantes

- El sistema está diseñado para funcionar con el SDK de SecuGen
- La licencia puede dejarse vacía para modo de prueba
- Los certificados SSL están deshabilitados para desarrollo local
- El umbral de coincidencia es configurable según las necesidades
