# Instalación del Servicio de Huella Digital

## 📋 **Requisitos Previos**

### **Hardware:**
- Lector biométrico SecuGen (Hamster Pro, U20, etc.)
- Cable USB para conectar el lector

### **Software:**
- Windows 10/11
- XAMPP (ya instalado)
- Laravel (ya configurado)

## 🔧 **Paso 1: Descargar e Instalar el SDK de SecuGen**

### **A. Descargar el SDK:**
1. Visitar el sitio oficial de SecuGen: https://www.secugen.com/
2. Ir a la sección de descargas
3. Descargar el SDK para Windows
4. Descargar los drivers del lector biométrico

### **B. Instalar el SDK:**
1. Ejecutar el instalador del SDK como administrador
2. Seguir las instrucciones del asistente de instalación
3. Instalar los drivers del lector biométrico
4. Reiniciar la computadora si es necesario

## 🔌 **Paso 2: Conectar el Lector Biométrico**

1. Conectar el lector biométrico al puerto USB
2. Verificar que Windows reconozca el dispositivo
3. Abrir el Administrador de dispositivos para confirmar

## ⚙️ **Paso 3: Configurar el Servicio**

### **A. Verificar la Instalación:**
```bash
# Verificar si el servicio está ejecutándose
netstat -an | findstr 8443
```

### **B. Iniciar el Servicio (si no está ejecutándose):**
1. Buscar "SecuGen Service" en el menú de inicio
2. Ejecutar como administrador
3. Verificar que esté ejecutándose en el puerto 8443

## 🧪 **Paso 4: Probar la Conexión**

### **A. Usando el Comando Artisan:**
```bash
php artisan huella:verificar-servicio
```

### **B. Usando cURL:**
```bash
curl -k https://localhost:8443/SGIFPCapture
```

### **C. Usando el Navegador:**
- Abrir: `https://localhost:8443`
- Debería mostrar información del servicio SecuGen

## 🔧 **Paso 5: Configurar el Proyecto Laravel**

### **A. Variables de Entorno:**
Agregar al archivo `.env`:
```env
# Configuración del servicio de huella digital
SECUGEN_URL=https://localhost:8443
SECUGEN_LICENCIA=
SECUGEN_TIMEOUT=10000
SECUGEN_CALIDAD=50
SECUGEN_FORMATO=ISO
SECUGEN_UMBRAL=120
SECUGEN_VERIFICAR_SSL=false
HUELLA_MODO_DESARROLLO=true
```

### **B. Verificar la Configuración:**
```bash
php artisan config:cache
php artisan huella:verificar-servicio
```

## 🎯 **Paso 6: Probar en el Navegador**

1. Ir al formulario de beneficiarios en Filament
2. Hacer clic en "Registrar Huella"
3. Hacer clic en "Capturar Huella"
4. Colocar el dedo en el lector
5. Verificar que se capture correctamente

## 🚨 **Solución de Problemas**

### **Error: "No se pudo conectar con el servicio"**
- Verificar que el SDK esté instalado
- Verificar que el servicio esté ejecutándose
- Verificar que el puerto 8443 esté disponible

### **Error: "Certificado SSL inválido"**
- Usar `SECUGEN_VERIFICAR_SSL=false` en desarrollo
- Instalar los certificados del SDK

### **Error: "Lector no detectado"**
- Verificar la conexión USB
- Reinstalar los drivers
- Probar en otro puerto USB

### **Error: "Timeout"**
- Aumentar el valor de `SECUGEN_TIMEOUT`
- Verificar que el lector esté limpio
- Probar con otro dedo

## 📞 **Soporte**

### **Documentación Oficial:**
- Manual del SDK de SecuGen
- Guía de instalación del lector

### **Comandos Útiles:**
```bash
# Verificar servicio
php artisan huella:verificar-servicio

# Limpiar caché de configuración
php artisan config:clear

# Ver logs de Laravel
tail -f storage/logs/laravel.log
```

## ✅ **Verificación Final**

Una vez completada la instalación, deberías poder:

1. ✅ Ejecutar `php artisan huella:verificar-servicio` sin errores
2. ✅ Ver el servicio respondiendo en `https://localhost:8443`
3. ✅ Capturar huellas desde el formulario de Filament
4. ✅ Verificar duplicados automáticamente
5. ✅ Guardar huellas en la base de datos

## 🔄 **Mantenimiento**

### **Regular:**
- Limpiar el sensor del lector
- Verificar que el servicio esté ejecutándose
- Actualizar drivers si es necesario

### **Mensual:**
- Verificar logs de errores
- Probar la funcionalidad completa
- Actualizar el SDK si hay nuevas versiones

