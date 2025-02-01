<?php

namespace App\Atlas\controller;

use App\Atlas\models\dependenciasModel;
use App\Atlas\models\tablasModel;

class dependenciasController
{

    private $dependencia;
    private $tablas;
    public function __construct()
    {
        $this->tablas = new tablasModel();
        $this->dependencia = new dependenciasModel();
    }

    public function datosDependencia()
    {
        $data_json['data'] = []; // Array de datos para enviar
        $tabla = 'dependencia depe INNER JOIN estados esta ON depe.idEstado = id_estado'; // Tabla a consultar
        $selectoresCantidad = 'COUNT(id_dependencia) as cantidad'; // Selector para contar la cantidad de registros de la tabla
        $datosBuscar = ['depe.dependencia','depe.codigo', 'esta.estado']; // Array de selectores para buscar en la tabla
        $campoOrden = 'id_dependencia'; // Campo por el cual se ordenará la tabla
        $selectores = '*'; // Selectores para obtener los datos de la tabla
        $conditions = []; // Condiciones para obtener los datos de la tabla
        $conditionParams = []; // Parámetros de las condiciones

        $draw = $_REQUEST['draw'];
        $start = $_REQUEST['start'];
        $length = $_REQUEST['length'];
        $searchValue = $_REQUEST['search']['value'];

        // Obtener la cantidad de los datos de la tabla
        $cantidadRegistro = $this->tablas->getCantidadRegistros($tabla, $selectoresCantidad, $conditions, $conditionParams);
        // Obtener los datos de la tabla
        $personal = $this->tablas->getTodoDatosPersonal($selectores, $tabla, $start, $length, $searchValue, $datosBuscar, $campoOrden, $conditions, $conditionParams);
        // Recorrer datos de la tabla

        foreach ($personal as $row) {
            $buttons =  "
            <button class='btn btn-primary btn-sm btn-hover-azul btnEditarDependencia fw-semibold' data-bs-toggle='modal' data-bs-target='#editarDatosFamiliar' data-cedula=" . $row['id_dependencia'] . "><i class='fa-solid fa-pencil fa-sm me-2'></i>Editar</button>
            <button class='btn btn-danger btn-sm btn-hover-rojo btnEliminar'  data-swal-toast-template='#my-template' data-id=" . $row['id_dependencia'] .  "><i class='fa-solid fa-trash fa-sm me-2'></i>Eliminar</button>
            ";
            $data_json['data'][] = [
                '0' => $row['dependencia'],
                '1' => $row['activo'],
                '2' => $row['estado'],
                '3' => $row['codigo'],
                '4' => $buttons,
            ];
            $data_json['mensaje'] = "todas las dependencias de manera exitosa";
        }

        // Devolver la respuesta a DataTables
        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $cantidadRegistro[0]['cantidad'],
            "recordsFiltered" => $cantidadRegistro[0]['cantidad'],
            "data" => $data_json['data']
        );
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
