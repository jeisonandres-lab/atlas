<?php

namespace App\Atlas\controller;

use App\Atlas\config\App;
use App\Atlas\models\dependenciasModel;
use App\Atlas\models\tablasModel;

date_default_timezone_set("America/Caracas");


class dependenciasController extends dependenciasModel
{

    private $dependencia;
    private $tablas;
    private $app;

    public function __construct()
    {
        $this->tablas = new tablasModel();
        $this->dependencia = new dependenciasModel();
        $this->app = new App();
    }

    public function datosDependencia()
    {
        $data_json['data'] = []; // Array de datos para enviar
        $tabla = 'dependencia depe INNER JOIN estados esta ON depe.idEstado = id_estado'; // Tabla a consultar
        $selectoresCantidad = 'COUNT(id_dependencia) as cantidad'; // Selector para contar la cantidad de registros de la tabla
        $datosBuscar = ['depe.dependencia', 'depe.codigo', 'esta.estado']; // Array de selectores para buscar en la tabla
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

    public function datosEstado()
    {
        $tabla = 'estados';
        $selectores = '*';
        $conditions = [];
        $conditionParams = [];

        // Obtener los datos de la tabla estados
        $estados = $this->tablas->getTodoDatosPersonal($selectores, $tabla, 0, 100, '', [], 'id_estado', $conditions, $conditionParams);

        $data_json['data'] = [];
        foreach ($estados as $row) {
            $data_json['data'][] = [
                'id_estado' => $row['id_estado'],
                'estado' => $row['estado']
            ];
        }

        // Devolver la respuesta en formato JSON
        header('Content-Type: application/json');
        echo json_encode($data_json);
    }

    public function regisDependencia(string $dependencia, string $codigodepe, string $estado)
    {
        $dependencia = $this->limpiarCadena($dependencia);
        $codigodepe = $this->limpiarCadena($codigodepe);
        $estado = $this->limpiarCadena($estado);

        $datos_json = [
            'exito' => false,
            'messenger' => 'No se pudo obtener los datos de los estados',
        ];

        $datos = [
            [
                "campo_nombre" => "dependencia",
                "campo_marcador" => ":dependencia",
                "campo_valor" => $dependencia
            ],
            [
                "campo_nombre" => "codigo",
                "campo_marcador" => ":codigo",
                "campo_valor" => $codigodepe
            ],
            [
                "campo_nombre" => "idEstado",
                "campo_marcador" => ":idEstado",
                "campo_valor" => $estado
            ]
        ];
        $registro = $this->getRegistrarDependencia('dependencia', $datos);
        if ($registro) {
            $datos_json['exito'] = true;
            $datos_json['messenger'] = 'Dependencia registrada con exito';
        }
    }
}
