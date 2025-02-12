<?php

namespace App\Atlas\controller;

use App\Atlas\models\cargoModel;
use App\Atlas\models\tablasModel;

class cargoController extends cargoModel
{
    private $tablas;

    public function __construct()
    {
        parent::__construct();
        $this->tablas = new tablasModel();
    }

    public function datosCargo()
    {
        $data_json['data'] = []; // Array de datos para enviar
        $tabla = 'cargo'; // Tabla a consultar
        $selectoresCantidad = 'COUNT(id_cargo) as cantidad'; // Selector para contar la cantidad de registros de la tabla
        $datosBuscar = ['cargo']; // Array de selectores para buscar en la tabla
        $campoOrden = 'id_cargo'; // Campo por el cual se ordenará la tabla
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
            <button class='btn btn-primary btn-sm btn-hover-azul btnEditarCargo fw-semibold' data-bs-toggle='modal' data-bs-target='#editarDatosFamiliar' data-cedula=" . $row['id_cargo'] . "><i class='fa-solid fa-pencil fa-sm me-2'></i>Editar</button>
            <button class='btn btn-danger btn-sm btn-hover-rojo btnEliminar'  data-swal-toast-template='#my-template' data-id=" . $row['id_cargo'] .  "><i class='fa-solid fa-trash fa-sm me-2'></i>Eliminar</button>
            ";
            $data_json['data'][] = [
                '0' => $row['cargo'],
                '1' => $row['activo'],
                '2' => $buttons,
            ];
            $data_json['mensaje'] = "todas las cargos de manera exitosa";
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

    public function regisCargo(string $nombreCargo)
    {
        $nombreCargo = $this->limpiarCadena($nombreCargo);
        $data_json = [
            'messenger' => '',
            'exito' => false
        ];
        $parametros = [
            [
                "campo_nombre" => "cargo",
                "campo_marcador" => ":cargo",
                "campo_valor" => $nombreCargo
            ],
            [
                "campo_nombre" => "activo",
                "campo_marcador" => ":activo",
                "campo_valor" => "1"
            ]
        ];
        $registro = $this->getRegistrarCargo('cargo', $parametros);
        if ($registro) {
            $data_json['messenger'] = "Cargo registrado con éxito";
            $data_json['exito'] = true;
        } else {
            $data_json['messenger'] = "Error al registrar el cargo";
        }

        header('Content-Type: application/json');
        echo json_encode($data_json);
    }
}
