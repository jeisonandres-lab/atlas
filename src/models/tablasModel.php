<?php

namespace App\Atlas\models;

use App\Atlas\config\Conexion;

class tablasModel extends conexion
{

    private function obtenertodosDatos(
        string $selectores,
        string $tabla,
        $start,
        $length,
        $searchValue,
        array $datosBuscar,
        string $campoOrden,
        array $conditions = null,
        array $conditionParams = []
    ) {
        $sql = "SELECT $selectores FROM $tabla";

        // Construir la cláusula WHERE para la búsqueda
        $parametros = [];
        $whereClauses = [];

        // Añadir la cláusula de búsqueda si $searchValue no está vacío
        if (!empty($searchValue)) {
            $searchClauses = [];
            foreach ($datosBuscar as $campo) {
                $searchClauses[] = "$campo LIKE ?";
                $parametros[] = '%' . $searchValue . '%';
            }
            $whereClauses[] = "(" . implode(" OR ", $searchClauses) . ")";
        }

        // Añadir condiciones adicionales si existen
        if (!empty($conditions)) {
            foreach ($conditions as $condition) {
                $whereClauses[] = $condition;
            }
            $parametros = array_merge($parametros, $conditionParams);
        }

        // Construir la cláusula WHERE final
        if (!empty($whereClauses)) {
            $sql .= " WHERE " . implode(" AND ", $whereClauses);
        }

        // Añadir la cláusula ORDER BY y LIMIT para la paginación
        $sql .= " ORDER BY $campoOrden ASC LIMIT ?, ?";
        $parametros[] = (int) $start;
        $parametros[] = (int) $length;

        // Ejecutar la consulta utilizando la función ejecutarConsulta
        return $this->ejecutarConsulta($sql, $parametros);
    }

    public function tablas(
        string $selectores,
        string $tabla,
        string $campoOrden,
        array $conditions = null,
        array $conditionParams = []
    ) {
        $sql = "SELECT $selectores FROM $tabla";

        // Construir la cláusula WHERE para la búsqueda
        $parametros = [];
        $whereClauses = [];

        // Añadir condiciones adicionales si existen
        if (!empty($conditions)) {
            foreach ($conditions as $condition) {
                $whereClauses[] = $condition;
            }
            $parametros = array_merge($parametros, $conditionParams);
        }

        // Construir la cláusula WHERE final
        if (!empty($whereClauses)) {
            $sql .= " WHERE " . implode(" AND ", $whereClauses);
        }

        // Añadir la cláusula ORDER BY
        $sql .= " ORDER BY $campoOrden ASC";

        // Ejecutar la consulta utilizando la función ejecutarConsulta
        return $this->ejecutarConsulta($sql, $parametros);
    }

    private function cantidadRegistros($tabla, $parametros, $conditions = null, $conditionParams = [])
    {
        $sql = "SELECT $parametros FROM $tabla";

        // Construir la cláusula WHERE si hay condiciones
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        // Ejecutar la consulta utilizando la función ejecutarConsulta
        return $this->ejecutarConsulta($sql, $conditionParams);
    }

    public function getTodoDatosPersonal($selectores, $tabla, $start, $length, $searchValue, $datosBuscar, $campoOrden, $conditions, $conditionParams)
    {
        return $this->obtenertodosDatos($selectores, $tabla, $start, $length, $searchValue, $datosBuscar, $campoOrden, $conditions, $conditionParams);
    }

    public function getCantidadRegistros($tabla, $parametros, $conditions, $conditionParams)
    {
        return $this->cantidadRegistros($tabla, $parametros, $conditions, $conditionParams);
    }
}
