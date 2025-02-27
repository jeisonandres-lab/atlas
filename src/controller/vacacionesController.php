<?php

namespace App\Atlas\controller;

use App\Atlas\config\Conexion;
use App\Atlas\models\tablasModel;
use App\Atlas\models\vacacionesModel;
use App\Atlas\controller\AuditoriaController;
use App\Atlas\models\personalModel;
use App\Atlas\config\App;

date_default_timezone_set("America/Caracas");


class vacacionesController extends vacacionesModel
{

    private $tablas;

    private $app;
    private $auditoriaController;
    private $idUsuario;
    private $nombreUsuario;
    private $personalModel;

    public function __construct()
    {
        parent::__construct();
        $this->tablas = new tablasModel();
        $this->auditoriaController = new AuditoriaController();
        $this->app = new App();
        $this->personalModel = new personalModel();
        $this->auditoriaController = new auditoriaController();
        $this->app->iniciarSession();
        $this->idUsuario = $_SESSION['id'];
        $this->nombreUsuario = $_SESSION['usuario'];
    }

    public function registrarAusencia(string $cedula, string $id, $fecha_ini, $fecha_fin, $primerNombre, $primerApellido, $permiso)
    {
        $cedula = $this->limpiarCadena($cedula);
        $id = $this->limpiarCadena($id);
        $fecha = date("Y-m-d");
        $fecha_ini = $this->limpiarCadena($fecha_ini);
        $fecha_fin = $this->limpiarCadena($fecha_fin);
        $permiso = $this->limpiarCadena($permiso);
        $nombre = $primerNombre . " " . $primerApellido;
        $data_json = [
            "exito" => false,
            "messenger" => "datos"
        ];

        $parametros = [$id, $fecha_ini, $fecha_fin];
        $parametroEstadoAusencia = [$id, 1];

        $validarEstadoAusencia = $this->getEstadoAusencia($parametroEstadoAusencia);
        if ($validarEstadoAusencia) {
            $data_json["exito"] = false;
            $data_json['messenger'] = "El estado de este empleado esta activo en el ausento.";
        } else {
            $ausenciaExiste = $this->getexisAusencia($parametros);
            if ($ausenciaExiste['existe']) {
                $data_json["exito"] = false;
                $data_json['messenger'] = "El empleado" . " " . $cedula . " ya tiene asignada una ausencia en las fechas proporcionadas.";
            } else {
                $parametrosRegistro = [
                    [
                        "campo_nombre" => "idEmpleado",
                        "campo_marcador" => ":idEmpleado",
                        "campo_valor" => $id
                    ],
                    [
                        "campo_nombre" => "fechaInicio",
                        "campo_marcador" => ":fechaInicio",
                        "campo_valor" => $fecha_ini
                    ],
                    [
                        "campo_nombre" => "fechaFinal",
                        "campo_marcador" => ":fechaFinal",
                        "campo_valor" => $fecha_fin
                    ],
                    [
                        "campo_nombre" => "idPermiso",
                        "campo_marcador" => ":idPermiso",
                        "campo_valor" =>  $permiso
                    ],
                    [
                        "campo_nombre" => "activo",
                        "campo_marcador" => ":activo",
                        "campo_valor" => "1"
                    ],
                    [
                        "campo_nombre" => "fecha",
                        "campo_marcador" => ":fecha",
                        "campo_valor" => date("Y-m-d")
                    ],
                    [
                        "campo_nombre" => "hora",
                        "campo_marcador" => ":hora",
                        "campo_valor" => date("h:i:s A")
                    ]
                ];

                $registroAuditoria = $this->auditoriaController->registrarAuditoria($this->idUsuario, 'Registrar Ausencia', 'El usuario ' . $this->nombreUsuario . ' registro una ausencia justificada para el empleado ' . $nombre . ' con cedula' . " " . $cedula);
                if ($registroAuditoria) {
                    $data_json["exitoAuditoria"] = true;
                    $data_json['messengerAuditoria'] = "Auditoria registrada con exito.";
                } else {
                    $data_json["exito"] = false;
                    $data_json['messenger'] = "Error al registrar la auditoria.";
                }

                $registroAusencia = $this->getRegistrarAusencia('ausenciajustificada', $parametrosRegistro);
                if ($registroAusencia) {
                    $data_json["exito"] = true;
                    $data_json['messenger'] = "Ausencia registrada con exito.";
                } else {
                    $data_json["exito"] = false;
                    $data_json['messenger'] = "Error al registrar la ausencia.";
                }
            }
        }

        header('Content-Type: application/json');
        echo json_encode($data_json);
    }

