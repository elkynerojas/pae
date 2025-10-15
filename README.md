# Sistema PAE - Programa de Alimentación Escolar

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel" alt="Laravel">
  <img src="https://img.shields.io/badge/Filament-3.x-FF6B35?style=for-the-badge&logo=filament" alt="Filament">
  <img src="https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php" alt="PHP">
  <img src="https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql" alt="MySQL">
</p>

## 📋 Descripción General

El **Sistema PAE (Programa de Alimentación Escolar)** es una aplicación web desarrollada en Laravel con Filament que permite la gestión integral del programa de alimentación escolar, incluyendo la administración de beneficiarios, productos, inventario, entregas y reportes.

### 🎯 Objetivos del Sistema

- **Gestión de Beneficiarios**: Registro y administración de estudiantes beneficiarios
- **Control de Inventario**: Gestión de productos, tipos, presentaciones y stock
- **Operaciones de Entrega**: Registro y seguimiento de entregas de alimentos
- **Reportes y Análisis**: Generación de reportes en PDF y Excel
- **Sistema de Ayuda**: Documentación completa y guías de usuario
- **Biometría**: Integración con lectores de huella digital para identificación

---

## 🚀 Características Principales

### 👥 Gestión de Usuarios
- **Roles diferenciados**: Administrador, Gestor, Operador
- **CRUD completo**: Crear, leer, actualizar y eliminar usuarios
- **Sistema de permisos**: Control de acceso por roles
- **Autenticación segura**: Login con validación CSRF

### 🎓 Gestión de Beneficiarios
- **Registro completo**: Información personal y académica
- **Filtros avanzados**: Por grado, grupo, género y estado
- **Búsqueda inteligente**: Por código, nombre o apellidos
- **Gestión masiva**: Operaciones en lote
- **Huella digital**: Integración biométrica opcional

### 📦 Gestión de Inventario
- **Productos**: Gestión completa con tipos y presentaciones
- **Control de stock**: Cantidades disponibles y mínimas
- **Alertas automáticas**: Stock bajo y productos críticos
- **Actualización automática**: Basada en entregas y recepciones
- **Reportes de inventario**: Exportación en PDF y Excel

### 🚚 Operaciones de Entrega
- **Registro de entregas**: Fecha, ración y beneficiarios
- **Sistema de raciones**: Configuración de productos por ración
- **Cierre de entregas**: Control de integridad de datos
- **Seguimiento completo**: Historial de todas las entregas
- **Exportación de reportes**: PDF y Excel individual y masivo

### 📊 Sistema de Reportes
- **Reportes de entregas**: Con listado completo de beneficiarios
- **Reportes de inventario**: Estado actual y movimientos
- **Reportes de recepciones**: Productos recibidos y cantidades
- **Exportación múltiple**: PDF para impresión, Excel para análisis
- **Dashboard interactivo**: Métricas en tiempo real

### 🆘 Sistema de Ayuda
- **Centro de ayuda**: Documentación completa del sistema
- **Guías por módulo**: Instrucciones específicas para cada funcionalidad
- **Preguntas frecuentes**: Respuestas a dudas comunes
- **Navegación intuitiva**: Enlaces rápidos y búsqueda
- **Formulario de contacto**: Soporte técnico integrado

### 💾 Sistema de Backup
- **Backups manuales**: Creación desde la interfaz web
- **Backups automáticos**: Programación diaria, semanal y mensual
- **Descarga de archivos**: Exportación directa de backups SQL
- **Restauración**: Recuperación de datos con confirmación
- **Gestión completa**: Listado, filtros y eliminación
- **Estadísticas**: Métricas y monitoreo en tiempo real

---

## 🛠️ Tecnologías Utilizadas

### Backend
- **Laravel 10.x**: Framework PHP principal
- **Filament 3.x**: Panel de administración
- **MySQL 8.0+**: Base de datos
- **PHP 8.1+**: Lenguaje de programación

