<?php

namespace App\Atlas\controller\unidadOrganizacional;

use App\Atlas\models\public\EstatusModelPublic;
use App\Atlas\models\private\TablasModel;
use App\Atlas\controller\auditoria\AuditoriaController;
use App\Atlas\config\App;
use App\Atlas\config\EjecutarSQL;

class EstatusController
{
    private $tablas;
    private $auditoriaController;
    private $app;
    private $estatusModelPublic;

    private $idUsuario;
    private $nombreUsuario;
    private $consultas;
    
    public function __construct()
    {

        $this->tablas = new TablasModel();
        $this->app = new App();
        $this->auditoriaController = new AuditoriaController();
        $this->consultas = new EjecutarSQL();
        $this->estatusModelPublic = new EstatusModelPublic();
        $this->app->iniciarSession();
        $this->idUsuario = $_SESSION['id'];
        $this->nombreUsuario = $_SESSION['usuario'];
    }

    // Datos para las tablas
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
        $personal = $this->tablas->getTodoDatosPersonal($selectores, $tabla, $start, $length, $searchValue, $datosBuscar, $campoOrden, $conditions, $conditionParams, $ordenTabla = 'DESC');
        // Recorrer datos de la tabla

        foreach ($personal as $row) {
            $buttons = "
                <button class='btn btn-primary btn-sm btn-hover-azul btnEditarEstatus' data-bs-toggle='modal' data-bs-target='#modalEstatus' data-id='" . $row['id_estatus'] . "'><i class='fa-solid fa-pencil fa-sm me-2'></i>Editar</button>
               ";
            if ($row['activo'] == 0) {
                $buttons .= "
                <button class='btn btn-success btn-sm btn-hover-verde btnActivarEstatus' data-id='" . $row['id_estatus'] . "'><i class='fa-solid fa-check fa-sm me-2'></i>Activar</button>
                ";
            } else {
                $buttons .= "
                <button class='btn btn-danger btn-sm btn-hover-rojo btnEliminarEstatus' data-swal-toast-template='#my-template' data-id='" . $row['id_estatus'] . "'><i class='fa-solid fa-trash fa-sm me-2'></i>Eliminar</button>
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

    //Obtener los estatus
    public function obtenerEstatusGeneral(){
        $datosGeneralEstatus = $this->estatusModelPublic->getDatosEstatus($parametros = ['1']);

        $data_json = [
            "exito" => !empty($datosGeneralEstatus),
            "mensaje" => empty($datosGeneralEstatus) ? "No se lograron obtener los estatus" : "",
            "data" => []
        ];

        if ($data_json["exito"]) {
            foreach ($datosGeneralEstatus as $row) {
                $data_json["data"][] = [
                    'id' => $row['id_estatus'],
                    'value' => $row['estatus']
                ];
            }
        }

        echo json_encode($data_json);
    }

    // Registrar estatus
    public function regisEstatus(string $nombreEstatus)
    {
        $nombreEstatus =  $this->consultas->limpiarCadena($nombreEstatus);
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

        $validar = $this->estatusModelPublic->getValidarEstatus('estatus',  $nombreEstatus);
        if (empty($validar)) {
            $regisEstatus = $this->estatusModelPublic->getRegistrarEstatus('estatus', $parametros);
            if ($regisEstatus) {
                $registroAuditoria = $this->auditoriaController->registrarAuditoria($this->idUsuario, 'Registrar estatus', 'El usuario ' . $this->nombreUsuario . ' ha registrado el ' . $nombreEstatus . ' en el sistema.');
                if ($registroAuditoria) {
                    $data_json["exitoAuditoria"] = true;
                    $data_json['messengerAuditoria'] = "Auditoria registrada con exito.";
                } else {
                    $data_json["exitoAuditoria"] = false;
                    $data_json['messengerAuditoria'] = "Error al registrar la auditoria.";
                }
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

    // Editar estatus
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

        $buscarEstatus = $this->estatusModelPublic->getDatosEstatusID([$id]);
        if (empty($buscarEstatus)) {
            $data_json['exito'] = false;
            $data_json['messenger'] = 'No se pudo obtener los datos del estatus';
        } else {
            foreach ($buscarEstatus as $row) {
                $estatus = $row['estatus'];
                $validar = $this->estatusModelPublic->getValidarEstatus('estatus',  $Estatus);
                if (empty($validar)) {
                    $actualizar = $this->estatusModelPublic->getActulizarEstatus('estatus', $parametros, $condicion);
                    if ($actualizar) {
                        $data_json['exito'] = true;

                        $registroAuditoria = $this->auditoriaController->registrarAuditoria($this->idUsuario, 'Editar estatus', 'El usuario ' . $this->nombreUsuario . ' ha editado el estatus ' . $estatus . ' por ' . $Estatus . ' en el sistema.');
                        if ($registroAuditoria) {
                            $data_json["exitoAuditoria"] = true;
                            $data_json['messengerAuditoria'] = "Auditoria registrada con exito.";
                        } else {
                            $data_json["exitoAuditoria"] = false;
                            $data_json['messengerAuditoria'] = "Error al registrar la auditoria.";
                        }

                        $data_json['messenger'] = 'Estatus editado con exito';
                    } else {
                        $data_json['exito'] = false;
                        $data_json['messenger'] = 'Error al actualizar el estatus';
                    }
                } else {
                    $data_json['messenger'] = "El estatus ya se encuentra registrado";
                }
            }
        }

        header('Content-Type: application/json');
        echo json_encode($data_json);
    }

    // Eliminar estatus
    public function eliminarActivarEstatus(string $id, $activo)
    {
        $data_json = [
            'exito' => false,
            'messenger' => 'No se pudo obtener los datos de la dependencia',
        ];

        $id = $this->consultas->limpiarCadena($id);
        $activador = $activo;
        $estadoEli = ($activador == 1) ? "activado" : "desactivado";
        $estadoEli2 = ($activador == 1) ? "Activación" : "Desactivación";

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

        $buscarEstatus = $this->estatusModelPublic->getDatosEstatusID([$id]);
        if (empty($buscarEstatus)) {
            $data_json['exito'] = false;
            $data_json['messenger'] = 'No se pudo obtener los datos del estatus';
        } else {
            foreach ($buscarEstatus as $row) {
                $estatus = $row['estatus'];
                $actualizar = $this->estatusModelPublic->getActulizarEstatus('estatus', $parametros, $condicion);
                if ($actualizar) {
                    $data_json['exito'] = true;

                    $registroAuditoria = $this->auditoriaController->registrarAuditoria($this->idUsuario, $estadoEli2 . ' estatus', 'El usuario ' . $this->nombreUsuario . ' ha ' . $estadoEli . ' el estatus ' . $estatus . ' en el sistema.');
                    if ($registroAuditoria) {
                        $data_json["exitoAuditoria"] = true;
                        $data_json['messengerAuditoria'] = "Auditoria registrada con exito.";
                    } else {
                        $data_json["exitoAuditoria"] = false;
                        $data_json['messengerAuditoria'] = "Error al registrar la auditoria.";
                    }

                    if ($activador == 1) {
                        $data_json['messenger'] = 'Estatus activado con exito';
                    } else {
                        $data_json['messenger'] = 'Estatus desactivado con exito';
                    }
                } else {
                    $data_json['exito'] = false;
                    $data_json['messenger'] = 'Error al actualizar el estatus';
                }
            }
        }

        // Devolver la respuesta en formato JSON
        header('Content-Type: application/json');
        echo json_encode($data_json);
    }
}
