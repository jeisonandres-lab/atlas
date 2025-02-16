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
        $personal = $this->tablas->getTodoDatosPersonal($selectores, $tabla, $start, $length, $searchValue, $datosBuscar, $campoOrden, $conditions, $conditionParams, $ordenTable = 'DESC');
        // Recorrer datos de la tabla

        foreach ($personal as $row) {
            $buttons = "
                <button class='btn btn-primary btn-sm btn-hover-azul btnEditarCargo fw-semibold' data-bs-toggle='modal' data-bs-target='#modalCargo' data-id=" . $row['id_cargo'] . "><i class='fa-solid fa-pencil fa-sm me-2'></i>Editar</button>
               ";
            if ($row['activo'] == 0) {
                $buttons .= "
                <button class='btn btn-success btn-sm btn-hover-verde btnActivarCargo fw-semibold' data-id='" . $row['id_cargo'] . "'><i class='fa-solid fa-check fa-sm me-2'></i>Activar</button>
                ";
            } else {
                $buttons .= "
                <button class='btn btn-danger btn-sm btn-hover-rojo btnEliminarCargo fw-semibold' data-swal-toast-template='#my-template' data-id=" . $row['id_cargo'] .  "><i class='fa-solid fa-trash fa-sm me-2'></i>Eliminar</button>
                ";
            }
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

        $validar = $this->getVerificarCargo('cargo', $nombreCargo);
        if (empty($validar)) {
            $registro = $this->getRegistrarCargo('cargo', $parametros);
            if ($registro) {
                $data_json['messenger'] = "Cargo registrado con éxito";
                $data_json['exito'] = true;
            } else {
                $data_json['messenger'] = "Error al registrar el cargo";
            }
        } else {
            $data_json['messenger'] = "El cargo ya existe";
        }
        header('Content-Type: application/json');
        echo json_encode($data_json);
    }

    public function editarCargo($id, $cargo)
    {
        $data_json = [
            'messenger' => '',
            'exito' => false
        ];
        $parametros = [
            [
                "campo_nombre" => "cargo",
                "campo_marcador" => ":cargo",
                "campo_valor" => $cargo
            ],

        ];

        $condicion = [
            "condicion_campo" => "id_cargo",
            "condicion_marcador" => ":id_cargo",
            "condicion_valor" => $id
        ];

        $validar = $this->getVerificarCargo('cargo', $cargo);
        if (empty($validar)) {
            $registro = $this->getActulizarCargo('cargo', $parametros,  $condicion);
            if ($registro) {
                $data_json['messenger'] = "Cargo editado con éxito";
                $data_json['exito'] = true;
            } else {
                $data_json['messenger'] = "Error al editar el cargo";
            }
        } else {
            $data_json['messenger'] = "El cargo ya existe";
        }


        header('Content-Type: application/json');
        echo json_encode($data_json);
    }

    public function eliminarActivarCargo(string $id, $activo)
    {
        $data_json = [
            'exito' => false,
            'messenger' => 'No se pudo obtener los datos de la dependencia',
        ];

        $id = $this->limpiarCadena($id);
        $activador = $activo;

        $parametros = [
            [
                "campo_nombre" => "activo",
                "campo_marcador" => ":activo",
                "campo_valor" =>  $activador
            ]
        ];

        $condicion = [
            "condicion_campo" => "id_cargo",
            "condicion_marcador" => ":id_cargo",
            "condicion_valor" => $id
        ];

        $actualizar = $this->getActulizarCargo('cargo', $parametros, $condicion);

        if ($actualizar) {
            $data_json['exito'] = true;
            if ($activador == 1) {
                $data_json['messenger'] = 'Cargo activado con exito';
            } else {
                $data_json['messenger'] = 'Cargo desactivado con exito';
            }
        }
        // Devolver la respuesta en formato JSON
        header('Content-Type: application/json');
        echo json_encode($data_json);
    }
}