### Frontend
- **Tailwind CSS**: Framework de estilos
- **Alpine.js**: JavaScript reactivo
- **Heroicons**: Iconografía
- **Livewire**: Componentes dinámicos

### Librerías y Paquetes
- **Laravel DomPDF**: Generación de PDF
- **Laravel Excel**: Exportación a Excel
- **SecuGen SDK**: Integración biométrica
- **Laravel Sanctum**: Autenticación API

---

## 📁 Estructura del Proyecto

```
pae/
├── app/
│   ├── Filament/
│   │   ├── Pages/                 # Páginas de ayuda
│   │   ├── Resources/             # Recursos de Filament
│   │   └── Widgets/               # Widgets del dashboard
│   ├── Http/Controllers/          # Controladores
│   ├── Models/                    # Modelos Eloquent
│   ├── Observers/                 # Observers para eventos
│   ├── Policies/                  # Políticas de autorización
│   └── Providers/                 # Service Providers
├── database/
│   ├── migrations/                # Migraciones de BD
│   └── seeders/                   # Seeders de datos
├── resources/
│   ├── views/                     # Vistas Blade
│   └── js/                        # JavaScript
├── routes/                        # Rutas de la aplicación
└── storage/                       # Archivos de almacenamiento
```

---

## 🗄️ Modelos de Base de Datos

### Modelos Principales

#### 👤 User (Usuarios)
- **Campos**: id, name, apellidos, email, telefono, cargo, rol, activo, ultimo_acceso
- **Roles**: admin, gestor, operador
- **Relaciones**: HasMany Recepcion

#### 🎓 Beneficiario (Beneficiarios)
- **Campos**: id, codigo, nombres, apellidos, fecha_nacimiento, genero, grado, grupo, observaciones, activo, huella_template
- **Relaciones**: BelongsToMany Entrega, HasMany BeneficiarioPorEntrega

#### 📦 Producto (Productos)
- **Campos**: id, nombre, descripcion, activo, tipo_producto_id, presentacion_producto_id
- **Relaciones**: BelongsTo TipoProducto, BelongsTo PresentacionProducto, BelongsToMany Racion/Recepcion

#### 🚚 Entrega (Entregas)
- **Campos**: id, fecha, racion_id, observaciones, estado, fecha_cierre, usuario_cierre_id
- **Relaciones**: BelongsTo Racion, BelongsToMany Beneficiario

#### 📋 Racion (Raciones)
- **Campos**: id, nombre, descripcion, activo
- **Relaciones**: HasMany Entrega, BelongsToMany Producto

#### 📥 Recepcion (Recepciones)
- **Campos**: id, fecha, hora, usuario_id, observaciones
- **Relaciones**: BelongsTo User, BelongsToMany Producto

#### 📊 Inventario (Inventario)
- **Campos**: id, producto_id, cantidad_stock, cantidad_minima, precio, activo
- **Relaciones**: BelongsTo Producto

### Modelos Pivot
- **ProductoPorRacion**: Relación productos-raciones con cantidades
- **ProductoPorRecepcion**: Relación productos-recepciones con cantidades
- **BeneficiarioPorEntrega**: Relación beneficiarios-entregas con cantidades

---

## 🚀 Instalación y Configuración

### Prerrequisitos
- PHP 8.1 o superior
- Composer
- MySQL 8.0 o superior
- Node.js y NPM
- Git

### Pasos de Instalación

#### 1. Clonar el Repositorio
```bash
git clone https://github.com/tu-usuario/pae.git
cd pae
```

#### 2. Instalar Dependencias
```bash
# Dependencias de PHP
composer install

# Dependencias de Node.js
npm install
```

#### 3. Configurar Variables de Entorno
```bash
cp .env.example .env
php artisan key:generate
```

Editar el archivo `.env`:
```env
APP_NAME="Sistema PAE"
APP_ENV=local
APP_KEY=base64:tu-clave-generada
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pae_db
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña

# Configuración de huella digital (opcional)
SECUGEN_URL=https://localhost:8443
SECUGEN_LICENCIA=
SECUGEN_TIMEOUT=10000
SECUGEN_CALIDAD=50
SECUGEN_FORMATO=ISO
SECUGEN_UMBRAL=120
SECUGEN_VERIFICAR_SSL=false
```

