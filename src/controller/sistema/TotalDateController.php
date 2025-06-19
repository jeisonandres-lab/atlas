<?php

namespace App\Atlas\controller;

use App\Atlas\models\TotalDateModel;

date_default_timezone_set("America/Caracas");




class TotalDateController extends TotalDateModel
{
    public function totalDatosCard()
    {
        $fechaActual = date("Y-m-d");
        $parametro = [$fechaActual];
        $parametro2 = null;
        $data_json = [
            'exito' => false,
            'messenger' => 'Error al obtener los datos'
        ];

        $sql = $this->getTotalDatospersonal();
        $sql2 = $this->getTotalMedicamentos();
        $sql3 = $this->getTotalArchivos($parametro2);
        $sql4 = $this->getTotalatencionMedica($parametro);
        $sql5 = $this->getTotalPermisos($parametro);
        $sql6 = $this->getPorcentajeTotalArchivos();
        $data_json['exito'] = true;
        $data_json['messenger'] = 'Datos obtenidos correctamente';
        $data_json['empleado'] =  $sql;
        $data_json['medicamentos'] =  $sql2;
        $data_json['archivos'] =  $sql3;
        $data_json['atencionMedica'] =  $sql4;
        $data_json['ausencia'] =  $sql5;
        $data_json['porcentajeArchivos'] =  $sql6;


        header('Content-Type: application/json');
        echo json_encode($data_json);
    }

    public function totalArchivosMes()
    {
        $data_json = [
            'exito' => false,
            'messenger' => 'Error al obtener los datos'
        ];

        $sql2 = $this->getTotalArchivosMes();
        $labels = [];
        $values = [];

        // Verificar si $sql2 es iterable antes de usar foreach
        if (is_iterable($sql2)) {
            foreach ($sql2 as $row) {
                $labels[] = $row['total_kb']; // Ajusta 'label' según el nombre de la columna en tu base de datos
                $values[] = $row['mes']; // Ajusta 'value' según el nombre de la columna en tu base de datos

                // $values[] = $row['dia']; //
            }

            if (!empty($labels) && !empty($values)) {
                $data_json = [
                    'exito' => true,
                    'labels' => $labels,
                    'values' => $values,
                    'original_labels' => array_column($sql2, 'total_size') // Mantén las etiquetas originales con unidades
                ];
            }
        } else {
            // Manejar el caso en que $sql2 no es iterable. Esto es importante para depurar.
            $data_json['messenger'] = 'Error: Resultado de la consulta no es iterable.';
            // Loguea el error para poder revisarlo después.
            error_log("Error en totalArchivosMes: Resultado de la consulta no es iterable. Valor de \$sql2: " . var_export($sql2, true));
        }

        header('Content-Type: application/json');
        echo json_encode($data_json);
    }

    public function totalArchivosDia()
    {
        $data_json = [
            'exito' => false,
            'messenger' => 'Error al obtener los datos'
        ];

        
        $sql2 = $this->getTotalArchivosDia();
        $labels = [];
        $values = [];

        // Verificar si $sql2 es iterable antes de usar foreach
        if (is_iterable($sql2)) {
            foreach ($sql2 as $row) {
                $labels[] = $row['total_kb']; // Ajusta 'label' según el nombre de la columna en tu base de datos
                $values[] = $row['dia']; // Ajusta 'value' según el nombre de la columna en tu base de datos

                // $values[] = $row['dia']; //
            }

            if (!empty($labels) && !empty($values)) {
                $data_json = [
                    'exito' => true,
                    'labels' => $labels,
                    'values' => $values,
                    'original_labels' => array_column($sql2, 'total_size') // Mantén las etiquetas originales con unidades
                ];
            }
        } else {
            // Manejar el caso en que $sql2 no es iterable. Esto es importante para depurar.
            $data_json['messenger'] = 'Error: Resultado de la consulta no es iterable.';
            // Loguea el error para poder revisarlo después.
            error_log("Error en totalArchivosMes: Resultado de la consulta no es iterable. Valor de \$sql2: " . var_export($sql2, true));
        }

        header('Content-Type: application/json');
        echo json_encode($data_json);
    }
}
