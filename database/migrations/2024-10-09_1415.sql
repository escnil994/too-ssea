CREATE DATABASE ssea;
		DEFAULT CHARACTER SET = 'utf8mb4';

-- Crear usuario 'ssea_user' con acceso completo a la base de datos 'ssea'
CREATE USER 'ssea_user'@'%' IDENTIFIED BY '12345678';

-- Otorgar todos los privilegios sobre la base de datos 'ssea' al usuario 'ssea_user'
GRANT ALL PRIVILEGES ON ssea.* TO 'ssea_user'@'%';

-- Aplicar los cambios de privilegios
FLUSH PRIVILEGES;

-- Mostrar los privilegios otorgados al usuario 'ssea_user' para verificar
SHOW GRANTS FOR 'ssea_user'@'%';


USE ssea;
-- Crear tabla 'usuarios' para gestionar usuarios del sistema
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    correo VARCHAR(255) NOT NULL UNIQUE,
    contrasena VARCHAR(255) NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    rol ENUM('administrador', 'operador', 'gerente', 'cliente') DEFAULT 'operador',
    estado ENUM('activo', 'inactivo') DEFAULT 'activo',
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    actualizado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Crear tabla 'operadores' para gestionar los operadores del sistema
CREATE TABLE operadores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    apellido VARCHAR(255) NOT NULL,
    codigo_empleado INT NOT NULL,
    extension_tel INT NOT NULL,
    status ENUM('inactivo', 'activo') NOT NULL, -- 0: inactivo, 1: activo
    id_usuario INT NOT NULL UNIQUE, -- Asegurar que un usuario solo puede ser un operador
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    actualizado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
) ENGINE=InnoDB;

-- Crear tabla 'clientes' para gestionar los clientes del sistema
CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL UNIQUE, -- Asegurar que un usuario solo puede ser un cliente
    nombre VARCHAR(255) NOT NULL,
    apellido VARCHAR(255) NOT NULL,
    telefono VARCHAR(20) NOT NULL,
    dui VARCHAR(20) NOT NULL,
    email VARCHAR(255) NOT NULL,
    status ENUM('inactivo', 'activo') NOT NULL, -- 0: inactivo, 1: activo
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    actualizado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
) ENGINE=InnoDB;

-- Crear tabla 'llamadas_emergencia' para almacenar las llamadas de emergencia
CREATE TABLE llamadas_emergencia (
    id INT AUTO_INCREMENT PRIMARY KEY,
    operador_id INT,
    cliente_id INT,
    tipo_emergencia ENUM('accidente', 'incendio', 'robo', 'emergencia médica', 'otro') NOT NULL,
    telefono VARCHAR(20) NOT NULL, -- teléfono del cliente
    resolucion ENUM('grúa', 'asistencia en accidente', 'compra de combustible', 'batería', 'otro'),
    estado ENUM('pendiente', 'completada', 'cancelada') DEFAULT 'pendiente' NOT NULL,
    razon_cancelacion TEXT,
    fecha_llamada DATE, -- fecha de la llamada
    hora_llamada TIME, -- hora de la llamada
    duracion INT NOT NULL, -- duración de la llamada en segundos
    calidad_servicio ENUM('mala', 'aceptable', 'Excelente'),
    fecha_confirmacion DATETIME,
    observaciones TEXT, -- campo para observaciones adicionales
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    actualizado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (operador_id) REFERENCES operadores(id),
    FOREIGN KEY (cliente_id) REFERENCES clientes(id)
) ENGINE=InnoDB;

CREATE TABLE gerentes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    apellido VARCHAR(255) NOT NULL,
    codigo_empleado INT NOT NULL,
    extension_tel INT NOT NULL,
    status ENUM('inactivo', 'activo') NOT NULL, -- 0: inactivo, 1: activo
    id_usuario INT NOT NULL UNIQUE, -- Asegurar que un usuario solo puede ser un operador
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    actualizado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
) ENGINE=InnoDB;


CREATE TABLE administradores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    apellido VARCHAR(255) NOT NULL,
    codigo_empleado INT NOT NULL,
    extension_tel INT NOT NULL,
    status ENUM('inactivo', 'activo') NOT NULL, -- 0: inactivo, 1: activo
    id_usuario INT NOT NULL UNIQUE, -- Asegurar que un usuario solo puede ser un operador
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    actualizado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
) ENGINE=InnoDB;