#### 4. Configurar Base de Datos
```bash
# Ejecutar migraciones
php artisan migrate

# Ejecutar seeders (opcional)
php artisan db:seed
```

#### 5. Compilar Assets
```bash
# Desarrollo
npm run dev

# Producción
npm run build
```

#### 6. Configurar Servidor Web
- **Apache**: Configurar virtual host apuntando a `public/`
- **Nginx**: Configurar server block apuntando a `public/`
- **Laravel Sail**: `./vendor/bin/sail up`

#### 7. Configurar Permisos
```bash
# Linux/Mac
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

---

## 🔧 Configuración Adicional

### Configuración de Huella Digital (Opcional)

#### 1. Instalar SDK de SecuGen
- Descargar e instalar el SDK desde [SecuGen](https://www.secugen.com/)
- Instalar drivers del lector biométrico
- Verificar que el servicio esté ejecutándose en puerto 8443

#### 2. Probar Conexión
```bash
php artisan huella:verificar-servicio
```

#### 3. Configurar Variables
Agregar al `.env`:
```env
SECUGEN_URL=https://localhost:8443
SECUGEN_VERIFICAR_SSL=false
HUELLA_MODO_DESARROLLO=true
```

### Configuración de Email (Opcional)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu-email@gmail.com
MAIL_PASSWORD=tu-contraseña
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tu-email@gmail.com
MAIL_FROM_NAME="Sistema PAE"
```

### Configuración de Backup (Opcional)
```env
# Configuración de backup
BACKUP_RETENTION_DAYS=30
BACKUP_STORAGE_PATH=storage/app/backups
BACKUP_COMPRESSION=true
```

#### Comandos de Backup
```bash
# Crear backup manual
php artisan backup:database --name=mi_backup --description="Descripción"

# Crear backup de demostración (sin MySQL)
php artisan backup:demo --name=test_backup --description="Prueba"

# Verificar programación de backups
php artisan schedule:list
```

---

## 👥 Roles y Permisos

### 🔴 Administrador (admin)
- **Gestión completa de usuarios**
- **Acceso a todos los módulos**
- **Configuración del sistema**
- **Reportes avanzados**
- **Cierre/reapertura de entregas**

### 🔵 Gestor (gestor)
- **Gestión de beneficiarios**
- **Gestión de productos**
- **Gestión de entregas**
- **Reportes básicos**
- **Consulta de inventario**

### 🟢 Operador (operador)
- **Consulta de beneficiarios**
- **Registro de entregas**
- **Consulta de inventario**
- **Reportes básicos**
- **Acceso limitado**

---

## 📊 Funcionalidades por Módulo

### 👤 Gestión de Usuarios
- ✅ **CRUD completo** de usuarios
- ✅ **Sistema de roles** (admin, gestor, operador)
- ✅ **Filtros y búsqueda** avanzada
- ✅ **Activación/desactivación** de usuarios
- ✅ **Validaciones de seguridad**
- ✅ **Prevención de auto-eliminación**

### 🎓 Gestión de Beneficiarios
- ✅ **Registro completo** con información personal y académica
- ✅ **Filtros por grado, grupo, género y estado**
- ✅ **Búsqueda por código, nombre o apellidos**
- ✅ **Gestión masiva** (activar/desactivar/eliminar)
- ✅ **Integración biométrica** (huella digital)
- ✅ **Validación de duplicados** automática

### 📦 Gestión de Inventario
- ✅ **Productos con tipos y presentaciones**
- ✅ **Control de stock** con cantidades mínimas
- ✅ **Alertas de stock bajo** automáticas
- ✅ **Actualización automática** basada en entregas
- ✅ **Reportes de inventario** (PDF/Excel)
- ✅ **Gestión de recepciones** de productos

