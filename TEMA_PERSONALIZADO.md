# Tema Personalizado de Filament - Sistema PAE

## 🎨 Colores del Tema

Este tema personalizado utiliza los siguientes colores principales:

### Colores Principales
- **Color Primario**: `#F5276C` (Rosa/Magenta vibrante)
- **Color Secundario**: `#F54927` (Naranja/Rojo vibrante)  
- **Color Terciario**: `#F5B027` (Amarillo/Dorado vibrante)

### Paleta de Colores Completa

#### Color Primario (#F5276C)
- 50: `#FEF2F8` - Muy claro
- 100: `#FDE7F3` - Claro
- 200: `#FBCFE8` - Medio claro
- 300: `#F9A8D4` - Medio
- 400: `#F472B6` - Medio oscuro
- 500: `#F5276C` - **Principal**
- 600: `#DB2777` - Oscuro
- 700: `#BE185D` - Muy oscuro
- 800: `#9D174D` - Extra oscuro
- 900: `#831843` - Ultra oscuro
- 950: `#500724` - Máximo oscuro

#### Color Secundario (#F54927)
- 50: `#FEF2F1` - Muy claro
- 100: `#FDE5E2` - Claro
- 200: `#FBCBC4` - Medio claro
- 300: `#F7A59A` - Medio
- 400: `#F2726F` - Medio oscuro
- 500: `#F54927` - **Principal**
- 600: `#E63E1F` - Oscuro
- 700: `#C2311A` - Muy oscuro
- 800: `#9B2A1A` - Extra oscuro
- 900: `#7D2419` - Ultra oscuro
- 950: `#430F0C` - Máximo oscuro

#### Color Terciario (#F5B027)
- 50: `#FFFBEB` - Muy claro
- 100: `#FEF3C7` - Claro
- 200: `#FDE68A` - Medio claro
- 300: `#FCD34D` - Medio
- 400: `#FBBF24` - Medio oscuro
- 500: `#F5B027` - **Principal**
- 600: `#D97706` - Oscuro
- 700: `#B45309` - Muy oscuro
- 800: `#92400E` - Extra oscuro
- 900: `#78350F` - Ultra oscuro
- 950: `#451A03` - Máximo oscuro

## 📁 Archivos del Tema

### Archivos PHP
- `app/Filament/Themes/CustomTheme.php` - Clase principal del tema
- `app/Filament/Pages/CustomTheme.php` - Página de visualización del tema
- `app/Providers/FilamentThemeServiceProvider.php` - Service Provider del tema
- `app/Console/Commands/ApplyCustomTheme.php` - Comando para aplicar el tema

### Archivos CSS
- `resources/css/filament/admin/theme.css` - Estilos base del tema
- `resources/css/filament/admin/custom-styles.css` - Estilos adicionales personalizados
- `public/css/filament/admin/theme.css` - Archivo compilado
- `public/css/filament/admin/custom-styles.css` - Archivo compilado

### Archivos de Vista
- `resources/views/filament/pages/custom-theme.blade.php` - Vista de la página del tema

### Configuración
- `tailwind.config.js` - Configuración de Tailwind con los nuevos colores
- `app/Providers/Filament/AdminPanelProvider.php` - Configuración del panel de Filament

## 🚀 Instalación y Aplicación

### 1. Aplicar el Tema
```bash
php artisan theme:apply
```

### 2. Limpiar Caché (si es necesario)
```bash
php artisan config:clear
php artisan view:clear
php artisan cache:clear
```

### 3. Compilar Assets (si usas Vite)
```bash
npm run build
```

## 🎯 Características del Tema

### Componentes Personalizados
- **Botones**: Gradientes y efectos hover personalizados
- **Cards**: Bordes redondeados y sombras con colores del tema
- **Sidebar**: Gradiente de fondo y navegación mejorada
- **Tablas**: Headers con gradientes y hover effects
- **Formularios**: Campos de entrada con colores del tema
- **Modales**: Headers con gradientes
- **Notificaciones**: Colores diferenciados por tipo
- **Badges**: Gradientes para cada color
- **Tabs**: Indicadores de color personalizados

### Efectos Visuales
- **Animaciones**: Transiciones suaves en hover
- **Gradientes**: Fondos con gradientes de los colores principales
- **Sombras**: Sombras con colores del tema
- **Bordes**: Bordes redondeados consistentes

### Modo Oscuro
- Soporte automático para modo oscuro
- Colores adaptados para mejor contraste
- Gradientes invertidos para mejor legibilidad

## 🔧 Personalización

### Cambiar Colores
Para cambiar los colores principales, edita los archivos:
1. `tailwind.config.js` - Colores de Tailwind
2. `resources/css/filament/admin/theme.css` - Variables CSS
3. `app/Providers/Filament/AdminPanelProvider.php` - Configuración de Filament

### Agregar Nuevos Estilos
Agrega tus estilos personalizados en:
- `resources/css/filament/admin/custom-styles.css`

### Modificar Componentes
Los estilos específicos de componentes están en:
- `resources/css/filament/admin/theme.css` - Estilos base
- `resources/css/filament/admin/custom-styles.css` - Estilos avanzados

## 📱 Responsive Design

El tema incluye:
- Diseño responsive para móviles y tablets
- Sidebar colapsable en pantallas pequeñas
- Cards adaptables
- Navegación optimizada para touch

## 🎨 Acceso a la Página del Tema

Una vez aplicado el tema, puedes acceder a la página de visualización del tema en:
- URL: `/admin/custom-theme`
- Navegación: Aparece en el menú lateral como "Tema Personalizado"

## 🔄 Actualizaciones

Para actualizar el tema:
1. Modifica los archivos CSS en `resources/css/filament/admin/`
2. Ejecuta `php artisan theme:apply`
3. Limpia la caché si es necesario

## 📝 Notas Técnicas

- El tema utiliza CSS custom properties (variables CSS) para fácil mantenimiento
- Compatible con Filament 3.x
- Utiliza Tailwind CSS para la base de estilos
- Soporte completo para modo oscuro
- Optimizado para rendimiento con CSS minificado
