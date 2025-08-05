<?php

namespace App\Atlas\config;

use PDO;

/**
 * Configuraciones de optimización para bases de datos con grandes volúmenes de datos
 * Recomendado para tablas con 100k+ registros
 */
class DatabaseOptimization
{
    /**
     * Configuraciones recomendadas para MySQL con grandes volúmenes de datos
     */
    public static function getMySQLOptimizations()
    {
        return [
            'innodb_buffer_pool_size' => '70% of RAM', // Para tablas InnoDB
            'innodb_log_file_size' => '256M',
            'innodb_log_buffer_size' => '16M',
            'innodb_flush_log_at_trx_commit' => '2', // Mejor rendimiento
            'innodb_file_per_table' => 'ON',
            'innodb_flush_method' => 'O_DIRECT',
            'query_cache_type' => 'OFF', // Desactivar para MySQL 5.7+
            'query_cache_size' => '0',
            'tmp_table_size' => '256M',
            'max_heap_table_size' => '256M',
            'sort_buffer_size' => '2M',
            'read_buffer_size' => '2M',
            'read_rnd_buffer_size' => '8M',
            'join_buffer_size' => '2M',
            'max_connections' => '200',
            'thread_cache_size' => '50',
            'table_open_cache' => '4000',
            'open_files_limit' => '65535'
        ];
    }

    /**
     * Índices recomendados para la tabla estatus
     */
    public static function getEstatusIndexes()
    {
        return [
            // Índice principal para búsquedas por activo
            "CREATE INDEX idx_estatus_activo ON estatus(activo)",

            // Índice compuesto para búsquedas con filtros
            "CREATE INDEX idx_estatus_activo_estatus ON estatus(activo, estatus)",

            // Índice para búsquedas por texto
            "CREATE INDEX idx_estatus_texto ON estatus(estatus(50))",

            // Índice para ordenamiento
            "CREATE INDEX idx_estatus_id_orden ON estatus(id_estatus ASC)"
        ];
    }

    /**
     * Configuraciones de PDO para optimización
     */
    public static function getPDOOptions()
    {
        return [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_PERSISTENT => false, // Desactivar para grandes volúmenes
            PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => false, // Para streaming
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET SESSION sql_mode = 'STRICT_TRANS_TABLES,NO_ZERO_DATE,NO_ZERO_IN_DATE,ERROR_FOR_DIVISION_BY_ZERO'",
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];
    }

    /**
     * Configuraciones de memoria para PHP
     */
    public static function getPHPMemorySettings()
    {
        return [
            'memory_limit' => '512M',
            'max_execution_time' => '300',
            'max_input_time' => '300',
            'post_max_size' => '100M',
            'upload_max_filesize' => '100M',
            'max_input_vars' => '10000',
            'output_buffering' => 'Off',
            'implicit_flush' => 'On'
        ];
    }

    /**
     * Aplicar configuraciones de memoria PHP
     */
    public static function applyPHPSettings()
    {
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', '300');
        ini_set('max_input_time', '300');
        ini_set('output_buffering', 'Off');
        ini_set('implicit_flush', 'On');
    }

    /**
     * Configuraciones de caché recomendadas
     */
    public static function getCacheSettings()
    {
        return [
            'redis_enabled' => true,
            'redis_host' => 'localhost',
            'redis_port' => 6379,
            'redis_timeout' => 300,
            'apc_enabled' => true,
            'memcached_enabled' => true,
            'memcached_servers' => ['localhost:11211']
        ];
    }

    /**
     * Estrategias de particionamiento para tablas grandes
     */
    public static function getPartitioningStrategies()
    {
        return [
            'estatus' => [
                'type' => 'RANGE',
                'column' => 'id_estatus',
                'partitions' => [
                    'p0' => 'VALUES LESS THAN (100000)',
                    'p1' => 'VALUES LESS THAN (200000)',
                    'p2' => 'VALUES LESS THAN (300000)',
                    'p3' => 'VALUES LESS THAN (400000)',
                    'p4' => 'VALUES LESS THAN (500000)',
                    'p5' => 'VALUES LESS THAN (600000)',
                    'p6' => 'VALUES LESS THAN (700000)',
                    'p7' => 'VALUES LESS THAN (800000)',
                    'p8' => 'VALUES LESS THAN (900000)',
                    'p9' => 'VALUES LESS THAN MAXVALUE'
                ]
            ]
        ];
    }

    /**
     * Monitoreo de rendimiento
     */
    public static function getPerformanceMonitoring()
    {
        return [
            'slow_query_log' => true,
            'long_query_time' => 2.0,
            'log_queries_not_using_indexes' => true,
            'performance_schema' => true,
            'innodb_monitor_enable' => true
        ];
    }
}