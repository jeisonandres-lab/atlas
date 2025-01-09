<?php

namespace App\Atlas\models;

use App\Atlas\config\Conexion;

class tablasModel extends conexion
{

    private function obtenertodosDatos(
        string $selectores,
        string $tabla,
        $start, $length,
        $searchValue,
        array $datosBuscar,
        string $campoOrden)
    {
        $sql = "SELECT $selectores FROM $tabla";

        // Construir la cláusula WHERE para la búsqueda
        $parametros = [];
        if (!empty($searchValue)) {
            $sql .= " WHERE ";
            $conditions = [];
            foreach ($datosBuscar as $campo) {
                $conditions[] = "$campo LIKE ?";
                $parametros[] = '%' . $searchValue . '%';
            }
            $sql .= implode(" OR ", $conditions);
        }

        // Añadir la cláusula ORDER BY y LIMIT para la paginación
        $sql .= " ORDER BY $campoOrden ASC LIMIT ?, ?";
        $parametros[] = (int) $start;
        $parametros[] = (int) $length;

        // Ejecutar la consulta utilizando la función ejecutarConsulta
        return $this->ejecutarConsulta($sql, $parametros);
    }


    private function cantidadRegistros($tabla, $parametros)
    {
        $sql = $this->ejecutarConsulta("SELECT $parametros FROM $tabla");
        return $sql;
    }

    public function getTodoDatosPersonal($selectores, $tabla, $start, $length, $searchValue, $datosBuscar, $campoOrden)
    {
        return $this->obtenertodosDatos($selectores, $tabla, $start, $length, $searchValue, $datosBuscar, $campoOrden);
    }

    public function getCantidadRegistros($tabla, $parametros)
    {
        return $this->cantidadRegistros($tabla, $parametros);
    }
}