    public function todasAusencias()
    {
        $data_json['data'] = []; // Array de datos para enviar
        $tabla = 'ausenciajustificada au INNER JOIN datosempleados dp ON au.idEmpleado = dp.id_empleados INNER JOIN datospersonales dpe ON dp.idPersonal = dpe.id_personal'; // Tabla a consultar
        $selectoresCantidad = 'COUNT(id_ausencia) as cantidad'; // Selector para contar la cantidad de registros de la tabla
        $datosBuscar = []; // Array de selectores para buscar en la tabla
        $campoOrden = 'id_ausencia'; // Campo por el cual se ordenará la tabla
        $selectores = '*,  DATE_FORMAT(au.fechaInicio, "%d-%m-%Y") AS fechaIni, DATE_FORMAT(au.fechaFinal, "%d-%m-%Y") AS fechaFin'; // Selectores para obtener los datos de la tabla
        $conditions = ['au.activo = ?']; // Condiciones para obtener los datos de la tabla
        $conditionParams = [1]; // Parámetros de las condiciones

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
            $buttons = '<div class="d-flex"><button class="btn btn-primary btn-sm btn-hover-azul btnEditarAusencia  me-2" data-id="' . $row['id_ausencia'] . '"><i class="fa-solid fa-pencil fa-sm me-2"></i>Editar</button>';
            $buttons .= '<button class="btn btn-warning btn-sm btn-hover-amarillo btnEliminar" data-swal-toast-template="#my-template" data-id="' . $row['id_ausencia'] . '"><i class="fa-solid fa-trash fa-sm me-2"></i>liberar</button></div>';

            $data_json['data'][] = [
                '0' => $row['primerNombre'] . " " . $row['primerApellido'],
                '1' => $row['cedula'],
                '2' => $row['idPermiso'],
                '3' => $row['fechaIni'],
                '4' => $row['fechaFin'],
                '5' => $buttons,
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

    public function datosEmpleadoAusencia(string $id)
    {
        $id = $this->limpiarCadena($id);
        $data_json = [
            "exito" => false,
            "messenger" => "datos"
        ];

        $datosEmpleado = $this->getDatosAusenciaID([$id]);
        if ($datosEmpleado) {
            foreach ($datosEmpleado as $row) {
                $data_json["exito"] = true;
                $data_json['messenger'] = "Datos del empleado obtenidos con exito.";
                $data_json['cedula'] = $row['cedula'];
                $data_json['nombre'] = $row['primerNombre'];
                $data_json['apellido'] = $row['primerApellido'];
                $data_json['fechaInicio'] = $row['fechaInicio'];
                $data_json['fechaFinal'] = $row['fechaFinal'];
                $data_json['idPermiso'] = $row['idPermiso'];
                $data_json['cargo'] = $row['cargo'];
            }
        } else {
            $data_json["exito"] = false;
            $data_json['messenger'] = "Error al obtener los datos del empleado.";
        }

        header('Content-Type: application/json');
        echo json_encode($data_json);
    }

    public function actualizarAusencia(string $cedula, string $id, string $fecha_ini, string $fecha_fin, string $permiso, $primerNombre, $primerApellido)
    {

        $nombre = $primerNombre . " " . $primerApellido;
        $parametros = [
            [
                "campo_nombre" => "fechaInicio",
                "campo_marcador" => ":fechaInicio",
                "campo_valor" => $fecha_ini
            ],
            [
                "campo_nombre" => "fechaFinal",
                "campo_marcador" => ":fechaFinal",
                "campo_valor" => $fecha_fin
            ],
            [
                "campo_nombre" => "idPermiso",
                "campo_marcador" => ":idPermiso",
                "campo_valor" => $permiso
            ]
        ];

        $condicion = [
            "condicion_campo" => "id_ausencia",
            "condicion_marcador" => ":id_ausencia",
            "condicion_valor" => $id
        ];

        $data_json = [
            "exito" => false,
            "messenger" => "datos"
        ];

        $actualizarAusencia = $this->getActualizarAusencia('ausenciajustificada', $parametros, $condicion);
        if ($actualizarAusencia) {
            $registroAuditoria = $this->auditoriaController->registrarAuditoria($this->idUsuario, 'Actualizar Ausencia', 'El usuario ' . $this->nombreUsuario . ' actualizo una ausencia justificada para el empleado ' . $nombre . ' con cedula' . " " . $cedula);
            if ($registroAuditoria) {
                $data_json["exitoAuditoria"] = true;
                $data_json['messengerAuditoria'] = "Auditoria registrada con exito.";
            } else {
                $data_json["exito"] = false;
                $data_json['messenger'] = "Error al registrar la auditoria.";
            }
            $data_json["exito"] = true;
            $data_json['messenger'] = "Ausencia actualizada con exito.";
        } else {
            $data_json["exito"] = false;
            $data_json['messenger'] = "Error al actualizar la ausencia.";
        }

        header('Content-Type: application/json');
        echo json_encode($data_json);
    }

    public function liberarAusencia(string $id)
    {


        $parametros = [
            [
                "campo_nombre" => "activo",
                "campo_marcador" => ":activo",
                "campo_valor" => 0
            ]
        ];

        $condicion = [
            "condicion_campo" => "id_ausencia",
            "condicion_marcador" => ":id_ausencia",
            "condicion_valor" => $id
        ];

        $data_json = [
            "exito" => false,
            "messenger" => "datos"
        ];

        $datosEmpleado = $this->getDatosAusenciaID([$id]);
        foreach ($datosEmpleado as $row) {
            $cedula = $row['cedula'];
            $nombre = $row['primerNombre'] . " " . $row['primerApellido'];
            $actualizarAusencia = $this->getActualizarAusencia('ausenciajustificada', $parametros, $condicion);
            if ($actualizarAusencia) {
                $registroAuditoria = $this->auditoriaController->registrarAuditoria($this->idUsuario, 'Liberar Ausencia', 'El usuario ' . $this->nombreUsuario . ' libero una ausencia justificada para el empleado ' . $nombre . ' con cedula' . " " . $cedula);
                if ($registroAuditoria) {
                    $data_json["exitoAuditoria"] = true;
                    $data_json['messengerAuditoria'] = "Auditoria registrada con exito.";
                } else {
                    $data_json["exito"] = false;
                    $data_json['messenger'] = "Error al registrar la auditoria.";
                }
                $data_json["exito"] = true;
                $data_json['messenger'] = "Ausencia liberada con exito.";
            } else {
                $data_json["exito"] = false;
                $data_json['messenger'] = "Error al liberar la ausencia.";
            }
        }

        header('Content-Type: application/json');
        echo json_encode($data_json);
    }

    public function registrarVacaciones(string $id, string $cedula, string $ano, string $dias)
    {
        $ano = $this->limpiarCadena($ano);
        $dias = $this->limpiarCadena($dias);
        $id = $this->limpiarCadena($id);
        $fecha = date("Y-m-d");
        $parametros = [
            [
                "campo_nombre" => "idEmpleado",
                "campo_marcador" => ":idEmpleado",
                "campo_valor" => $id
            ],
            [
                "campo_nombre" => "ano",
                "campo_marcador" => ":ano",
                "campo_valor" => $ano
            ],
            [
                "campo_nombre" => "dias",
                "campo_marcador" => ":dias",
                "campo_valor" => $dias
            ],
            [
                "campo_nombre" => "fecha",
                "campo_marcador" => ":fecha",
                "campo_valor" => $fecha
            ],
            [
                "campo_nombre" => "hora",
                "campo_marcador" => ":hora",
                "campo_valor" => date("h:i:s A")
            ]
        ];

        $data_json = [
            "exito" => false,
            "messenger" => "datos"
        ];

        $validarVacionesAno = $this->getValidarVacionesAno([$id, $ano]);
        if ($validarVacionesAno) {
            $datosPersonales = $this->personalModel->getTotalDatosPersonal([$cedula]);
            if ($datosPersonales) {
                foreach ($datosPersonales as $row) {
                    $nombre = $row['primerNombre'] . " " . $row['primerApellido'];
                    $registroVacaciones = $this->getRegistrarAusencia('asignarvacaciones', $parametros);
                    if ($registroVacaciones) {
                        $registroAuditoria = $this->auditoriaController->registrarAuditoria($this->idUsuario, 'Registrar Vacaciones', 'El usuario ' . $this->nombreUsuario . ' registro vacaciones para el empleado' . " " . $nombre);
                        if ($registroAuditoria) {
                            $data_json["exitoAuditoria"] = true;
                            $data_json['messengerAuditoria'] = "Auditoria registrada con exito.";
                        } else {
                            $data_json["exito"] = false;
                            $data_json['messenger'] = "Error al registrar la auditoria.";
                        }
                        $data_json["exito"] = true;
                        $data_json['messenger'] = "Vacaciones registradas con exito.";
                    } else {
                        $data_json["exito"] = false;
                        $data_json['messenger'] = "Error al registrar las vacaciones.";
                    }
                }
            } else {
                $nombre = "Empleado";
            }
        } else {
            $data_json["exito"] = false;
            $data_json['messenger'] = "El empleado ya tiene asignado vacaciones para el año" . " " . $ano;
        }


        header('Content-Type: application/json');
        echo json_encode($data_json);
    }

    //tabla de vacaciones
    public function datosVacaciones()
    {
        $todasVacaciones = $this->getDatosVacaciones();
        if ($todasVacaciones) {
            $data_json['data'] = [];
            foreach ($todasVacaciones as $row) {
                $diasDisfrute = 30 - $row['dias'];
                $buttons = "<button class='btn btn-primary btn-sm btn-hover-azul btnEditar me-2' data-id=" . $row['id_vacaciones'] . "><i class='fa-solid fa-pencil fa-sm me-2'></i>Editar</button>";
                $buttons .= '<button class="btn btn-warning btn-sm btn-hover-amarillo btnEliminar me-2" data-swal-toast-template="#my-template" data-id="' . $row['id_vacaciones'] . '"><i class="fa-solid fa-trash fa-sm me-2"></i>Liberar</button>';
                // $buttons .= '<button class="btn btn-success btn-sm btn-hover-verde btnActualizar" data-id="' . $row['id_vacaciones'] . '"><i class="fa-solid fa-circle-right fa-sm me-2"></i>Actualizar</button></div>';
                $data_json['data'][] = [
                    '0' => $row['primerNombre'] . " " . $row['primerApellido'], //
                    '1' => $row['cedula'],
                    '2' => $row['cargo'],
                    '3' => $row['ano'],
                    '4' => $row['dias'],
                    '5' => $diasDisfrute,
                    '6' => $buttons,
                ];
                $data_json['exito'] = true;
                $data_json['mensaje'] = "todas las dependencias de manera exitosa";
            }
        } else {
            $data_json['data'] = [];
            $data_json['mensaje'] = "No hay datos para mostrar";
        }
        header('Content-Type: application/json');
        echo json_encode($data_json);
    }

    public function datosVacaciones2()
    {
        $data_json['data'] = []; // Array de datos para enviar
        $tabla = 'asignarvacaciones av
        INNER JOIN datosempleados dp ON av.idEmpleado = dp.id_empleados
        INNER JOIN datospersonales dpe ON dp.idPersonal = dpe.id_personal INNER JOIN cargo ca ON dp.idCargo = ca.id_cargo'; // Tabla a consultar
        $selectoresCantidad = 'COUNT(id_vacaciones) as cantidad'; // Selector para contar la cantidad de registros de la tabla
        $datosBuscar = []; // Array de selectores para buscar en la tabla
        $campoOrden = 'id_vacaciones'; // Campo por el cual se ordenará la tabla
        $selectores = '*,  DATE_FORMAT(av.fecha, "%d-%m-%Y") AS fechaFormat'; // Selectores para obtener los datos de la tabla
        $conditions = ['av.activo = ?']; // Condiciones para obtener los datos de la tabla
        $conditionParams = ['1']; // Parámetros de las condiciones

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
            $buttons = '<div class="d-flex contentBoton"><button class="btn btn-primary btn-sm btn-hover-azul btnEditar  me-2" data-id="' . $row['id_vacaciones'] . '"><i class="fa-solid fa-pencil fa-sm me-2"></i>Editar</button>';
            $buttons .= '<button class="btn btn-danger btn-sm btn-hover-rojo btnEliminarVaca" id= "btnEliminarVaca" data-swal-toast-template="#my-template" data-id="' . $row['idEmpleado'] . '"><i class="fa-solid fa-trash fa-sm me-2"></i>Eliminar</button></div>';

            $data_json['data'][] = [
                '0' => $row['primerNombre'] . " " . $row['primerApellido'],
                '1' => $row['cedula'],
                '2' => $row['cargo'],
                '3' => $row['ano'],
                '4' => $row['dias'],
                '5' => $row['fechaFormat'],
                '6' => $buttons,
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

    public function actualizarVacaciones(string $id, string $cedula, string $ano, string $dias, string $diadisfrute)
    {
        $id = $this->limpiarCadena($id);
        $ano = $this->limpiarCadena($ano);

        if (empty($diadisfrute)) {
            $diasDescuento =  $dias;
        } else {
            $diasDescuento =  $dias - $diadisfrute;
        }
        // $dias = $this->limpiarCadena($dias);
        $parametros = [
            [
                "campo_nombre" => "ano",
                "campo_marcador" => ":ano",
                "campo_valor" => $ano
            ],
            [
                "campo_nombre" => "dias",
                "campo_marcador" => ":dias",
                "campo_valor" => $diasDescuento
            ]
        ];

        $condicion = [
            "condicion_campo" => "id_vacaciones",
            "condicion_marcador" => ":id_vacaciones",
            "condicion_valor" => $id
        ];

        $data_json = [
            "exito" => false,
            "messenger" => "datos"
        ];

        if (empty($diadisfrute)) {
            $datosvacacionesViejos = $this->getExisVacaciones([$cedula, $ano]);
            

            $datosVacaciones = $this->getDatosCedulaVacaciones([$cedula]);
                foreach ($datosVacaciones as $row) {
                    $diasViejos = $row['dias'];
                    $anoViejos = $row['ano'];
                }
                $actualizarVacaciones = $this->getActualizarAusencia('asignarvacaciones', $parametros, $condicion);
                if ($actualizarVacaciones) {
                    $datosPersonales = $this->personalModel->getTotalDatosPersonal([$cedula]);
                    if ($datosPersonales) {
                        foreach ($datosPersonales as $row) {
                            $nombre = $row['primerNombre'] . " " . $row['primerApellido'];
                            $registroAuditoria = $this->auditoriaController->registrarAuditoria($this->idUsuario, 'Actualizar Vacaciones', 'El usuario ' . $this->nombreUsuario . ' actualizo vacaciones para el empleado' . " " . $nombre . " de los dias" . $diasViejos . " a " . $dias . " y" . " de los años " . $anoViejos . " a " . $ano);
                            if ($registroAuditoria) {
                                $data_json["exitoAuditoria"] = true;
                                $data_json['messengerAuditoria'] = "Auditoria registrada con exito.";
                            } else {
                                $data_json["exito"] = false;
                                $data_json['messenger'] = "Error al registrar la auditoria.";
                            }
                            $data_json["exito"] = true;
                            $data_json['messenger'] = "Vacaciones actualizadas con exito.";
                        }
                    } else {
                        $nombre = "Empleado";
                    }
                } else {
                    $data_json["exito"] = false;
                    $data_json['messenger'] = "Error al actualizar las vacaciones.";
                }
            // EN CASO QUE ESTEN LOS DIAS QUE SE DESCUENTEN
        } else {
            $datosVacaciones = $this->getDatosCedulaVacaciones([$cedula]);
            foreach ($datosVacaciones as $row) {
                $diasViejos = $row['dias'];
                $anoViejos = $row['ano'];

                $actualizarVacaciones = $this->getActualizarAusencia('asignarvacaciones', $parametros, $condicion);
                if ($actualizarVacaciones) {
                    $datosPersonales = $this->personalModel->getTotalDatosPersonal([$cedula]);
                    if ($datosPersonales) {
                        foreach ($datosPersonales as $row) {
                            $nombre = $row['primerNombre'] . " " . $row['primerApellido'];
                            $registroAuditoria = $this->auditoriaController->registrarAuditoria($this->idUsuario, 'Actualizar Vacaciones', 'El usuario ' . $this->nombreUsuario . ' actualizo vacaciones para el empleado' . " " . $nombre . " de los dias" . $diasViejos . " a " . $dias . " y" . " de los años " . $anoViejos . " a " . $ano);
                            if ($registroAuditoria) {
                                $data_json["exitoAuditoria"] = true;
                                $data_json['messengerAuditoria'] = "Auditoria registrada con exito.";
                            } else {
                                $data_json["exito"] = false;
                                $data_json['messenger'] = "Error al registrar la auditoria.";
                            }
                            $data_json["exito"] = true;
                            $data_json['messenger'] = "Vacaciones actualizadas con exito.";
                        }
                    } else {
                        $nombre = "Empleado";
                    }
                } else {
                    $data_json["exito"] = false;
                    $data_json['messenger'] = "Error al actualizar las vacaciones.";
                }
            }
        }






        header('Content-Type: application/json');
        echo json_encode($data_json);
    }

    public function eliminarVacaciones($id)
    {
        $parametros = [
            [
                "campo_nombre" => "activo",
                "campo_marcador" => ":activo",
                "campo_valor" => 0
            ],

        ];

        $condicion = [
            "condicion_campo" => "idEmpleado",
            "condicion_marcador" => ":idEmpleado",
            "condicion_valor" => $id
        ];

        $actualizarVacaciones = $this->getActualizarAusencia('asignarvacaciones', $parametros, $condicion);
        if ($actualizarVacaciones) {
            $parametrosTra = $this->getTotalDatosEmpeladosID([$id]);
            foreach ($parametrosTra as $row) {
                $nombre = $row['primerNombre'] . " " . $row['primerApellido'];

                $registroAuditoria = $this->auditoriaController->registrarAuditoria($this->idUsuario, 'Actualizar Vacaciones', 'El usuario ' . $this->nombreUsuario . ' elimino las vacaciones para el empleado' . " " . $nombre);
                if ($registroAuditoria) {
                    $data_json["exitoAuditoria"] = true;
                    $data_json['messengerAuditoria'] = "Auditoria registrada con exito.";
                } else {
                    $data_json["exito"] = false;
                    $data_json['messenger'] = "Error al registrar la auditoria.";
                }
                $data_json["exito"] = true;
                $data_json['messenger'] = $parametrosTra;
            }
        } else {
            $data_json["exito"] = false;
            $data_json['messenger'] = "Error al actualizar las vacaciones.";
        }
    }
}
