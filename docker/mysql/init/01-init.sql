-- 🚀 ISI Puntos Anclajes - Configuración Inicial de Base de Datos
-- Autor: Jonathan Alejandro Rodriguez Lopes (@ItsJhonAlex)
-- Fecha: $(date)

-- Crear base de datos si no existe
CREATE DATABASE IF NOT EXISTS `isi_puntos_anclajes` 
DEFAULT CHARACTER SET utf8mb4 
DEFAULT COLLATE utf8mb4_unicode_ci;

-- Usar la base de datos
USE `isi_puntos_anclajes`;

-- Configuraciones MySQL para Laravel
SET sql_mode = 'STRICT_TRANS_TABLES,NO_ZERO_DATE,NO_ZERO_IN_DATE,ERROR_FOR_DIVISION_BY_ZERO';

-- Otorgar permisos completos al usuario Laravel
GRANT ALL PRIVILEGES ON `isi_puntos_anclajes`.* TO 'laravel_user'@'%';
FLUSH PRIVILEGES;

-- Mensaje de confirmación
SELECT 'Base de datos ISI Puntos Anclajes configurada exitosamente! 🎉' AS mensaje; 