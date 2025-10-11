# Módulo de Gestión de Usuarios - PAE

## Descripción
Módulo completo para la gestión de usuarios del sistema PAE (Programa de Alimentación Escolar), incluyendo creación, edición, visualización y eliminación de usuarios con diferentes roles y permisos.

## Características Implementadas

### 1. Modelo User Extendido
- **Campos adicionales**: apellidos, teléfono, cargo, rol, activo, último_acceso
- **Roles disponibles**: admin, gestor, operador
- **Scopes útiles**: activos(), porRol(), buscar()
- **Métodos de verificación**: isAdmin(), isGestor(), isOperador()
- **Accessor**: nombre_completo

### 2. Controlador UserController
- **CRUD completo**: index, create, store, show, edit, update, destroy
- **Funcionalidad adicional**: toggleStatus() para activar/desactivar usuarios
- **Filtros y búsqueda**: por nombre, email, rol y estado
- **Validaciones**: completas con reglas específicas
- **Seguridad**: previene auto-eliminación y auto-desactivación

### 3. Vistas Blade
- **index.blade.php**: Lista de usuarios con filtros y paginación
- **create.blade.php**: Formulario para crear nuevos usuarios
- **edit.blade.php**: Formulario para editar usuarios existentes
- **show.blade.php**: Vista detallada del usuario con información completa

### 4. Rutas
- **Rutas RESTful**: `/users` (GET, POST, PUT, DELETE)
- **Ruta adicional**: `/users/{user}/toggle-status` (PATCH)
- **Middleware**: Protegidas con autenticación

### 5. Migración
- **Archivo**: `2025_10_11_195540_add_fields_to_users_table.php`
- **Campos agregados**: apellidos, telefono, cargo, rol, activo, ultimo_acceso
- **Rollback**: Incluye método down() para revertir cambios

### 6. Seeder de Usuarios
- **Archivo**: `UserSeeder.php`
- **Usuarios de prueba**:
  - Administrador: admin@pae.com
  - Gestor: gestor@pae.com
  - Operador: operador@pae.com
  - Usuario inactivo: inactivo@pae.com
- **Contraseña por defecto**: password123

## Estructura de Archivos

```
app/
├── Models/
│   └── User.php (extendido)
├── Http/Controllers/
│   └── UserController.php
database/
├── migrations/
│   └── 2025_10_11_195540_add_fields_to_users_table.php
└── seeders/
    └── UserSeeder.php
resources/views/users/
├── index.blade.php
├── create.blade.php
├── edit.blade.php
└── show.blade.php
routes/
└── web.php (rutas agregadas)
```

## Funcionalidades por Rol

### Administrador (admin)
- Gestión completa de usuarios
- Acceso a todos los módulos
- Configuración del sistema
- Reportes avanzados

### Gestor (gestor)
- Gestión de beneficiarios
- Gestión de productos
- Gestión de entregas
- Reportes básicos

### Operador (operador)
- Consulta de beneficiarios
- Registro de entregas
- Consulta de inventario
- Reportes básicos

## Uso del Módulo

### 1. Acceso a la Gestión de Usuarios
```
GET /users
```

### 2. Crear Nuevo Usuario
```
GET /users/create
POST /users
```

### 3. Ver Detalles de Usuario
```
GET /users/{user}
```

### 4. Editar Usuario
```
GET /users/{user}/edit
PUT /users/{user}
```

### 5. Activar/Desactivar Usuario
```
PATCH /users/{user}/toggle-status
```

### 6. Eliminar Usuario
```
DELETE /users/{user}
```

## Filtros Disponibles

- **Búsqueda**: Por nombre, apellidos o email
- **Rol**: Filtrar por admin, gestor u operador
- **Estado**: Filtrar por usuarios activos o inactivos

## Validaciones

### Crear Usuario
- name: requerido, string, máximo 255 caracteres
- apellidos: requerido, string, máximo 255 caracteres
- email: requerido, email único, máximo 255 caracteres
- telefono: opcional, string, máximo 20 caracteres
- cargo: opcional, string, máximo 255 caracteres
- rol: requerido, debe ser admin, gestor u operador
- password: requerido, mínimo 8 caracteres, confirmado
- activo: booleano

### Editar Usuario
- Mismas validaciones que crear, excepto:
- email: único excepto para el usuario actual
- password: opcional (si está vacío, se mantiene la actual)

## Seguridad

- **Autenticación requerida**: Todas las rutas protegidas
- **Prevención de auto-eliminación**: No se puede eliminar el propio usuario
- **Prevención de auto-desactivación**: No se puede desactivar el propio usuario
- **Contraseñas hasheadas**: Usando Hash::make()
- **Validación CSRF**: Todos los formularios protegidos

## Instalación y Configuración

### 1. Ejecutar Migraciones
```bash
php artisan migrate
```

### 2. Ejecutar Seeder (Opcional)
```bash
php artisan db:seed --class=UserSeeder
```

### 3. Configurar Base de Datos
Asegúrate de que tu archivo `.env` tenga la configuración correcta de base de datos.

## Notas Técnicas

- **Paginación**: 15 usuarios por página
- **Ordenamiento**: Por nombre ascendente
- **Responsive**: Vistas adaptadas para móviles y desktop
- **Tailwind CSS**: Utilizado para el diseño
- **Laravel Blade**: Sistema de plantillas utilizado

## Próximas Mejoras Sugeridas

1. **Middleware de autorización**: Implementar permisos más granulares
2. **Auditoría**: Registrar cambios en usuarios
3. **Notificaciones**: Enviar emails al crear/editar usuarios
4. **Importación masiva**: Cargar usuarios desde CSV/Excel
5. **Perfiles de usuario**: Campos adicionales según el tipo de usuario
6. **Historial de sesiones**: Registrar accesos y actividades
7. **Políticas de contraseñas**: Reglas más estrictas
8. **Verificación de email**: Confirmación de email al registro

## Contacto y Soporte

Para dudas o mejoras sobre este módulo, contactar al equipo de desarrollo.
