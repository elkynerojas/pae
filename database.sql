-- =====================================================
-- SISTEMA PAE - BASE DE DATOS
-- Programa de Alimentación Escolar
-- Autor: Jesús Antonio Durán Acevedo
-- Fecha: 2025
-- =====================================================

-- Crear base de datos si no existe
CREATE DATABASE IF NOT EXISTS pae CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Usar la base de datos
USE pae;

-- =====================================================
-- TABLA: usuarios
-- Almacena información de usuarios del sistema
-- =====================================================
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol ENUM('administrador', 'docente', 'coordinador') NOT NULL DEFAULT 'docente',
    estado ENUM('activo', 'inactivo') NOT NULL DEFAULT 'activo',
    ultimo_acceso DATETIME NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_rol (rol),
    INDEX idx_estado (estado)
) ENGINE=InnoDB;

-- =====================================================
-- TABLA: estudiantes
-- Almacena información de estudiantes beneficiarios
-- =====================================================
CREATE TABLE estudiantes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo_estudiante VARCHAR(20) UNIQUE NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    fecha_nacimiento DATE NOT NULL,
    genero ENUM('masculino', 'femenino') NOT NULL,
    grado INT NOT NULL CHECK (grado >= 1 AND grado <= 11),
    grupo CHAR(1) NOT NULL,
    tipo_racion ENUM('completa', 'refrigerio', 'especial') NOT NULL DEFAULT 'completa',
    estado ENUM('activo', 'inactivo', 'graduado', 'retirado') NOT NULL DEFAULT 'activo',
    huella_digital LONGTEXT NULL COMMENT 'Datos de huella digital en formato JSON',
    observaciones TEXT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_codigo (codigo_estudiante),
    INDEX idx_grado_grupo (grado, grupo),
    INDEX idx_estado (estado),
    INDEX idx_tipo_racion (tipo_racion)
) ENGINE=InnoDB;

-- =====================================================
-- TABLA: entregas
-- Registra las entregas de raciones a estudiantes
-- =====================================================
CREATE TABLE entregas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    estudiante_id INT NOT NULL,
    fecha_entrega DATE NOT NULL,
    hora_entrega TIME NOT NULL,
    tipo_racion ENUM('completa', 'refrigerio', 'especial') NOT NULL,
    estado ENUM('entregado', 'cancelado', 'pendiente') NOT NULL DEFAULT 'entregado',
    usuario_id INT NULL COMMENT 'Usuario que registró la entrega',
    metodo_verificacion ENUM('huella_digital', 'manual', 'qr') NOT NULL DEFAULT 'huella_digital',
    observaciones TEXT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (estudiante_id) REFERENCES estudiantes(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL,
    UNIQUE KEY unique_entrega_diaria (estudiante_id, fecha_entrega),
    INDEX idx_fecha (fecha_entrega),
    INDEX idx_estudiante (estudiante_id),
    INDEX idx_usuario (usuario_id),
    INDEX idx_estado (estado)
) ENGINE=InnoDB;

-- =====================================================
-- TABLA: incidentes
-- Registra incidentes durante las entregas
-- =====================================================
CREATE TABLE incidentes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo_incidente ENUM('problema_lector', 'perdida_racion', 'desorden_entrega', 'estudiante_ausente', 'otro') NOT NULL,
    estudiante_id INT NULL COMMENT 'Estudiante involucrado (opcional)',
    usuario_id INT NOT NULL COMMENT 'Usuario que reportó el incidente',
    fecha_incidente DATE NOT NULL,
    hora_incidente TIME NOT NULL,
    descripcion TEXT NOT NULL,
    estado ENUM('pendiente', 'en_revision', 'resuelto', 'cerrado') NOT NULL DEFAULT 'pendiente',
    prioridad ENUM('baja', 'media', 'alta', 'critica') NOT NULL DEFAULT 'media',
    solucion TEXT NULL,
    fecha_resolucion DATETIME NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (estudiante_id) REFERENCES estudiantes(id) ON DELETE SET NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    INDEX idx_fecha (fecha_incidente),
    INDEX idx_tipo (tipo_incidente),
    INDEX idx_estado (estado),
    INDEX idx_prioridad (prioridad),
    INDEX idx_usuario (usuario_id)
) ENGINE=InnoDB;