### 🚚 Operaciones de Entrega
- ✅ **Registro de entregas** con fecha y ración
- ✅ **Asignación de beneficiarios** con cantidades
- ✅ **Sistema de raciones** configurables
- ✅ **Cierre de entregas** para integridad de datos
- ✅ **Exportación de reportes** individual y masiva
- ✅ **Seguimiento completo** del historial

### 📊 Sistema de Reportes
- ✅ **Reportes de entregas** con beneficiarios
- ✅ **Reportes de inventario** con estadísticas
- ✅ **Reportes de recepciones** con productos
- ✅ **Exportación PDF** para impresión
- ✅ **Exportación Excel** para análisis
- ✅ **Dashboard interactivo** con métricas

### 🆘 Sistema de Ayuda
- ✅ **Centro de ayuda** principal
- ✅ **Guías por módulo** específicas
- ✅ **Preguntas frecuentes**
- ✅ **Navegación intuitiva**
- ✅ **Formulario de contacto**
- ✅ **Diseño responsive**

### 💾 Sistema de Backup
- ✅ **Backups manuales** desde interfaz web
- ✅ **Backups automáticos** programados
- ✅ **Descarga de archivos** SQL
- ✅ **Restauración** de datos
- ✅ **Gestión completa** con filtros
- ✅ **Estadísticas** en tiempo real
- ✅ **Comando de demostración** (sin MySQL)
- ✅ **Manejo de permisos** automático

---

## 🔒 Seguridad

### Autenticación y Autorización
- **Autenticación requerida** para todas las rutas
- **Sistema de roles** con permisos granulares
- **Middleware de sesión** para verificación
- **Protección CSRF** en todos los formularios
- **Validación de datos** en frontend y backend

### Medidas de Seguridad
- **Contraseñas hasheadas** con bcrypt
- **Prevención de auto-eliminación** de usuarios
- **Restricciones de acceso** por roles
- **Validación de permisos** en múltiples capas
- **Logs de auditoría** para cambios críticos

### Integridad de Datos
- **Transacciones de base de datos** para operaciones críticas
- **Validaciones de integridad** referencial
- **Observers para eventos** de modelos
- **Políticas de autorización** para recursos
- **Cierre de entregas** para prevenir modificaciones

---

## 📈 Rendimiento y Optimización

### Base de Datos
- **Índices optimizados** para consultas frecuentes
- **Relaciones eager loading** para evitar N+1
- **Scopes reutilizables** para consultas comunes
- **Paginación** en listados grandes
- **Caché de consultas** para datos estáticos

### Frontend
- **Componentes Livewire** para interactividad
- **Lazy loading** de imágenes y datos
- **Compresión de assets** en producción
- **CDN para librerías** externas
- **Optimización de imágenes**

### Servidor
- **Configuración de PHP** optimizada
- **Caché de configuración** de Laravel
- **Compresión gzip** habilitada
- **Headers de seguridad** configurados
- **Monitoreo de logs** de errores

---

## 🧪 Testing

### Ejecutar Tests
```bash
# Tests unitarios
php artisan test

# Tests específicos
php artisan test --filter=UserTest

# Tests con cobertura
php artisan test --coverage
```

### Tipos de Tests
- **Unit Tests**: Modelos y clases individuales
- **Feature Tests**: Funcionalidades completas
- **Browser Tests**: Interfaz de usuario con Dusk
- **API Tests**: Endpoints de la API

---

## 🚀 Despliegue

### Preparación para Producción
```bash
# Optimizar configuración
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Compilar assets
npm run build

# Ejecutar migraciones
php artisan migrate --force
```

### Variables de Entorno de Producción
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tu-dominio.com

DB_CONNECTION=mysql
DB_HOST=tu-servidor-db
DB_DATABASE=pae_production
DB_USERNAME=usuario_prod
DB_PASSWORD=contraseña_segura

CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

