<?php

namespace App\Atlas\controller;

use App\Atlas\models\estatusModel;
use App\Atlas\models\tablasModel;

class estatusController extends estatusModel
{
    private $tablas;

    public function __construct()
    {
        parent::__construct();
        $this->tablas = new tablasModel();
    }

    public function datosEstatus()
    {
        $data_json['data'] = []; // Array de datos para enviar
        $tabla = 'estatus'; // Tabla a consultar
        $selectoresCantidad = 'COUNT(id_estatus) as cantidad'; // Selector para contar la cantidad de registros de la tabla
        $datosBuscar = ['estatus']; // Array de selectores para buscar en la tabla
        $campoOrden = 'id_estatus'; // Campo por el cual se ordenará la tabla
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
        $personal = $this->tablas->getTodoDatosPersonal($selectores, $tabla, $start, $length, $searchValue, $datosBuscar, $campoOrden, $conditions, $conditionParams, $ordenTabla = 'ASC');
        // Recorrer datos de la tabla

        foreach ($personal as $row) {
            $buttons = "
                <button class='btn btn-primary btn-sm btn-hover-azul btnEditarEstatus fw-semibold' data-bs-toggle='modal' data-bs-target='#modalEstatus' data-id='" . $row['id_estatus'] . "'><i class='fa-solid fa-pencil fa-sm me-2'></i>Editar</button>
               ";
            if ($row['activo'] == 0) {
                $buttons .= "
                <button class='btn btn-success btn-sm btn-hover-verde btnActivarEstatus fw-semibold' data-id='" . $row['id_estatus'] . "'><i class='fa-solid fa-check fa-sm me-2'></i>Activar</button>
                ";
            } else {
                $buttons .= "
                <button class='btn btn-danger btn-sm btn-hover-rojo btnEliminarEstatus fw-semibold' data-swal-toast-template='#my-template' data-id='" . $row['id_estatus'] . "'><i class='fa-solid fa-trash fa-sm me-2'></i>Eliminar</button>
                ";
            }
            $data_json['data'][] = [
                '0' => $row['estatus'],
                '1' => $row['activo'],
                '2' => $buttons,
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

    public function regisEstatus(string $nombreEstatus)
    {
        $nombreEstatus =  $this->limpiarCadena($nombreEstatus);
        $data_json = [
            'messenger' => '',
            'exito' => false
        ];

        $parametros = [
            [
                "campo_nombre" => "estatus",
                "campo_marcador" => ":estatus",
                "campo_valor" => $nombreEstatus
            ],
            [
                "campo_nombre" => "activo",
                "campo_marcador" => ":activo",
                "campo_valor" => 1
            ]
        ];

        $validar = $this->getValidarEstatus('estatus',  $nombreEstatus);
        if (empty($validar)) {
            $regisEstatus = $this->getRegistrarEstatus('estatus', $parametros);
            if ($regisEstatus) {
                $data_json['messenger'] = "Estatus registrado de manera exitosa";
                $data_json['exito'] = true;
            } else {
                $data_json['messenger'] = "Error al registrar el estatus";
            }
        } else {
            $data_json['messenger'] = "El estatus ya se encuentra registrado";
        }


        // Devolver la respuesta en formato JSON
        header('Content-Type: application/json');
        echo json_encode($data_json);
    }

    public function editarEstatus($id, $Estatus)
    {
        $data_json = [
            'messenger' => '',
            'exito' => false
        ];
        $parametros = [
            [
                "campo_nombre" => "estatus",
                "campo_marcador" => ":estatus",
                "campo_valor" => $Estatus
            ],

        ];

        $condicion = [
            "condicion_campo" => "id_estatus",
            "condicion_marcador" => ":id_estatus",
            "condicion_valor" => $id
        ];

        $validar = $this->getValidarEstatus('estatus',  $Estatus);
        if (empty($validar)) {
            $registro = $this->getActulizarEstatus('estatus', $parametros,  $condicion);
            if ($registro) {
                $data_json['messenger'] = "Estatus editado con éxito";
                $data_json['exito'] = true;
            } else {
                $data_json['messenger'] = "Error al editar el cargo";
            }
        } else {
            $data_json['messenger'] = "El estatus ya se encuentra registrado";
        }


        header('Content-Type: application/json');
        echo json_encode($data_json);
    }

    public function eliminarActivarEstatus(string $id, $activo)
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
            "condicion_campo" => "id_estatus",
            "condicion_marcador" => ":id_estatus",
            "condicion_valor" => $id
        ];

        $actualizar = $this->getActulizarEstatus('estatus', $parametros, $condicion);

        if ($actualizar) {
            $data_json['exito'] = true;
            if ($activador == 1) {
                $data_json['messenger'] = 'Estatus activado con exito';
            } else {
                $data_json['messenger'] = 'Estatus desactivado con exito';
            }
        }
        // Devolver la respuesta en formato JSON
        header('Content-Type: application/json');
        echo json_encode($data_json);
    }
}