-- =====================================================
-- TABLA: configuracion_sistema
-- Configuraciones generales del sistema
-- =====================================================
CREATE TABLE configuracion_sistema (
    id INT AUTO_INCREMENT PRIMARY KEY,
    clave VARCHAR(100) UNIQUE NOT NULL,
    valor TEXT NOT NULL,
    descripcion TEXT NULL,
    tipo ENUM('texto', 'numero', 'booleano', 'json') NOT NULL DEFAULT 'texto',
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_clave (clave)
) ENGINE=InnoDB;

-- =====================================================
-- TABLA: logs_sistema
-- Registra actividades y eventos del sistema
-- =====================================================
CREATE TABLE logs_sistema (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NULL,
    accion VARCHAR(100) NOT NULL,
    tabla_afectada VARCHAR(50) NULL,
    registro_id INT NULL,
    datos_anteriores JSON NULL,
    datos_nuevos JSON NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL,
    INDEX idx_usuario (usuario_id),
    INDEX idx_accion (accion),
    INDEX idx_fecha (fecha_registro),
    INDEX idx_tabla (tabla_afectada)
) ENGINE=InnoDB;

-- =====================================================
-- TABLA: sesiones_usuarios
-- Control de sesiones activas
-- =====================================================
CREATE TABLE sesiones_usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    token_sesion VARCHAR(255) UNIQUE NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    user_agent TEXT NULL,
    fecha_inicio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_expiracion TIMESTAMP NOT NULL,
    estado ENUM('activa', 'expirada', 'cerrada') NOT NULL DEFAULT 'activa',
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    INDEX idx_token (token_sesion),
    INDEX idx_usuario (usuario_id),
    INDEX idx_estado (estado),
    INDEX idx_expiracion (fecha_expiracion)
) ENGINE=InnoDB;

-- =====================================================
-- INSERTAR DATOS INICIALES
-- =====================================================

-- Insertar usuario administrador por defecto
INSERT INTO usuarios (nombre, apellido, email, password, rol) VALUES 
('Administrador', 'Sistema', 'admin@pae.edu.co', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'administrador');

-- Insertar configuraciones iniciales del sistema
INSERT INTO configuracion_sistema (clave, valor, descripcion, tipo) VALUES
('nombre_institucion', 'Institución Educativa PAE', 'Nombre de la institución educativa', 'texto'),
('horario_entrega_inicio', '07:00:00', 'Hora de inicio para entregas', 'texto'),
('horario_entrega_fin', '14:00:00', 'Hora de fin para entregas', 'texto'),
('max_entregas_por_dia', '1', 'Máximo número de entregas por estudiante por día', 'numero'),
('habilitar_entrega_manual', 'true', 'Permitir entregas manuales sin huella', 'booleano'),
('dias_laborales', '["lunes","martes","miercoles","jueves","viernes"]', 'Días laborales para entregas', 'json'),
('version_sistema', '1.0', 'Versión actual del sistema', 'texto');

-- Insertar algunos estudiantes de ejemplo
INSERT INTO estudiantes (codigo_estudiante, nombre, apellido, fecha_nacimiento, genero, grado, grupo, tipo_racion) VALUES
('EST001', 'Ana María', 'García López', '2015-03-15', 'femenino', 1, 'A', 'completa'),
('EST002', 'Carlos Andrés', 'Rodríguez Pérez', '2014-08-22', 'masculino', 2, 'B', 'refrigerio'),
('EST003', 'María José', 'López Silva', '2013-11-10', 'femenino', 3, 'A', 'completa'),
('EST004', 'Juan David', 'Martínez Rojas', '2012-05-18', 'masculino', 4, 'C', 'especial'),
('EST005', 'Sofía Alejandra', 'González Vargas', '2011-12-03', 'femenino', 5, 'B', 'completa');

-- =====================================================
-- VISTAS ÚTILES
-- =====================================================

-- Vista para reporte diario de entregas
CREATE VIEW vista_entregas_diarias AS
SELECT 
    e.fecha_entrega,
    COUNT(*) as total_entregas,
    COUNT(CASE WHEN e.tipo_racion = 'completa' THEN 1 END) as raciones_completas,
    COUNT(CASE WHEN e.tipo_racion = 'refrigerio' THEN 1 END) as refrigerios,
    COUNT(CASE WHEN e.tipo_racion = 'especial' THEN 1 END) as raciones_especiales,
    COUNT(CASE WHEN e.metodo_verificacion = 'huella_digital' THEN 1 END) as por_huella,
    COUNT(CASE WHEN e.metodo_verificacion = 'manual' THEN 1 END) as manuales