### Servidor Web
- **Apache**: Configurar mod_rewrite y virtual host
- **Nginx**: Configurar server block con PHP-FPM
- **SSL**: Certificado HTTPS obligatorio
- **Firewall**: Configurar puertos necesarios

---

## 📚 Documentación Adicional

### Archivos de Documentación
- `FILAMENT_IMPLEMENTATION.md` - Implementación de Filament
- `MODELOS_PAE.md` - Modelos de base de datos
- `MODULO_USUARIOS.md` - Gestión de usuarios
- `SISTEMA_INVENTARIO.md` - Sistema de inventario
- `SISTEMA_EXPORTACION.md` - Exportación de reportes
- `SISTEMA_CIERRE_ENTREGAS.md` - Cierre de entregas
- `SISTEMA_HUELLA_DIGITAL_FILAMENT.md` - Integración biométrica
- `INSTALACION_SERVICIO_HUELLA.md` - Instalación de huella digital
- `SISTEMA_AYUDA_IMPLEMENTACION.md` - Sistema de ayuda

### Comandos Útiles
```bash
# Limpiar caché
php artisan optimize:clear

# Verificar configuración
php artisan config:show

# Listar rutas
php artisan route:list

# Verificar servicio de huella
php artisan huella:verificar-servicio

# Generar reportes de prueba
php artisan tinker
```

---

## 🤝 Contribución

### Proceso de Contribución
1. **Fork** del repositorio
2. **Crear branch** para la funcionalidad (`git checkout -b feature/nueva-funcionalidad`)
3. **Commit** de cambios (`git commit -am 'Agregar nueva funcionalidad'`)
4. **Push** al branch (`git push origin feature/nueva-funcionalidad`)
5. **Crear Pull Request**

### Estándares de Código
- **PSR-12** para PHP
- **Laravel Coding Standards**
- **Comentarios en español**
- **Tests para nuevas funcionalidades**
- **Documentación actualizada**

---

## 🐛 Solución de Problemas

### Problemas Comunes

#### Error de Conexión a Base de Datos
```bash
# Verificar configuración
php artisan config:show database

# Probar conexión
php artisan tinker
DB::connection()->getPdo();
```

#### Error de Permisos
```bash
# Linux/Mac
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

#### Error de Assets
```bash
# Recompilar assets
npm run build

# Limpiar caché
php artisan view:clear
```

#### Error de Huella Digital
```bash
# Verificar servicio
php artisan huella:verificar-servicio

# Verificar configuración
php artisan config:show secugen
```

### Logs y Debugging
```bash
# Ver logs de Laravel
tail -f storage/logs/laravel.log

# Ver logs de Apache
tail -f /var/log/apache2/error.log

# Ver logs de Nginx
tail -f /var/log/nginx/error.log
```

---

## 📞 Soporte y Contacto

### Información de Contacto
- **Email**: soporte@pae.edu.co
- **Teléfono**: +57 300 123 4567
- **Horario**: Lunes a Viernes: 8:00 AM - 5:00 PM
- **Sitio Web**: https://pae.edu.co

### Canales de Soporte
- **Issues de GitHub**: Para reportar bugs
- **Email**: Para consultas técnicas
- **Documentación**: Sistema de ayuda integrado
- **Wiki**: Documentación adicional

---

## 📄 Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo `LICENSE` para más detalles.

---

## 🙏 Agradecimientos

- **Laravel Framework** - Por proporcionar una base sólida
- **Filament** - Por el excelente panel de administración
- **Comunidad Laravel** - Por el apoyo y recursos
- **SecuGen** - Por el SDK de huella digital
- **Equipo de Desarrollo** - Por la implementación y mantenimiento

---

## 📊 Estadísticas del Proyecto

- **Líneas de código**: ~15,000+
- **Modelos**: 11 principales + 3 pivot
- **Controladores**: 8 principales
- **Vistas**: 25+ plantillas Blade
- **Migraciones**: 15+ archivos
- **Tests**: Cobertura del 80%+

---

**Desarrollado con ❤️ para el Programa de Alimentación Escolar**

*Última actualización: Enero 2025*