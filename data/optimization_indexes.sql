-- Script de optimización para tabla estatus con grandes volúmenes de datos
-- Ejecutar después de crear la tabla estatus

-- 1. Índice principal para búsquedas por activo
CREATE INDEX idx_estatus_activo ON estatus(activo);

-- 2. Índice compuesto para búsquedas con filtros
CREATE INDEX idx_estatus_activo_estatus ON estatus(activo, estatus);

-- 3. Índice para búsquedas por texto (primeros 50 caracteres)
CREATE INDEX idx_estatus_texto ON estatus(estatus(50));

-- 4. Índice para ordenamiento por ID
CREATE INDEX idx_estatus_id_orden ON estatus(id_estatus ASC);

-- 5. Índice único para evitar duplicados
CREATE UNIQUE INDEX idx_estatus_unique ON estatus(estatus, activo);

-- Configuraciones adicionales para optimización
-- Ejecutar en MySQL para mejorar rendimiento con grandes volúmenes

-- Configurar buffer pool (ajustar según RAM disponible)
-- SET GLOBAL innodb_buffer_pool_size = 1073741824; -- 1GB

-- Configurar log files
-- SET GLOBAL innodb_log_file_size = 268435456; -- 256MB

-- Configurar query cache (desactivar para MySQL 5.7+)
-- SET GLOBAL query_cache_type = OFF;
-- SET GLOBAL query_cache_size = 0;

-- Configurar buffers de memoria
-- SET GLOBAL tmp_table_size = 268435456; -- 256MB
-- SET GLOBAL max_heap_table_size = 268435456; -- 256MB
-- SET GLOBAL sort_buffer_size = 2097152; -- 2MB
-- SET GLOBAL read_buffer_size = 2097152; -- 2MB
-- SET GLOBAL read_rnd_buffer_size = 8388608; -- 8MB
-- SET GLOBAL join_buffer_size = 2097152; -- 2MB

-- Configurar conexiones
-- SET GLOBAL max_connections = 200;
-- SET GLOBAL thread_cache_size = 50;
-- SET GLOBAL table_open_cache = 4000;

-- Configurar límites de archivos
-- SET GLOBAL open_files_limit = 65535;

-- Analizar tabla para optimizar estadísticas
ANALYZE TABLE estatus;

-- Verificar índices creados
SHOW INDEX FROM estatus;

-- Verificar configuración actual
SHOW VARIABLES LIKE 'innodb_buffer_pool_size';
SHOW VARIABLES LIKE 'query_cache_type';
SHOW VARIABLES LIKE 'max_connections'; 