FROM entregas e
WHERE e.estado = 'entregado'
GROUP BY e.fecha_entrega
ORDER BY e.fecha_entrega DESC;

-- Vista para estadísticas por grado
CREATE VIEW vista_estadisticas_grado AS
SELECT 
    est.grado,
    est.grupo,
    COUNT(est.id) as total_estudiantes,
    COUNT(CASE WHEN est.estado = 'activo' THEN 1 END) as estudiantes_activos,
    COUNT(CASE WHEN e.id IS NOT NULL THEN 1 END) as entregas_hoy,
    ROUND((COUNT(CASE WHEN e.id IS NOT NULL THEN 1 END) / COUNT(est.id)) * 100, 2) as porcentaje_cobertura
FROM estudiantes est
LEFT JOIN entregas e ON est.id = e.estudiante_id 
    AND e.fecha_entrega = CURDATE() 
    AND e.estado = 'entregado'
GROUP BY est.grado, est.grupo
ORDER BY est.grado, est.grupo;

-- Vista para incidentes pendientes
CREATE VIEW vista_incidentes_pendientes AS
SELECT 
    i.id,
    i.tipo_incidente,
    i.descripcion,
    i.prioridad,
    i.fecha_incidente,
    CONCAT(est.nombre, ' ', est.apellido) as estudiante,
    CONCAT(u.nombre, ' ', u.apellido) as reportado_por
FROM incidentes i
LEFT JOIN estudiantes est ON i.estudiante_id = est.id
LEFT JOIN usuarios u ON i.usuario_id = u.id
WHERE i.estado IN ('pendiente', 'en_revision')
ORDER BY 
    CASE i.prioridad 
        WHEN 'critica' THEN 1 
        WHEN 'alta' THEN 2 
        WHEN 'media' THEN 3 
        WHEN 'baja' THEN 4 
    END,
    i.fecha_incidente DESC;

-- =====================================================
-- PROCEDIMIENTOS ALMACENADOS
-- =====================================================

DELIMITER //

-- Procedimiento para registrar una entrega
CREATE PROCEDURE sp_registrar_entrega(
    IN p_estudiante_id INT,
    IN p_tipo_racion ENUM('completa', 'refrigerio', 'especial'),
    IN p_usuario_id INT,
    IN p_metodo_verificacion ENUM('huella_digital', 'manual', 'qr'),
    IN p_observaciones TEXT
)
BEGIN
    DECLARE v_fecha_actual DATE DEFAULT CURDATE();
    DECLARE v_hora_actual TIME DEFAULT CURTIME();
    DECLARE v_entrega_existente INT DEFAULT 0;
    
    -- Verificar si ya existe una entrega para hoy
    SELECT COUNT(*) INTO v_entrega_existente
    FROM entregas 
    WHERE estudiante_id = p_estudiante_id 
    AND fecha_entrega = v_fecha_actual;
    
    IF v_entrega_existente > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'El estudiante ya recibió su ración hoy';
    ELSE
        INSERT INTO entregas (
            estudiante_id, 
            fecha_entrega, 
            hora_entrega, 
            tipo_racion, 
            usuario_id, 
            metodo_verificacion, 
            observaciones
        ) VALUES (
            p_estudiante_id,
            v_fecha_actual,
            v_hora_actual,
            p_tipo_racion,
            p_usuario_id,
            p_metodo_verificacion,
            p_observaciones
        );
        
        SELECT 'Entrega registrada exitosamente' as mensaje;
    END IF;
END //

