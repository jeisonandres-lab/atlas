<?php

namespace App\Atlas\models\private;

use App\Atlas\config\EjecutarSQL;

class TotalEstadisticaModel extends EjecutarSQL
{
    public function __construct()
    {
        parent::__construct();
    }

    // CONSULTA SQL QUE REGRESA LA CANTIDAD DE EMPLEADOS REGISTRADOS
    protected function totalEmpleados(): array
    {
        $sql = $this->ejecutarConsulta(
            "SELECT count(id_empleados) AS totalEmpleados FROM datosempleados"
        );
        return $sql;
    }

    // CONSULTA SQL QUE REGRESA LA CANTIDAD DE ARCHIVOS REGISTRADOS
    // SI SE PASA UN PARAMETRO DE FECHA REGRESA LA CANTIDAD DE ARCHIVOS REGISTRADOS EN ESA FECHA
    protected function totalArchivos($parametro): array
    {

        if ($parametro == null) {
            $sql = $this->ejecutarConsulta(
                "SELECT count(id_doc) AS totalArchivos FROM documentacion"
            );
        } else {
            $sql = $this->ejecutarConsulta(
                "SELECT count(id_doc) AS totalArchivos FROM documentacion WHERE fecha = ?",
                $parametro
            );
        }


        return $sql;
    }

    // CONSULTA SQL QUE REGRESA LA CANTIDAD DE VACACIONES REGISTRADAS
    protected function totalVacaciones(): array
    {
        $sql = $this->ejecutarConsulta(
            "SELECT count(id_vacaciones) AS totalVacaciones FROM vacaciones"
        );
        return $sql;
    }

    // CONSULTA SQL QUE REGRESA LA CANTIDAD DE PERMISOS REGISTRADOS
    protected function totalPermisos($parametro): array
    {
        $sql = $this->ejecutarConsulta(
            "SELECT count(id_ausencia) AS totalPermisos FROM ausenciaJustificada WHERE fecha = ?",
            $parametro
        );
        return $sql;
    }

    // CONSULTA SQL QUE REGRESA EL PORCENTAJE DE ARCHIVOS SUBIDOS
    protected function porcentajeTotalArchivos(): array
    {
        $sql = $this->ejecutarConsulta(
            "SELECT
            FORMAT((COUNT(CASE WHEN fecha BETWEEN '2025-01-10' AND '2025-01-18' THEN id_doc END) * 100.0) / COUNT(id_doc), 1, 'es_ES')
            AS porcentaje_documentos_subidos
            FROM
            documentacion"
        );
        return $sql;
    }

    // CONSULTA SQL QUE REGRESA LA CANTIDAD DE ARCHIVOS REGISTRADOS POR MES
    public function totalArchivosMes(): array
    {
        $sql = $this->ejecutarConsulta("SELECT
        DATE_FORMAT(fecha, '%Y-%m') AS mes,
        SUM(size) AS total_kb,
        CASE
            WHEN SUM(size) < 1024 THEN CONCAT(SUM(size), ' KB')
            WHEN SUM(size) < 1024 * 1024 THEN CONCAT(FORMAT(ROUND(SUM(size) / 1024, 2), 2), ' MB')
            ELSE CONCAT(FORMAT(ROUND(SUM(size) / (1024 * 1024), 2), 2), ' GB')
        END AS total_size
        FROM
            documentacion
        GROUP BY
            mes
        ORDER BY
            mes
            ");
        return $sql;
    }

    // CONSULTA SQL QUE REGRESA LA CANTIDAD DE ARCHIVOS REGISTRADOS POR DIA
    protected function totalArchivosDia(): array
    {
        $sql = $this->ejecutarConsulta("SELECT
        DATE_FORMAT(fecha, '%Y-%m-%d') AS dia,
        SUM(size) AS total_kb,
        CASE
            WHEN SUM(size) < 1024 THEN CONCAT(SUM(size), ' KB')
            WHEN SUM(size) < 1024 * 1024 THEN CONCAT(FORMAT(ROUND(SUM(size) / 1024, 2), 2), ' MB')
            ELSE CONCAT(FORMAT(ROUND(SUM(size) / (1024 * 1024), 2), 2), ' GB')
        END AS total_size
        FROM
            documentacion
        GROUP BY
            dia
        ORDER BY
            dia
        ");
        return $sql;
    }
}
