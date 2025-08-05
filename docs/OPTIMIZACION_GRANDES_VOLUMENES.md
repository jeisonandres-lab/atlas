# Optimización para Grandes Volúmenes de Datos (100k - 1M+ registros)

## Resumen de Optimizaciones Implementadas

### 1. **Paginación Inteligente**
- **Antes**: Cargaba todos los registros de una vez
- **Ahora**: Paginación configurable (100-10,000 registros por página)
- **Beneficio**: Reduce uso de memoria de 1GB+ a ~50MB por request

### 2. **Streaming de Respuesta**
- **Antes**: Buffer completo en memoria
- **Ahora**: Envío en chunks de 8KB
- **Beneficio**: Respuesta inmediata, menor latencia

### 3. **Compresión GZIP**
- **Antes**: JSON sin comprimir
- **Ahora**: Compresión automática con gzip
- **Beneficio**: Reduce tamaño de respuesta en 70-80%

### 4. **Índices Optimizados**
- Índice en `activo` para filtros rápidos
- Índice compuesto `(activo, estatus)` para búsquedas
- Índice de texto `estatus(50)` para búsquedas LIKE
- Índice único para evitar duplicados

### 5. **Configuración MySQL Optimizada**
- Buffer pool: 70% de RAM
- Query cache desactivado (MySQL 5.7+)
- Buffers de memoria optimizados
- Timeouts extendidos

## Uso del API Optimizado

### Endpoint Principal
```
GET /estatus/obtenerEstatusGeneral
```

### Parámetros de Paginación
```javascript
// Ejemplo de uso
fetch('/estatus/obtenerEstatusGeneral?pagina=1&por_pagina=1000&buscar=activo')
  .then(response => response.json())
  .then(data => {
    console.log('Datos:', data.data);
    console.log('Paginación:', data.paginacion);
  });
```

### Parámetros Disponibles
- `pagina`: Número de página (default: 1)
- `por_pagina`: Registros por página (100-10,000, default: 1,000)
- `buscar`: Texto para filtrar (opcional)

### Respuesta Optimizada
```json
{
  "exito": true,
  "mensaje": "",
  "data": [
    {"id": 1, "value": "Activo"},
    {"id": 2, "value": "Inactivo"}
  ],
  "paginacion": {
    "pagina_actual": 1,
    "por_pagina": 1000,
    "total_registros": 50000,
    "total_paginas": 50,
    "hay_siguiente": true,
    "hay_anterior": false
  }
}
```

## Configuración del Servidor

### 1. **PHP Settings** (php.ini)
```ini
memory_limit = 512M
max_execution_time = 300
max_input_time = 300
output_buffering = Off
implicit_flush = On
zlib.output_compression = On
```

### 2. **MySQL Settings** (my.cnf)
```ini
[mysqld]
# Buffer Pool (70% de RAM disponible)
innodb_buffer_pool_size = 1G

# Log Files
innodb_log_file_size = 256M
innodb_log_buffer_size = 16M

# Performance
innodb_flush_log_at_trx_commit = 2
innodb_file_per_table = ON
innodb_flush_method = O_DIRECT

# Query Cache (desactivar para MySQL 5.7+)
query_cache_type = OFF
query_cache_size = 0

# Memory Buffers
tmp_table_size = 256M
max_heap_table_size = 256M
sort_buffer_size = 2M
read_buffer_size = 2M
read_rnd_buffer_size = 8M
join_buffer_size = 2M

# Connections
max_connections = 200
thread_cache_size = 50
table_open_cache = 4000
open_files_limit = 65535
```

### 3. **Apache/Nginx Settings**
```apache
# Apache (.htaccess)
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE application/json
    AddOutputFilterByType DEFLATE text/html
    AddOutputFilterByType DEFLATE text/css
    AddOutputFilterByType DEFLATE application/javascript
</IfModule>

# Nginx (nginx.conf)
gzip on;
gzip_types application/json text/html text/css application/javascript;
gzip_comp_level 6;
gzip_min_length 1000;
```

## Monitoreo de Rendimiento

