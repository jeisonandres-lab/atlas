<?php

namespace App\Atlas\models;

use App\Atlas\config\Conexion;

class TotalDateModel extends Conexion
{
    private function totalDatospersonal()
    {
        $sql = $this->ejecutarConsulta(
            "SELECT count(id_empleados) AS totalEmpleados FROM datosempleados"
        );
        return $sql;
    }

    private function totalMedicamentos()
    {
        $sql = $this->ejecutarConsulta(
            "SELECT count(id_medicamentos) AS totalMedicamentos FROM medicamentos"
        );
        return $sql;
    }

    private function totalArchivos($parametro)
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

    private function atencionMedica($parametro)
    {
        $sql = $this->ejecutarConsulta(
            "SELECT count(id_histomedico) AS atencionMedica FROM historialmedico WHERE fecha = ?",
            $parametro
        );
        return $sql;
    }

    private function totalVacaciones()
    {
        $sql = $this->ejecutarConsulta(
            "SELECT count(id_vacaciones) AS totalVacaciones FROM vacaciones"
        );
        return $sql;
    }

    private function totalPermisos($parametro)
    {
        $sql = $this->ejecutarConsulta(
            "SELECT count(id_ausencia) AS totalPermisos FROM ausenciaJustificada WHERE fecha = ?",
            $parametro
        );
        return $sql;
    }

    private function porcentajeTotalArchivos()
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

    private function totalArchivosMes()
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

    private function totalArchivosDia()
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

    public function getTotalDatospersonal()
    {
        $sql = $this->totalDatospersonal();
        return $sql;
    }

    public function getTotalMedicamentos()
    {
        $sql = $this->totalMedicamentos();
        return $sql;
    }

    public function getTotalArchivos($parametro)
    {
        $sql = $this->totalArchivos($parametro);
        return $sql;
    }

    public function getTotalatencionMedica($parametro)
    {
        $sql = $this->atencionMedica($parametro);
        return $sql;
    }

    public function getTotalPermisos($parametro)
    {
        $sql = $this->totalPermisos($parametro);
        return $sql;
    }

    public function getPorcentajeTotalArchivos()
    {
        $sql = $this->porcentajeTotalArchivos();
        return $sql;
    }

    public function getTotalArchivosMes()
    {
        $sql = $this->totalArchivosMes();
        return $sql;
    }

    public function getTotalArchivosDia()
    {
        $sql = $this->totalArchivosDia();
        return $sql;
    }
}

//consulta por dia del mes
// SELECT
//     DATE_FORMAT(fecha, '%Y-%m-%d') AS dia,
//     SUM(size) AS total_kb,
//     CASE
//         WHEN SUM(size) < 1024 THEN CONCAT(SUM(size), ' KB')
//         WHEN SUM(size) < 1024 * 1024 THEN CONCAT(FORMAT(ROUND(SUM(size) / 1024, 2), 2), ' MB')
//         ELSE CONCAT(FORMAT(ROUND(SUM(size) / (1024 * 1024), 2), 2), ' GB')
//     END AS total_size
// FROM
//     documentacion
// GROUP BY
//     dia
// ORDER BY
//     dia