-- Procedimiento para generar reporte diario
CREATE PROCEDURE sp_reporte_diario(IN p_fecha DATE)
BEGIN
    SELECT 
        p_fecha as fecha,
        COUNT(DISTINCT est.id) as total_estudiantes,
        COUNT(e.id) as total_entregas,
        ROUND((COUNT(e.id) / COUNT(DISTINCT est.id)) * 100, 2) as porcentaje_cobertura,
        COUNT(CASE WHEN e.tipo_racion = 'completa' THEN 1 END) as raciones_completas,
        COUNT(CASE WHEN e.tipo_racion = 'refrigerio' THEN 1 END) as refrigerios,
        COUNT(CASE WHEN e.tipo_racion = 'especial' THEN 1 END) as raciones_especiales,
        COUNT(CASE WHEN i.id IS NOT NULL THEN 1 END) as incidentes_reportados
    FROM estudiantes est
    LEFT JOIN entregas e ON est.id = e.estudiante_id 
        AND e.fecha_entrega = p_fecha 
        AND e.estado = 'entregado'
    LEFT JOIN incidentes i ON est.id = i.estudiante_id 
        AND i.fecha_incidente = p_fecha
    WHERE est.estado = 'activo';
END //

-- Procedimiento para limpiar sesiones expiradas
CREATE PROCEDURE sp_limpiar_sesiones_expiradas()
BEGIN
    UPDATE sesiones_usuarios 
    SET estado = 'expirada' 
    WHERE fecha_expiracion < NOW() 
    AND estado = 'activa';
    
    SELECT ROW_COUNT() as sesiones_limpiadas;
END //

DELIMITER ;

-- =====================================================
-- TRIGGERS
-- =====================================================

DELIMITER //

-- Trigger para registrar logs de entregas
CREATE TRIGGER tr_log_entrega_after_insert
AFTER INSERT ON entregas
FOR EACH ROW
BEGIN
    INSERT INTO logs_sistema (
        usuario_id, 
        accion, 
        tabla_afectada, 
        registro_id, 
        datos_nuevos
    ) VALUES (
        NEW.usuario_id,
        'INSERT',
        'entregas',
        NEW.id,
        JSON_OBJECT(
            'estudiante_id', NEW.estudiante_id,
            'fecha_entrega', NEW.fecha_entrega,
            'tipo_racion', NEW.tipo_racion,
            'metodo_verificacion', NEW.metodo_verificacion
        )
    );
END //

-- Trigger para registrar logs de incidentes
CREATE TRIGGER tr_log_incidente_after_insert
AFTER INSERT ON incidentes
FOR EACH ROW
BEGIN
    INSERT INTO logs_sistema (
        usuario_id, 
        accion, 
        tabla_afectada, 
        registro_id, 
        datos_nuevos
    ) VALUES (
        NEW.usuario_id,
        'INSERT',
        'incidentes',
        NEW.id,
        JSON_OBJECT(
            'tipo_incidente', NEW.tipo_incidente,
            'estudiante_id', NEW.estudiante_id,
            'prioridad', NEW.prioridad
        )
    );
END //

DELIMITER ;

-- =====================================================
-- ÍNDICES ADICIONALES PARA OPTIMIZACIÓN
-- =====================================================

-- Índices compuestos para consultas frecuentes
CREATE INDEX idx_entregas_fecha_estudiante ON entregas(fecha_entrega, estudiante_id);
CREATE INDEX idx_incidentes_fecha_tipo ON incidentes(fecha_incidente, tipo_incidente);
CREATE INDEX idx_estudiantes_grado_grupo_estado ON estudiantes(grado, grupo, estado);

-- =====================================================
-- PERMISOS Y USUARIOS (OPCIONAL)
-- =====================================================

-- Crear usuario específico para la aplicación (opcional)
-- CREATE USER 'pae_user'@'localhost' IDENTIFIED BY 'pae_password_2025';
-- GRANT SELECT, INSERT, UPDATE, DELETE ON pae.* TO 'pae_user'@'localhost';
-- FLUSH PRIVILEGES;

-- =====================================================
-- FINALIZACIÓN
-- =====================================================

-- Mostrar resumen de la base de datos creada
SELECT 
    'Base de datos PAE creada exitosamente' as mensaje,
    COUNT(*) as total_tablas
FROM information_schema.tables 
WHERE table_schema = 'pae';

-- Mostrar las tablas creadas
SELECT 
    table_name as tabla,
    table_rows as filas_estimadas,
    ROUND(((data_length + index_length) / 1024 / 1024), 2) as tamanio_mb
FROM information_schema.tables 
WHERE table_schema = 'pae'
ORDER BY table_name; 