### 1. **Métricas a Monitorear**
- Tiempo de respuesta promedio
- Uso de memoria por request
- Tamaño de respuesta comprimida vs sin comprimir
- Número de conexiones simultáneas
- Uso de CPU durante picos

### 2. **Herramientas Recomendadas**
```bash
# Monitoreo MySQL
mysql> SHOW STATUS LIKE 'Slow_queries';
mysql> SHOW STATUS LIKE 'Questions';
mysql> SHOW STATUS LIKE 'Threads_connected';

# Monitoreo PHP
php -m | grep -E "(opcache|apc|redis)"

# Monitoreo Sistema
htop
iotop
netstat -an | grep :80 | wc -l
```

### 3. **Logs de Rendimiento**
```php
// Agregar en el controlador para monitoreo
$startTime = microtime(true);
$startMemory = memory_get_usage();

// ... código de consulta ...

$endTime = microtime(true);
$endMemory = memory_get_usage();

error_log(sprintf(
    "Estatus Query - Time: %.4fs, Memory: %s, Records: %d",
    $endTime - $startTime,
    $this->formatBytes($endMemory - $startMemory),
    count($datosGeneralEstatus)
));
```

## Estrategias de Caché

### 1. **Redis Cache** (Recomendado)
```php
// Implementar en EstatusController
private function getCachedEstatus($key, $callback) {
    $redis = new Redis();
    $redis->connect('localhost', 6379);
    
    $cached = $redis->get($key);
    if ($cached) {
        return json_decode($cached, true);
    }
    
    $data = $callback();
    $redis->setex($key, 300, json_encode($data)); // 5 minutos
    
    return $data;
}
```

### 2. **APC/OPcache**
```ini
; php.ini
opcache.enable = 1
opcache.memory_consumption = 128
opcache.interned_strings_buffer = 8
opcache.max_accelerated_files = 4000
```

## Escalabilidad Horizontal

### 1. **Load Balancer**
```nginx
# nginx.conf
upstream backend {
    server 192.168.1.10:80 weight=3;
    server 192.168.1.11:80 weight=3;
    server 192.168.1.12:80 weight=3;
    server 192.168.1.13:80 weight=1 backup;
}
```

### 2. **Database Sharding**
```sql
-- Para tablas con 10M+ registros
-- Particionamiento por rango de ID
ALTER TABLE estatus PARTITION BY RANGE (id_estatus) (
    PARTITION p0 VALUES LESS THAN (100000),
    PARTITION p1 VALUES LESS THAN (200000),
    PARTITION p2 VALUES LESS THAN (300000),
    -- ... más particiones
    PARTITION p99 VALUES LESS THAN MAXVALUE
);
```

## Troubleshooting

### 1. **Problemas Comunes**

**Error: Memory limit exceeded**
```php
// Solución: Reducir por_pagina
$porPagina = min(1000, $porPagina);
```

**Error: Timeout**
```php
// Solución: Aumentar timeouts
set_time_limit(300);
ini_set('max_execution_time', 300);
```

**Error: Too many connections**
```sql
-- Solución: Aumentar max_connections
SET GLOBAL max_connections = 500;
```

### 2. **Debugging**
```php
// Agregar en desarrollo
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Log detallado
error_log("Query: " . $sql);
error_log("Params: " . json_encode($parametros));
error_log("Result count: " . count($resultado));
```

## Benchmarks Esperados

### Con 100,000 registros:
- **Tiempo de respuesta**: < 200ms
- **Uso de memoria**: < 50MB
- **Tamaño de respuesta**: < 2MB (comprimido)

### Con 1,000,000 registros:
- **Tiempo de respuesta**: < 500ms (con paginación)
- **Uso de memoria**: < 100MB
- **Tamaño de respuesta**: < 20MB (comprimido, por página)

## Próximas Optimizaciones

1. **Implementar Redis Cache**
2. **Agregar índices full-text para búsquedas avanzadas**
3. **Implementar lazy loading en frontend**
4. **Agregar compresión Brotli (más eficiente que gzip)**
5. **Implementar CDN para assets estáticos** 