<?php

namespace App\Atlas\controller;

use App\Atlas\config\App;
use App\Atlas\models\dependenciasModel;
use App\Atlas\models\tablasModel;

date_default_timezone_set("America/Caracas");


class dependenciasController extends dependenciasModel
{


    private $tablas;
    private $app;

    public function __construct()
    {
        parent::__construct();
        $this->tablas = new tablasModel();
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
        $personal = $this->tablas->getTodoDatosPersonal($selectores, $tabla, $start, $length, $searchValue, $datosBuscar, $campoOrden, $conditions, $conditionParams, $orderTable = 'DESC');
        // Recorrer datos de la tabla

        foreach ($personal as $row) {
            $buttons = "
                <button class='btn btn-primary btn-sm btn-hover-azul btnEditarDependencia fw-semibold' data-bs-toggle='modal' data-bs-target='#modalDependencia' data-id='" . $row['id_dependencia'] . "'><i class='fa-solid fa-pencil fa-sm me-2'></i>Editar</button>
               ";
            if ($row['activo'] == 0) {
                $buttons .= "
                <button class='btn btn-success btn-sm btn-hover-verde btnActivarDependencia fw-semibold' data-id='" . $row['id_dependencia'] . "'><i class='fa-solid fa-check fa-sm me-2'></i>Activar</button>
                ";
            } else {
                $buttons .= "
                <button class='btn btn-danger btn-sm btn-hover-rojo btnEliminarDependencia fw-semibold' data-swal-toast-template='#my-template' data-id='" . $row['id_dependencia'] . "'><i class='fa-solid fa-trash fa-sm me-2'></i>Eliminar</button>
                ";
            }
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
        $estados = $this->tablas->getTodoDatosPersonal($selectores, $tabla, 0, 100, '', [], 'id_estado', $conditions, $conditionParams, $orderTable = 'ASC');

        $data_json['data'] = [];
        foreach ($estados as $row) {
            $data_json['data'][] = [
                'id' => $row['id_estado'],
                'value' => $row['estado']
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

        if (empty($codigodepe)) {
            $codigodepe = 'SIN-CDG';
        }


        $data_json = [
            'exito' => false,
            'messenger' => 'No se pudo obtener los datos de los estados',
        ];

        $parametros = [
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
            ],
            [
                "campo_nombre" => "activo",
                "campo_marcador" => ":activo",
                "campo_valor" => '1'
            ]

        ];
        $verificarCodigo = $this->getVerificarCodigo('dependencia', $codigodepe);
        if ($verificarCodigo) {
            $data_json['exito'] = false;
            $data_json['messenger'] = 'El codigo de la dependencia ya existe';
        } else {
            $registro = $this->getRegistrar2('dependencia', $parametros);
            if ($registro) {
                $data_json['exito'] = true;
                $data_json['messenger'] = 'Dependencia registrada con exito';
            }
        }

        // Devolver la respuesta en formato JSON
        header('Content-Type: application/json');
        echo json_encode($data_json);
    }

    public function dependencia(string $id)
    {
        $id = $this->limpiarCadena($id);

        $parametro = [$id];

        $datos_json = [
            'exito' => false,
            'messenger' => 'No se pudo obtener los datos de la dependencia',
        ];

        $datos = $this->getobtenerDependencia($parametro);
        foreach ($datos as $row) {
            if ($datos) {
                $datos_json['exito'] = true;
                $datos_json['messenger'] = 'Datos de la dependencia obtenidos con exito';
                $datos_json['dependencia'] = $row['dependencia'];
                $datos_json['codigo'] = $row['codigo'];
                $datos_json['idestado'] = $row['idEstado'];
                $datos_json['estado'] = $row['estado'];
                $datos_json['id_dependencia'] = $row['id_dependencia'];
                $datos_json['activo'] = $row['activo'];
            }
        }

        // Devolver la respuesta en formato JSON
        header('Content-Type: application/json');
        echo json_encode($datos_json);
    }

    public function editarDependencia(string $id, string $nombredepen, string $codigodepen, string $estadodepen)
    {
        $data_json = [
            'exito' => false,
            'messenger' => 'No se pudo obtener los datos de la dependencia',
        ];

        $id = $this->limpiarCadena($id);
        $nombredepen = $this->limpiarCadena($nombredepen);
        $codigodepen = $this->limpiarCadena($codigodepen);
        $estadodepen = $this->limpiarCadena($estadodepen);

        $parametros = [
            [
                "campo_nombre" => "dependencia",
                "campo_marcador" => ":dependencia",
                "campo_valor" => $nombredepen
            ],
            [
                "campo_nombre" => "codigo",
                "campo_marcador" => ":codigo",
                "campo_valor" => $codigodepen
            ],
            [
                "campo_nombre" => "idEstado",
                "campo_marcador" => ":idEstado",
                "campo_valor" => $estadodepen
            ]
        ];

        $condicion = [
            "condicion_campo" => "id_dependencia",
            "condicion_marcador" => ":id_dependencia",
            "condicion_valor" => $id
        ];

        $actualizar = $this->getActulizarDependencia('dependencia', $parametros, $condicion);

        if ($actualizar) {
            $data_json['exito'] = true;
            $data_json['messenger'] = 'Dependencia actualizada con exito';
        }
        // Devolver la respuesta en formato JSON
        header('Content-Type: application/json');
        echo json_encode($data_json);
    }

    public function eliminarActivarDependencia(string $id, $activo)
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
            "condicion_campo" => "id_dependencia",
            "condicion_marcador" => ":id_dependencia",
            "condicion_valor" => $id
        ];

        $actualizar = $this->getActulizarDependencia('dependencia', $parametros, $condicion);

        if ($actualizar) {
            $data_json['exito'] = true;
            if ($activador == 1) {
                $data_json['messenger'] = 'Dependencia activada con exito';
            } else {
                $data_json['messenger'] = 'Dependencia desactivada con exito';
            }
        }
        // Devolver la respuesta en formato JSON
        header('Content-Type: application/json');
        echo json_encode($data_json);
    }
}
