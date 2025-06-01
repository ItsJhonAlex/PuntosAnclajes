-- 🔧 Script para corregir permisos de MySQL
-- Soluciona el problema de acceso desde Docker network

-- Eliminar usuario existente si existe
DROP USER IF EXISTS 'laravel_user'@'%';
DROP USER IF EXISTS 'laravel_user'@'localhost';
DROP USER IF EXISTS 'laravel_user'@'172.19.0.1';

-- Crear usuario con permisos completos desde cualquier IP
CREATE USER 'laravel_user'@'%' IDENTIFIED BY 'laravel_pass_123';

-- Otorgar todos los permisos en la base de datos del proyecto
GRANT ALL PRIVILEGES ON `isi_puntos_anclajes`.* TO 'laravel_user'@'%';

-- Otorgar permisos adicionales necesarios para Laravel
GRANT CREATE, ALTER, DROP, INDEX, REFERENCES ON *.* TO 'laravel_user'@'%';

-- Aplicar cambios inmediatamente
FLUSH PRIVILEGES;

-- Mostrar confirmación
SELECT 'Usuario laravel_user configurado correctamente! 🎉' AS resultado;

-- Mostrar permisos otorgados
SHOW GRANTS FOR 'laravel_user'@'%'; 