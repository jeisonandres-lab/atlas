<?php

namespace App\Atlas\controller;

use App\Atlas\models\personalModel;
use App\Atlas\models\dependenciasModel;
use App\Atlas\models\estatusModel;
use App\Atlas\models\cargoModel;
use App\Atlas\models\departamentoModel;
use App\Atlas\controller\fileUploaderController;
use App\Atlas\models\tablasModel;
use App\Atlas\config\App;

date_default_timezone_set("America/Caracas");

class personalController extends personalModel
{

    private $dependencia;
    private $estatus;
    private $archivo;

    private $fileUploader;
    private $tablas;
    private $app;

    private $auditoriaController;
    private $idUsuario;
    private $nombreUsuario;

    public function __construct()
    {
        parent::__construct();
        $this->fileUploader = new fileUploaderController(['pdf', 'jpg', 'png'], '../controller/');
        $this->tablas = new tablasModel();
        $this->app = new App();
        $this->auditoriaController = new auditoriaController();
        $this->app->iniciarSession();
        $this->idUsuario = $_SESSION['id'];
        $this->nombreUsuario = $_SESSION['usuario'];
    }

    //Registro de personal
    public function registro(
        $primerNombre,
        $segundoNombre,
        $primerApellido,
        $segundoApellido,
        $cedula,
        $civil,
        $correo,
        $ano,
        $mes,
        $dia,
        $idEstatus,
        $idCargo,
        $idDependencia,
        $idDepartamento,
        $telefono,
        $nivelAcademico
    ) {
        // sleep(5);
        $primerNombre = $this->limpiarCadena($primerNombre);
        $segundoNombre = $this->limpiarCadena($segundoNombre);
        $primerApellido = $this->limpiarCadena($primerApellido);
        $segundoApellido = $this->limpiarCadena($segundoApellido);
        $cedula = $this->limpiarCadena($cedula);
        $civil = $this->limpiarCadena($civil);
        $correo = $this->limpiarCadena($correo);
        $ano = $this->limpiarCadena($ano);
        $mes = $this->limpiarCadena($mes);
        $dia = $this->limpiarCadena($dia);
        $nivelAcademico = $this->limpiarCadena($nivelAcademico);

        // DATOS DE EMPLEAODS
        $idEstatus = $this->limpiarCadena($idEstatus);
        $idCargo = $this->limpiarCadena($idCargo);
        $idDependencia = $this->limpiarCadena($idDependencia);
        $idDepartamento = $this->limpiarCadena($idDepartamento);
        $telefono = $this->limpiarCadena($telefono);

        $fileInputName = 'contratoArchivo';
        $fileInputName2 = 'notacionAchivo';

        if ($fileInputName == "") {
            $fileInputName = null;
        }

        if ($fileInputName2 == "") {
            $fileInputName2 = null;
        }

        $uploadDir1 = App::URL_CONTRATOS;
        $uploadDir2 = App::URL_NOTACION;

        $data_json = [
            'exito' => false, // Inicializamos a false por defecto
            'mensaje' => '',
            'resultado' => 0,
        ];

        $personal_datos_reg = [
            [
                "campo_nombre" => "primerNombre",
                "campo_marcador" => ":primerNombre",
                "campo_valor" => $primerNombre
            ],
            [
                "campo_nombre" => "segundoNombre",
                "campo_marcador" => ":segundoNombre",
                "campo_valor" => $segundoNombre
            ],
            [
                "campo_nombre" => "primerApellido",
                "campo_marcador" => ":primerApellido",
                "campo_valor" => $primerApellido
            ],
            [
                "campo_nombre" => "segundoApellido",
                "campo_marcador" => ":segundoApellido",
                "campo_valor" => $segundoApellido
            ],
            [
                "campo_nombre" => "cedula",
                "campo_marcador" => ":cedula",
                "campo_valor" => $cedula
            ],
            [
                "campo_nombre" => "estadoCivil",
                "campo_marcador" => ":estadoCivil",
                "campo_valor" => $civil
            ],
            [
                "campo_nombre" => "anoNacimiento",
                "campo_marcador" => ":anoNacimiento",
                "campo_valor" => $ano
            ],
            [
                "campo_nombre" => "mesNacimiento",
                "campo_marcador" => ":mesNacimiento",
                "campo_valor" => $mes
            ],
            [
                "campo_nombre" => "diaNacimiento",
                "campo_marcador" => ":diaNacimiento",
                "campo_valor" => $dia
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

        $parametro = [$cedula];
        $check_exisPersonal = $this->getExistePersonal($parametro);
        if ($check_exisPersonal) {
            // Verificar si los archivos tienen nombres diferentes
            $nombreArchivo1 = isset($_FILES[$fileInputName]) ? $_FILES[$fileInputName]['name'] : 'sin archivo';
            $nombreArchivo2 = isset($_FILES[$fileInputName2]) ? $_FILES[$fileInputName2]['name'] : 'sin archivo';

            if ($nombreArchivo1 && $nombreArchivo2 && $nombreArchivo1 === $nombreArchivo2) {
                $data_json['exito'] = false;
                $data_json['mensaje'] = 'Los dos archivos no pueden tener el mismo nombre.';
            } else {
                // Crear un array con los archivos que se están subiendo
                $archivosASubir = [];
                if ($nombreArchivo1) {
                    $archivosASubir[] = ['input' => $fileInputName, 'dir' => $uploadDir1];
                }
                if ($nombreArchivo2) {
                    $archivosASubir[] = ['input' => $fileInputName2, 'dir' => $uploadDir2]; // Asegúrate de definir $uploadDir2
                }

                // Ejecutar el código de subida si hay archivos para subir
                if (!empty($archivosASubir)) {
                    $resultados = [];
                    $existeArchivo = false;
                    // Verificar si alguno de los archivos ya existe
                    foreach ($archivosASubir as $archivo) {
                        $inputName = $archivo['input'];
                        $nombreArchivos[$inputName] = $this->fileUploader->obtenerNombreArchivo($_FILES[$inputName], $cedula);
                        $direccion = $archivo['dir'] . $nombreArchivos[$inputName]['nombre'];
                        $existeArchivoCheck = $this->fileUploader->archivoExiste2($direccion);
                        if ($existeArchivoCheck['error']) {
                            $existeArchivo = true;
                            $data_json['mensaje'] = $existeArchivoCheck['mensaje'];
                            break;
                        }
                    }
                    // Si alguno de los archivos ya existe, no subir ninguno
                    if ($existeArchivo) {
                        $data_json['exito'] = false;
                        $data_json['resultado'] = 3;
                    } else {
                        $check_regisPersonal = $this->getRegistrar('datospersonales', $personal_datos_reg);
                        if ($check_regisPersonal) {
                            $registroAuditoria = $this->auditoriaController->registrarAuditoria($this->idUsuario, 'Registrar personal', 'El usuario ' . $this->nombreUsuario . ' ha colocado un nuevo personal en el sistema.');
                            if ($registroAuditoria) {
                                $check_busPersonal = $this->getDatosPersonal($parametro);

                                foreach ($check_busPersonal as $row) {
                                    $idPersonal = $row['id_personal'];
                                    $empleados_datos_reg = [
                                        [
                                            "campo_nombre" => "idPersonal",
                                            "campo_marcador" => ":idPersonal",
                                            "campo_valor" =>  $idPersonal
                                        ],
                                        [
                                            "campo_nombre" => "idEstatus",
                                            "campo_marcador" => ":idEstatus",
                                            "campo_valor" => $idEstatus
                                        ],
                                        [
                                            "campo_nombre" => "idCargo",
                                            "campo_marcador" => ":idCargo",
                                            "campo_valor" => $idCargo
                                        ],
                                        [
                                            "campo_nombre" => "idDependencia",
                                            "campo_marcador" => ":idDependencia",
                                            "campo_valor" => $idDependencia
                                        ],
                                        [
                                            "campo_nombre" => "idDepartamento",
                                            "campo_marcador" => ":idDepartamento",
                                            "campo_valor" => $idDepartamento
                                        ],
                                        [
                                            "campo_nombre" => "telefono",
                                            "campo_marcador" => ":telefono",
                                            "campo_valor" => $telefono
                                        ],
                                        [
                                            "campo_nombre" => "nivelAcademico",
                                            "campo_marcador" => ":nivelAcademico",
                                            "campo_valor" => $nivelAcademico
                                        ],
                                        [
                                            "campo_nombre" => "activo",
                                            "campo_marcador" => ":activo",
                                            "campo_valor" => 1
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

                                    $parametro_empleado = [$idPersonal];
                                    $check_regisEmpleados = $this->getRegistrar('datosempleados', $empleados_datos_reg);
                                    if ($check_regisEmpleados) {
                                        $registroAuditoria = $this->auditoriaController->registrarAuditoria($this->idUsuario, 'Registrar empleado', 'El usuario ' . $this->nombreUsuario . ' ha colocado un nuevo empleado en el sistema.');
                                        if ($registroAuditoria) {
                                            $check_busEmpleado = $this->getExisteEmpleado($parametro_empleado);
                                            foreach ($check_busEmpleado as $row) {
                                                $id_empleado = $row['id_empleados'];
                                                // Si ninguno de los archivos existe, proceder con la subida
                                                foreach ($archivosASubir as $archivo) {
                                                    $inputName = $archivo['input'];
                                                    $direccion = $archivo['dir'] . $nombreArchivos[$inputName]['nombre'];
                                                    $resultados[$inputName] = $this->fileUploader->subirArchivo($_FILES[$inputName], $cedula, $archivo['dir'], $id_empleado, null);
                                                    if ($resultados[$inputName]['error']) {
                                                        $data_json['mensaje'] = $resultados[$inputName]['mensaje'];
                                                        $data_json['resultado'] = 3;
                                                        break;
                                                    }
                                                }

                                                if ($nombreArchivo1) {
                                                    $data_json['archivo1'] = $resultados[$fileInputName];
                                                }
                                                if ($nombreArchivo2) {
                                                    $data_json['archivo2'] = $resultados[$fileInputName2];
                                                }

                                                $data_json['exito'] = true;
                                                $data_json['mensaje'] = "Empleado Registrado Exitosamente.";
                                                $data_json['resultado'] = 2;
                                                $datos_json["exitoAuditoria"] = true;
                                                $datos_json['messengerAuditoria'] = "Auditoria registrada con exito.";
                                            }
                                        } else {
                                            $data_json['exito'] = false;
                                            $data_json['mensaje'] = "la auditoria no se pudo registrar con exito, pero si cargo el empleado";
                                            $data_json['resultado'] = 1;
                                        }
                                    } else {
                                        $data_json['exito'] = false;
                                        $data_json['mensaje'] = "Los datos Del Personal fueron registrados exitosamente, pero no de los datos empleados";
                                        $data_json['resultado'] = 1;
                                    }
                                }
                                $datos_json["exitoAuditoria"] = true;
                                $datos_json['messengerAuditoria'] = "Auditoria registrada con exito.";
                            } else {
                                $datos_json["exitoAuditoria"] = false;
                                $datos_json['messengerAuditoria'] = "Error al registrar la auditoria.";
                            }
                        }
                    }
                } else {
                    $data_json['exito'] = false;
                    $data_json['mensaje'] = "Debe subir al menos un archivo.";
                    $data_json['resultado'] = 3;
                }
            }
        } else {
            $data_json = [
                'exito' => false, // Inicializamos a false por defecto
                'mensaje' => 'Este Empleado Ya Esta Registrado',
                'resultado' => 0,
                'error' => true,
                'resultado2' => $check_exisPersonal,
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($data_json);
    }

    //Obtener todos los datos de personal
    public function obtenerDatosPersonal(string $cedula_familiar)
    {
        $cedula_familiar = $this->limpiarCadena($cedula_familiar);
        $data_json = [
            'exito' => false, // Inicializamos a false por defecto
            'mensaje' => 'data del principio',
        ];
        if ($cedula_familiar == "") {
            $data_json['exito'] = true;
            $data_json['mensaje'] = "Debes de llenar el campo de la Cédula para hacer la busqueda del empleado";
            $data_json['logrado'] = false;
        } else {
            $parametro = [$cedula_familiar];
            $check_personal = $this->getTotalDatosPersonal($parametro);
            if ($check_personal == true) {
                foreach ($check_personal as $row) {
                    $activo = $row['activo'] == 1 ? 'Activo' : 'Inactivo';
                    $data_json['exito'] = true;
                    $data_json['idPersonal'] = $row['id_personal'];
                    $data_json['cedula'] = $row['cedula'];
                    $data_json['nombre'] = $row['primerNombre'];
                    $data_json['segundoNombre'] = $row['segundoNombre'];
                    $data_json['apellido'] = $row['primerApellido'];
                    $data_json['segundoApellido'] = $row['segundoApellido'];
                    $data_json['estadoCivil'] = $row['estadoCivil'];
                    $data_json['diaNacimiento'] = $row['diaNacimiento'];
                    $data_json['mesNacimiento'] = $row['mesNacimiento'];
                    $data_json['anoNacimiento'] = $row['anoNacimiento'];
                    $data_json['estatus'] = $row['estatus'];
                    $data_json['idestatus'] = $row['id_estatus'];
                    $data_json['idEmpleado'] = $row['id_empleados'];
                    $data_json['cargo'] = $row['cargo'];
                    $data_json['idcargo'] = $row['id_cargo'];
                    $data_json['dependencia'] = $row['dependencia'];
                    $data_json['iddependencia'] = $row['id_dependencia'];
                    $data_json['departamento'] = $row['departamento'];
                    $data_json['iddepartamento'] = $row['id_departamento'];
                    $data_json['nivelAcademico'] = $row['nivelAcademico'];
                    $data_json['telefono'] = $row['telefono'];
                    $data_json['activo'] = $activo;
                    $data_json['mensaje'] = "Trabajador Encontrado";
                    $data_json['logrado'] = true;
                }
            } else {
                $data_json['exito'] = false;
                $data_json['mensaje'] = "Este trabajador no se encuentra registrado en nuestro sistema.";
                $data_json['logrado'] = false;
            }
        }
        header('Content-Type: application/json');
        echo json_encode($data_json);
    }

    // Obtener datos del familiar
    public function obtenerDatosFamiliar(string $idPersonal)
    {
        $idPersonal = $this->limpiarCadena($idPersonal);

        $data_json = [
            'exito' => false,
            'mensaje' => 'data del principio'
        ];

        if ($idPersonal == "") {
            $data_json['exit'] = true;
            $data_json['mensaje'] = "Debes de llenar el campo de la Cédula para hacer la busqueda del empleado";
        } else {
            $parametro = [$idPersonal];
            $check_familiar = $this->getDatosFamiliar($parametro);
            if ($check_familiar) {
                foreach ($check_familiar as $row) {
                    $data_json['exito'] = true;
                    $data_json['cedulaEmpleado'] = $row['cedulaEmpleado'];
                    $data_json['nombreEmpleado'] = $row['primerNombreEmpleado'];
                    $data_json['apellidoEmpleado'] = $row['primerApellidoEmpleado'];

                    $data_json['idfamiliar'] = $row['id_ninos'];
                    $data_json['cedula'] = $row['cedula'];
                    $data_json['nombre'] = $row['primerNombre'];
                    $data_json['segundoNombre'] = $row['segundoNombre'];
                    $data_json['apellido'] = $row['primerApellido'];
                    $data_json['segundoApellido'] = $row['segundoApellido'];
                    $data_json['parentesco'] = $row['parentesco'];
                    $data_json['edad'] = $row['edad'];
                    $data_json['anoNacimiento'] = $row['anoNacimiento'];
                    $data_json['mesNacimiento'] = $row['mesNacimiento'];
                    $data_json['diaNacimiento'] = $row['diaNacimiento'];
                    $data_json['codigoCarnet'] = $row['codigoCarnet'];
                    $data_json['tomo'] = $row['tomo'];
                    $data_json['folio'] = $row['folio'];
                    $data_json['mensaje'] = "Familiar Encontrado";
                }
            } else {
                $data_json['exit'] = 'epa epa';
                $data_json['mensaje'] = "Este familiar no se encuentra registrado en nuestro sistema.";
            }
        }
        header('Content-Type: application/json');
        echo json_encode($data_json);
    }

    //Registrar Familiar a un empleado
    public function registrarFamilia(
        $parentesco,
        $cedulaEmpleado,
        $primerNombre,
        $segundoNombre,
        $primerApellido,
        $segundoApellido,
        $cedula,
        $edad,
        $ano,
        $mes,
        $dia,
        $numeroCarnet,
        $tomo,
        $folio
    ) {
        sleep(1);
        $cedulaEmpleado = $this->limpiarCadena($cedulaEmpleado);
        $primerNombre = $this->limpiarCadena($primerNombre);
        $segundoNombre = $this->limpiarCadena($segundoNombre);
        $primerApellido = $this->limpiarCadena($primerApellido);
        $segundoApellido = $this->limpiarCadena($segundoApellido);
        $cedula = $this->limpiarCadena($cedula);
        $edad = $this->limpiarCadena($edad);
        $ano = $this->limpiarCadena($ano);
        $mes = $this->limpiarCadena($mes);
        $dia = $this->limpiarCadena($dia);
        $numeroCarnet = $this->limpiarCadena($numeroCarnet);
        $tomo = $this->limpiarCadena($tomo);
        $folio = $this->limpiarCadena($folio);
        $parentesco = $this->limpiarCadena($parentesco);

        if ($cedula == "") {
            $cedula = null;
        }
        if ($tomo == "") {
            $tomo = null;
        }
        if ($folio == "") {
            $folio = null;
        }
        if ($numeroCarnet == "") {
            $numeroCarnet = null;
        }
        $fileInputName = 'docArchivo';
        $fileInputName2 = 'docArchivoDis';
        $uploadDir1 = App::URL_PARTIDANACIMIENTO;
        $uploadDir2 = App::URL_PARTIDADEISCAPACIDAD;

        $data_json = [
            'exito' => true, // Inicializamos a true por defecto
            'mensaje' => 'si llego hasta aqui',
            'resultado' => 0,
            'archivo1' => 'no hay primer archivo',
            'archivo2' => 'no hay segundo archivo',
        ];


        if ($fileInputName == "") {
            $fileInputName = null;
        }

        if ($fileInputName2 == "") {
            $fileInputName2 = null;
        }
        $parametro = [$cedulaEmpleado];
        $check_empleado = $this->getExisteEmpleado_datos($parametro);
        if ($check_empleado) {
            foreach ($check_empleado as $row) {
                $id_empleado = $row['id_empleados'];
                $nombreEmpleado = $row['primerNombre'];
                $apellidoEmpleado = $row['primerApellido'];
                $id_nino = $check_empleado;
                $parametrofamili = [$cedula, $numeroCarnet, $tomo, $folio];
                $parametrosFamilia = [
                    [
                        "campo_nombre" => "cedula",
                        "campo_marcador" => ":cedula",
                        "campo_valor" => $cedula
                    ],
                    [
                        "campo_nombre" => "primerNombre",
                        "campo_marcador" => ":primerNombre",
                        "campo_valor" => $primerNombre
                    ],
                    [
                        "campo_nombre" => "segundoNombre",
                        "campo_marcador" => ":segundoNombre",
                        "campo_valor" => $segundoNombre
                    ],
                    [
                        "campo_nombre" => "primerApellido",
                        "campo_marcador" => ":primerApellido",
                        "campo_valor" => $primerApellido
                    ],
                    [
                        "campo_nombre" => "segundoApellido",
                        "campo_marcador" => ":segundoApellido",
                        "campo_valor" => $segundoApellido
                    ],
                    [
                        "campo_nombre" => "parentesco",
                        "campo_marcador" => ":parentesco",
                        "campo_valor" => $parentesco
                    ],
                    [
                        "campo_nombre" => "edad",
                        "campo_marcador" => ":edad",
                        "campo_valor" => $edad
                    ],
                    [
                        "campo_nombre" => "anoNacimiento",
                        "campo_marcador" => ":anoNacimiento",
                        "campo_valor" => $ano
                    ],
                    [
                        "campo_nombre" => "mesNacimiento",
                        "campo_marcador" => ":mesNacimiento",
                        "campo_valor" => $mes
                    ],
                    [
                        "campo_nombre" => "diaNacimiento",
                        "campo_marcador" => ":diaNacimiento",
                        "campo_valor" => $dia
                    ],
                    [
                        "campo_nombre" => "codigoCarnet",
                        "campo_marcador" => ":codigoCarnet",
                        "campo_valor" => $numeroCarnet
                    ],
                    [
                        "campo_nombre" => "idEmpleado",
                        "campo_marcador" => ":idEmpleado",
                        "campo_valor" => $id_empleado
                    ],
                    [
                        "campo_nombre" => "tomo",
                        "campo_marcador" => ":tomo",
                        "campo_valor" => $tomo
                    ],
                    [
                        "campo_nombre" => "folio",
                        "campo_marcador" => ":folio",
                        "campo_valor" => $folio
                    ],
                    [
                        "campo_nombre" => "activo",
                        "campo_marcador" => ":activo",
                        "campo_valor" => 1
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
                $tabla = 'datosFamilia';
                $parametro_registrar = $parametrosFamilia;
                $check_familiar_exis = $this->getExisteFamiliar($parametrofamili);
                if ($check_familiar_exis) {
                    $data_json['exito'] = true;
                    $data_json['mensaje'] = "Este familiar ya esta registrado";
                } else {
                    // Verificar si los archivos tienen nombres diferentes
                    $nombreArchivo1 = isset($_FILES[$fileInputName]) ? $_FILES[$fileInputName]['name'] : null;
                    $nombreArchivo2 = isset($_FILES[$fileInputName2]) ? $_FILES[$fileInputName2]['name'] : null;

                    if ($nombreArchivo1 && $nombreArchivo2 && $nombreArchivo1 === $nombreArchivo2) {
                        $data_json['exito'] = false;
                        $data_json['mensaje'] = 'Los dos archivos no pueden tener el mismo nombre.';
                    } else {
                        // Crear un array con los archivos que se están subiendo
                        $archivosASubir = [];
                        if ($nombreArchivo1) {
                            $archivosASubir[] = ['input' => $fileInputName, 'dir' => $uploadDir1];
                        }
                        if ($nombreArchivo2) {
                            $archivosASubir[] = ['input' => $fileInputName2, 'dir' => $uploadDir2]; // Asegúrate de definir $uploadDir2
                        }

                        // Si la edad es menor a 18, verificar que al menos uno de los archivos esté presente
                        if ($edad < 18 && empty($archivosASubir)) {
                            $data_json['exito'] = false;
                            $data_json['mensaje'] = 'Debe subir al menos un archivo si la edad es menor a 18 años.';
                        } else {
                            // Ejecutar el código de subida si hay archivos para subir
                            if (!empty($archivosASubir)) {
                                $resultados = [];
                                $existeArchivo = false;
                                // Verificar si alguno de los archivos ya existe
                                foreach ($archivosASubir as $archivo) {
                                    $inputName = $archivo['input'];
                                    $nombreArchivos[$inputName] = $this->fileUploader->obtenerNombreArchivo($_FILES[$inputName], $cedula);
                                    $direccion = $archivo['dir'] . $nombreArchivos[$inputName]['nombre'];
                                    $existeArchivoCheck = $this->fileUploader->archivoExiste2($direccion);
                                    if ($existeArchivoCheck['error']) {
                                        $existeArchivo = true;
                                        $data_json['mensaje'] = $existeArchivoCheck['mensaje'];
                                        break;
                                    }
                                }

                                // Si alguno de los archivos ya existe, no subir ninguno
                                if ($existeArchivo) {
                                    $data_json['exito'] = false;
                                    $data_json['resultado'] = 3;
                                } else {
                                    $check_familiar = $this->getRegistrarEmpleado($tabla, $parametro_registrar);
                                    if ($check_familiar) {
                                        $registroAuditoria = $this->auditoriaController->registrarAuditoria($this->idUsuario, 'Registrar familiar', 'El usuario ' . $this->nombreUsuario . ' asigno un nuevo familiar en el sistema al empleado ' . $nombreEmpleado . ' ' . $apellidoEmpleado . ' portador de la cedula ' . $cedulaEmpleado . ' el familiar asignado fue ' . $primerNombre . ' ' . $primerApellido . '.');
                                        if ($registroAuditoria) {
                                            $data_json["exitoAuditoria"] = true;
                                            $data_json['messengerAuditoria'] = "Auditoria registrada con exito.";
                                        } else {
                                            $data_json["exitoAuditoria"] = false;
                                            $data_json['messengerAuditoria'] = "Error al registrar la auditoria.";
                                        }
                                        $check_exisfamiliar = $this->getExisteFamiliar($parametrofamili);
                                        foreach ($check_exisfamiliar as $row) {
                                            $id_nino = $row['id_ninos'];
                                            // Si ninguno de los archivos existe, proceder con la subida
                                            foreach ($archivosASubir as $archivo) {
                                                $inputName = $archivo['input'];
                                                $direccion = $archivo['dir'] . $nombreArchivos[$inputName]['nombre'];
                                                $resultados[$inputName] = $this->fileUploader->subirArchivo($_FILES[$inputName], $cedula, $archivo['dir'], $id_empleado, $id_nino);
                                                if ($resultados[$inputName]['error']) {
                                                    $data_json['mensaje'] = $resultados[$inputName]['mensaje'];
                                                    $data_json['resultado'] = 3;
                                                    break;
                                                }
                                            }

                                            if ($nombreArchivo1) {
                                                $data_json['archivo1'] = $resultados[$fileInputName];
                                            }
                                            if ($nombreArchivo2) {
                                                $data_json['archivo2'] = $resultados[$fileInputName2];
                                            }
                                        }
                                        $data_json['exito'] = true;
                                        $data_json['mensaje'] = "Familiar Registrado Exitosamente.";
                                        $data_json['resultado'] = 2;
                                    } else {
                                        $data_json['exito'] = false;
                                        $data_json['mensaje'] = "Los documentos fueron cargados exitosamente, pero no el familiar.";
                                        $data_json['resultado'] = 1;
                                    }
                                }
                            } else {
                                // Si no hay archivos para subir, registrar el familiar sin archivos
                                $check_familiar = $this->getRegistrarEmpleado($tabla, $parametro_registrar);
                                if ($check_familiar) {
                                    $data_json['exito'] = true;
                                    $data_json['mensaje'] = "Familiar Registrado Exitosamente.";
                                    $data_json['resultado'] = 2;
                                } else {
                                    $data_json['exito'] = false;
                                    $data_json['mensaje'] = "Error al registrar el familiar.";
                                    $data_json['resultado'] = 1;
                                }
                            }
                        }
                    }
                }
            }
        } else {
            $data_json['exito'] = true;
            $data_json['mensaje'] = 'No existe el empleado al que intentas asignar el familiar.' . $parametro;
            $data_json['resultado'] = var_dump($parametro);
        }

        header('Content-Type: application/json');
        echo json_encode($data_json);
    }

    //Obtener todos los datos de dependencias
    public function obtenerDependencias()
    {
        $dependencias = $this->getDependenciasPersonales();
        foreach ($dependencias as $row) {
            $data_json['exito'] = true;
            $data_json['data'][] = [
                'id' => $row['id_dependencia'],
                'value' => $row['dependencia'],
            ];
            $data_json['mensaje'] = "todas las dependencias exitoso";
        }
        header('Content-Type: application/json');
        echo json_encode($data_json);
    }

    //Obtener todos los datos de estatus
    public function obtenerEstatus()
    {
        $estatus = $this->getEstatusPersonales();
        foreach ($estatus as $row) {
            $data_json['exito'] = true;
            $data_json['data'][] = [
                'id' => $row['id_estatus'],
                'value' => $row['estatus']
            ];
            $data_json['mensaje'] = "todas las estatus exitoso";
        }
        header('Content-Type: application/json');
        echo json_encode($data_json);
    }

    //Obtener todos los datos de cargo
    public function obtenerCargo()
    {
        $cargo = $this->getCargoPersonales();
        foreach ($cargo as $row) {
            $data_json['exito'] = true;
            $data_json['data'][] = [
                'id' => $row['id_cargo'],
                'value' => $row['cargo']
            ];
            $data_json['mensaje'] = "todas las cargo exitoso";
        }
        header('Content-Type: application/json');
        echo json_encode($data_json);
    }

    //Obtener todos los datos de departamento
    public function obtenerDepartamento()
    {
        $departamento = $this->getDepartamentosPersonales();
        $data_json = [
            'exito' => false,
            'data' => [],
            'mensaje' => 'No se encontraron departamentos'
        ];

        if (!empty($departamento)) {
            $data_json['exito'] = true;
            $data_json['mensaje'] = 'Todos los departamentos obtenidos exitosamente';
            foreach ($departamento as $row) {
                $data_json['data'][] = [
                    'id' => $row['id_departamento'],
                    'value' => $row['departamento']
                ];
            }
        }

        header('Content-Type: application/json');
        echo json_encode($data_json);
    }

    //Inyectar dependencias
    public function objetoDependencia()
    {
        return $this->dependencia = new dependenciasModel();
    }

    //Inyectar cargo
    public function objetoCargo()
    {
        return $this->dependencia = new cargoModel();
    }

    //Inyectar departamento
    public function objetoDepartamento()
    {
        return $this->dependencia = new departamentoModel();
    }

    //Inyectar estatus
    public function objetoEstatus()
    {
        return $this->estatus = new estatusModel();
    }

    //Obtener todos los datos de personal para la tabla
    public function obtenerTodoPersonal()
    {
        $data_json['data'] = []; // Array de datos para enviar
        $tabla = 'datosempleados e
              INNER JOIN datospersonales d ON e.idPersonal = d.id_personal
              INNER JOIN estatus es ON e.idEstatus = es.id_estatus
              INNER JOIN cargo ca ON e.idCargo = ca.id_cargo
              INNER JOIN dependencia depe ON e.idDependencia = depe.id_dependencia
              INNER JOIN departamento depa ON e.idDepartamento = depa.id_departamento'; // Tabla a consultar
        $selectoresCantidad = 'COUNT(e.idPersonal) as cantidad'; // Selector para contar la cantidad de registros de la tabla
        $datosBuscar = ['depe.dependencia', 'd.primerNombre', 'd.cedula', 'ca.cargo']; // Array de selectores para buscar en la tabla
        $campoOrden = 'e.idPersonal'; // Campo por el cual se ordenará la tabla
        $selectores = 'e.id_empleados, e.idPersonal, d.primerNombre, d.segundoNombre, d.primerApellido, d.segundoApellido, d.cedula, e.idEstatus, ca.cargo, e.idCargo, depe.dependencia, depa.departamento'; // Selectores para obtener los datos de la tabla
        $conditions = ['e.activo = ?'];
        $conditionParams = ['1'];

        $draw = $_REQUEST['draw'] ?? '';
        $start = $_REQUEST['start'] ?? '';
        $length = $_REQUEST['length'] ?? '';
        $searchValue = $_REQUEST['search']['value'] ?? '';

        // Obtener la cantidad de los datos de la tabla
        $cantidadRegistro = $this->tablas->getCantidadRegistros($tabla, $selectoresCantidad, $conditions, $conditionParams);
        // Obtener los datos de la tabla
        $personal = $this->tablas->getTodoDatosPersonal($selectores, $tabla, $start, $length, $searchValue, $datosBuscar, $campoOrden, $conditions, $conditionParams, $orderTable = 'ASC');
        // Recorrer datos de la tabla
        foreach ($personal as $row) {
            $data_json['exito'] = true;
            $parametro = [$row['id_empleados']];
            $validarFamiliar = $this->getExisteEmpleadoFamiliar($parametro);
            $botones = "

                <button class='btn btn-primary btn-sm btn-hover-azul btnEditar ' data-bs-toggle='modal' data-bs-target='#editarDatos' data-cedula=" . $row['cedula'] . "><i class='fa-solid fa-pencil fa-sm me-2'></i>Editar</button>
                <button class='btn btn-danger btn-sm btn-hover-rojo btnEliminar ' data-swal-toast-template='#my-template' data-id=" . $row['id_empleados'] . "><i class='fa-solid fa-trash fa-sm me-2'></i>Eliminar</button>
        ";

            if ($validarFamiliar) {
                $botones .= "<button class='btn btn-warning btn-sm btn-familiar btn-hover-amarillo ' data-swal-toast-template='#my-template' data-id=" . $row['id_empleados'] . "><i class='fa-duotone fa-solid fa-people-group fa-sm me-2'></i>Familiar</button>";
            }



            $data_json['data'][] = [
                '0' => $row['primerNombre'] . " " . $row['primerApellido'],
                '1' => $row['idEstatus'],
                '2' => $row['idCargo'],
                '3' => $row['dependencia'],
                '4' => $row['departamento'],
                '5' => $row['cedula'],
                '6' => $botones
            ];
            $data_json['mensaje'] = "todas las personas exitoso";
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

    //Obtener todos los datos de personal para la tabla
    public function obtenerFamiliar($idEmpleado)
    {
        $data_json['data'] = []; // Array de datos para enviar
        $tabla = 'datosfamilia '; // Tabla a consultar
        $selectoresCantidad = 'COUNT(id_ninos) as cantidad'; // Selector para contar la cantidad de registros de la tabla
        $datosBuscar = []; // Array de selectores para buscar en la tabla
        $campoOrden = 'id_ninos'; // Campo por el cual se ordenará la tabla
        $selectores = '*'; // Selectores para obtener los datos de la tabla
        $conditions = ["idEmpleado = ?", "activo = ?"];
        $conditionParams = [$idEmpleado, '1'];

        $draw = $_REQUEST['draw'];
        $start = $_REQUEST['start'];
        $length = $_REQUEST['length'];
        $searchValue = $_REQUEST['search']['value'];

        // Obtener la cantidad de los datos de la tabla
        $cantidadRegistro = $this->tablas->getCantidadRegistros($tabla, $selectoresCantidad, $conditions, $conditionParams);
        // Obtener los datos de la tabla
        $personal = $this->tablas->getTodoDatosPersonal($selectores, $tabla, $start, $length, $searchValue, $datosBuscar, $campoOrden, $conditions, $conditionParams, $orderTable = 'ASC');
        // Recorrer datos de la tabla
        foreach ($personal as $row) {
            $data_json['exito'] = true;
            $parametro = [$row['id_ninos']];
            $parametro2 = $row['idEmpleado'];
            $parametro3 = $row['id_ninos'];
            $tabla2 = 'documentacion'; // Tabla a consultar
            $campoOrden2 = 'idNinos'; // Campo por el cual se ordenará la tabla
            $selectores2 = '*'; // Selectores para obtener los datos de la tabla
            $conditions2 = ["idEmpleados = ?", "idNinos = ?"];
            $conditionParams2 = [$parametro2, $parametro3];

            $validarDocumentos = $this->tablas->tablas($selectores2, $tabla2, $campoOrden2, $conditions2, $conditionParams2);
            $validarFamiliar = $this->getExisteEmpleadoFamiliar($parametro);
            $botones = "
                <button class='btn btn-primary btn-sm btn-hover-azul btnEditarFamiliar ' data-bs-toggle='modal' data-bs-target='#editarDatosFamiliar' data-cedula=" . $row['id_ninos'] . "><i class='fa-solid fa-pencil fa-sm me-2'></i>Editar</button>
                <button class='btn btn-danger btn-sm btn-hover-rojo btnEliminar'  data-swal-toast-template='#my-template' data-id=" . $row['id_ninos'] .  "><i class='fa-solid fa-trash fa-sm me-2'></i>Eliminar</button>
            ";

            $botonDoc = "<div class='btn-group' role='group' aria-label='Basic example'>";
            $documentosEncontrados = false; // Variable para verificar si se encontraron documentos

            // Generar un botón por cada archivo encontrado
            foreach ($validarDocumentos as $documento) {
                $documentosEncontrados = true; // Se encontró al menos un documento
                $tipodoc = $documento['tipoDoc'];
                if ($tipodoc == 'pdf') {
                    $botonDoc .= "<button class='btn btn-danger btn-sm botondocumet btn-hover' data-doc='" . $documento['doc'] . "'><i class='fa-solid fa-file-pdf fa-sm'></i> " . $documento['tipoDoc'] . "</button>";
                } elseif ($tipodoc == 'png') {
                    $botonDoc .= "<button class='btn btn-success btn-sm botondocumet btn-hover' data-doc='" . $documento['doc'] . "'><i class='fa-solid fa-file-image fa-sm me-1'></i>" . $documento['tipoDoc'] . "</button>";
                }
            }

            // Si no se encontraron documentos, agregar el mensaje "Sin documentos"
            if (!$documentosEncontrados) {
                $botonDoc .= "<span>Sin documentos</span>";
            }

            $botonDoc .= "</div>";
            $data_json['data'][] = [
                '0' => $row['primerNombre'] . " " . $row['primerApellido'],
                '1' => $row['cedula'],
                '2' => $row['codigoCarnet'],
                '3' => $row['edad'],
                '4' => $row['tomo'],
                '5' => $row['folio'],
                '6' => $botones,
                '7' => $botonDoc,
            ];
            $data_json['mensaje'] = "todas las personas exitoso";
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

    //Encapsulamineto de estatus
    protected function getEstatusPersonales()
    {
        $estatusPersonal = $this->objetoEstatus();
        return $estatusPersonal->getDatosEstatus();
    }

    //Encapsulamineto de cargo
    protected function getCargoPersonales()
    {
        $cargoPersonal = $this->objetoCargo();
        return $cargoPersonal->getDatosCargo();
    }

    //Encapsulamineto de dependencias
    protected function getDependenciasPersonales()
    {
        $dependenciaPersonal = $this->objetoDependencia();
        return $dependenciaPersonal->getDatosDependencia();
    }

    //Encapsulamiento de departamentos
    protected function getDepartamentosPersonales()
    {
        $departamentoPersonal = $this->objetoDepartamento();
        return $departamentoPersonal->getDatosDepartamento();
    }

    //Eliminar personal empleado
    public function eliminarPersonal($idPersonal)
    {
        $idPersonal = $this->limpiarCadena($idPersonal);
        $parametro = [
            [
                "campo_nombre" => "activo",
                "campo_marcador" => ":activo",
                "campo_valor" => '0'
            ]
        ];

        // Asegúrate de que el marcador de parámetro coincida con el nombre del campo en la consulta SQL
        $condicion = [
            "condicion_campo" => "id_empleados",
            "condicion_marcador" => ":id_empleados",
            "condicion_valor" => $idPersonal
        ];
        $data_json = [
            'exito' => false, // Inicializamos a false por defecto
            'mensaje' => '',
        ];
        // Llama al método de actualización en el modelo
        $resultado = $this->getActualizar('datosempleados', $parametro,  $condicion);

        if ($resultado) {
            $data_json['exito'] = true;
            $data_json['mensaje'] = 'eliminado correctamente.';
        } else {
            // Manejo de error
        }

        header('Content-Type: application/json');
        echo json_encode($data_json);
    }

    //Eliminar familiar del empleado
    public function eliminarFamiliar($idPersonal)
    {
        $idPersonal = $this->limpiarCadena($idPersonal);
        $parametro = [
            [
                "campo_nombre" => "activo",
                "campo_marcador" => ":activo",
                "campo_valor" => '0'
            ]
        ];

        // Asegúrate de que el marcador de parámetro coincida con el nombre del campo en la consulta SQL
        $condicion = [
            "condicion_campo" => "id_ninos",
            "condicion_marcador" => ":id_ninos",
            "condicion_valor" => $idPersonal
        ];

        $data_json = [
            'exito' => false, // Inicializamos a false por defecto
            'mensaje' => '',
        ];
        // Llama al método de actualización en el modelo
        $resultado = $this->getActualizar('datosfamilia', $parametro,  $condicion);

        if ($resultado) {
            $data_json['exito'] = true;
            $data_json['mensaje'] = 'eliminado correctamente.';
        } else {
            // Manejo de error
        }

        header('Content-Type: application/json');
        echo json_encode($data_json);
    }

    //Actualizar personal empleado
    public function actualizarPersonal(
        $idPersonal,
        $primerNombre,
        $segundoNombre,
        $primerApellido,
        $segundoApellido,
        $cedula,
        $civil,
        $correo,
        $ano,
        $mes,
        $dia,
        $idEstatus,
        $idCargo,
        $idDependencia,
        $idDepartamento,
        $telefono,
        $nivelAcademico
    ) {
        $primerNombre = $this->limpiarCadena($primerNombre);
        $segundoNombre = $this->limpiarCadena($segundoNombre);
        $primerApellido = $this->limpiarCadena($primerApellido);
        $segundoApellido = $this->limpiarCadena($segundoApellido);
        $cedula = $this->limpiarCadena($cedula);
        $civil = $this->limpiarCadena($civil);
        $correo = $this->limpiarCadena($correo);
        $ano = $this->limpiarCadena($ano);
        $mes = $this->limpiarCadena($mes);
        $dia = $this->limpiarCadena($dia);
        $fecha = date("Y-m-d");
        $hora = date("h:i:s A");
        $nivelAcademico = $this->limpiarCadena($nivelAcademico);

        // DATOS DE EMPLEADOS
        $idEstatus = $this->limpiarCadena($idEstatus);
        $idCargo = $this->limpiarCadena($idCargo);
        $idDependencia = $this->limpiarCadena($idDependencia);
        $idDepartamento = $this->limpiarCadena($idDepartamento);
        $telefono = $this->limpiarCadena($telefono);

        $fileInputName = 'contratoArchivo';
        $fileInputName2 = 'notacionAchivo';

        $uploadDir1 = App::URL_CONTRATOS;
        $uploadDir2 = App::URL_NOTACION;

        $data_json = [
            'exito' => false, // Inicializamos a false por defecto
            'mensaje' => '',
            'resultado' => 0,
        ];

        // Asegúrate de que el marcador de parámetro coincida con el nombre del campo en la consulta SQL
        $condicion = [
            "condicion_campo" => "cedula",
            "condicion_marcador" => ":cedula",
            "condicion_valor" => $cedula
        ];

        $personal_datos_reg = [
            [
                "campo_nombre" => "primerNombre",
                "campo_marcador" => ":primerNombre",
                "campo_valor" => $primerNombre
            ],
            [
                "campo_nombre" => "segundoNombre",
                "campo_marcador" => ":segundoNombre",
                "campo_valor" => $segundoNombre
            ],
            [
                "campo_nombre" => "primerApellido",
                "campo_marcador" => ":primerApellido",
                "campo_valor" => $primerApellido
            ],
            [
                "campo_nombre" => "segundoApellido",
                "campo_marcador" => ":segundoApellido",
                "campo_valor" => $segundoApellido
            ],
            [
                "campo_nombre" => "cedula",
                "campo_marcador" => ":cedula",
                "campo_valor" => $cedula
            ],
            [
                "campo_nombre" => "estadoCivil",
                "campo_marcador" => ":estadoCivil",
                "campo_valor" => $civil
            ],
            [
                "campo_nombre" => "anoNacimiento",
                "campo_marcador" => ":anoNacimiento",
                "campo_valor" => $ano
            ],
            [
                "campo_nombre" => "mesNacimiento",
                "campo_marcador" => ":mesNacimiento",
                "campo_valor" => $mes
            ],
            [
                "campo_nombre" => "diaNacimiento",
                "campo_marcador" => ":diaNacimiento",
                "campo_valor" => $dia
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
        $parametro = [$idPersonal];

        // Verificar si los archivos tienen nombres diferentes
        $nombreArchivo1 = isset($_FILES[$fileInputName]) ? $_FILES[$fileInputName]['name'] : null;
        $nombreArchivo2 = isset($_FILES[$fileInputName2]) ? $_FILES[$fileInputName2]['name'] : null;

        if ($nombreArchivo1 && $nombreArchivo2 && $nombreArchivo1 === $nombreArchivo2) {
            $data_json['exito'] = false;
            $data_json['mensaje'] = 'Los dos archivos no pueden tener el mismo nombre.';
        } else {
            // Crear un array con los archivos que se están subiendo
            $archivosASubir = [];
            if ($nombreArchivo1) {
                $archivosASubir[] = ['input' => $fileInputName, 'dir' => $uploadDir1];
            }
            if ($nombreArchivo2) {
                $archivosASubir[] = ['input' => $fileInputName2, 'dir' => $uploadDir2]; // Asegúrate de definir $uploadDir2
            }

            // Ejecutar el código de subida si hay archivos para subir
            if (!empty($archivosASubir)) {
                $resultados = [];
                $existeArchivo = false;
                // Verificar si alguno de los archivos ya existe
                foreach ($archivosASubir as $archivo) {
                    $inputName = $archivo['input'];
                    $nombreArchivos[$inputName] = $this->fileUploader->obtenerNombreArchivo($_FILES[$inputName], $cedula);
                    $direccion = $archivo['dir'] . $nombreArchivos[$inputName]['nombre'];
                    $existeArchivoCheck = $this->fileUploader->archivoExiste2($direccion);
                    if ($existeArchivoCheck['error']) {
                        $existeArchivo = true;
                        $data_json['mensaje'] = $existeArchivoCheck['mensaje'];
                        break;
                    }
                }
                // Si alguno de los archivos ya existe, no subir ninguno
                if ($existeArchivo) {
                    $data_json['exito'] = false;
                    $data_json['resultado'] = 3;
                } else {
                    $viejosDatos = $this->getTotalDatosID($parametro);
                    foreach ($viejosDatos as $row) {
                        $check_regisPersonal = $this->actualizarPersonalMode(
                            $primerNombre,
                            $segundoNombre,
                            $primerApellido,
                            $segundoApellido,
                            $cedula,
                            $civil,
                            $ano,
                            $mes,
                            $dia,
                            $fecha,
                            $hora
                        );
                        if ($check_regisPersonal) {

                            $registroAuditoria = $this->auditoriaController->registrarAuditoria($this->idUsuario, 'Actualizar personal', 'El usuario ' . $this->nombreUsuario . ' actualizo los datos del personal con cedula ' . $cedula . '.');

                            $condicion_empleado = [
                                "condicion_campo" => "idPersonal",
                                "condicion_marcador" => ":idPersonal",
                                "condicion_valor" => $idPersonal
                            ];

                            $empleados_datos_reg = [
                                [
                                    "campo_nombre" => "idPersonal",
                                    "campo_marcador" => ":idPersonal",
                                    "campo_valor" =>  $idPersonal
                                ],
                                [
                                    "campo_nombre" => "idEstatus",
                                    "campo_marcador" => ":idEstatus",
                                    "campo_valor" => $idEstatus
                                ],
                                [
                                    "campo_nombre" => "idCargo",
                                    "campo_marcador" => ":idCargo",
                                    "campo_valor" => $idCargo
                                ],
                                [
                                    "campo_nombre" => "idDependencia",
                                    "campo_marcador" => ":idDependencia",
                                    "campo_valor" => $idDependencia
                                ],
                                [
                                    "campo_nombre" => "idDepartamento",
                                    "campo_marcador" => ":idDepartamento",
                                    "campo_valor" => $idDepartamento
                                ],
                                [
                                    "campo_nombre" => "telefono",
                                    "campo_marcador" => ":telefono",
                                    "campo_valor" => $telefono
                                ],
                                [
                                    "campo_nombre" => "nivelAcademico",
                                    "campo_marcador" => ":nivelAcademico",
                                    "campo_valor" => $nivelAcademico
                                ],
                                [
                                    "campo_nombre" => "activo",
                                    "campo_marcador" => ":activo",
                                    "campo_valor" => 1
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

                            $parametro_empleado = [$idPersonal];
                            $check_regisEmpleados = $this->actualizarEmpleadoMode(
                                $idEstatus,
                                $idCargo,
                                $idDependencia,
                                $telefono,
                                $idDepartamento,
                                $fecha,
                                $hora,
                                $idPersonal,
                                $nivelAcademico
                            );
                            if ($check_regisEmpleados) {
                                $registroAuditoria = $this->auditoriaController->registrarAuditoria($this->idUsuario, 'Actualizar empleado', 'El usuario ' . $this->nombreUsuario . ' actualizo los datos del empleado con cedula ' . $cedula . '.');

                                $check_busEmpleado = $this->getExisteEmpleado($parametro_empleado);
                                foreach ($check_busEmpleado as $row) {
                                    $id_empleado = $row['id_empleados'];
                                    // Si ninguno de los archivos existe, proceder con la subida
                                    foreach ($archivosASubir as $archivo) {
                                        $inputName = $archivo['input'];
                                        $direccion = $archivo['dir'] . $nombreArchivos[$inputName]['nombre'];
                                        $resultados[$inputName] = $this->fileUploader->subirArchivo($_FILES[$inputName], $cedula, $archivo['dir'], $id_empleado, null);
                                        if ($resultados[$inputName]['error']) {
                                            $data_json['mensaje'] = $resultados[$inputName]['mensaje'];
                                            $data_json['resultado'] = 3;
                                            break;
                                        }
                                    }
                                    if ($nombreArchivo1) {
                                        $data_json['archivo1'] = $resultados[$fileInputName];
                                    }
                                    if ($nombreArchivo2) {
                                        $data_json['archivo2'] = $resultados[$fileInputName2];
                                    }
                                    if ($registroAuditoria) {
                                        $data_json["exitoAuditoria"] = true;
                                        $data_json['messengerAuditoria'] = "Auditoria registrada con exito.";
                                    } else {
                                        $data_json["exitoAuditoria"] = false;
                                        $data_json['messengerAuditoria'] = "Error al registrar la auditoria.";
                                    }
                                    $data_json['exito'] = true;
                                    $data_json['mensaje'] = "Empleado Registrado Exitosamente.";
                                    $data_json['resultado'] = 2;
                                }
                            } else {
                                $data_json['exito'] = false;
                                $data_json['mensaje'] = "Los datos Del Personal fueron registrados exitosamente, pero el de los datos empleados";
                                $data_json['resultado'] = 1;
                            }
                        }
                    }
                }
            } else {
                // Si no hay archivos para subir, proceder con la actualización de los datos
                $viejosDatos = $this->getTotalDatosID($parametro);
                foreach ($viejosDatos as $row) {
                    $idPersonal = $row['id_personal'];
                    $check_regisPersonal = $this->actualizarPersonalMode(
                        $primerNombre,
                        $segundoNombre,
                        $primerApellido,
                        $segundoApellido,
                        $cedula,
                        $civil,
                        $ano,
                        $mes,
                        $dia,
                        $fecha,
                        $hora
                    );
                    if ($check_regisPersonal) {
                        $registroAuditoria = $this->auditoriaController->registrarAuditoria($this->idUsuario, 'Actualizar personal', 'El usuario ' . $this->nombreUsuario . ' actualizo los datos del personal ' . $primerNombre . ' ' . $primerApellido . ' por tador de la cédula ' . $cedula . '.');

                        $check_busPersonalNuevo = $this->getTotalDatosID($parametro);
                        foreach ($check_busPersonalNuevo as $row) {

                            $condicion_empleado = [
                                "condicion_campo" => "idPersonal",
                                "condicion_marcador" => ":idPersonal",
                                "condicion_valor" => $idPersonal
                            ];
                            $empleados_datos_reg = [
                                [
                                    "campo_nombre" => "idPersonal",
                                    "campo_marcador" => ":idPersonal",
                                    "campo_valor" =>  $idPersonal
                                ],
                                [
                                    "campo_nombre" => "idEstatus",
                                    "campo_marcador" => ":idEstatus",
                                    "campo_valor" => $idEstatus
                                ],
                                [
                                    "campo_nombre" => "idCargo",
                                    "campo_marcador" => ":idCargo",
                                    "campo_valor" => $idCargo
                                ],
                                [
                                    "campo_nombre" => "idDependencia",
                                    "campo_marcador" => ":idDependencia",
                                    "campo_valor" => $idDependencia
                                ],
                                [
                                    "campo_nombre" => "idDepartamento",
                                    "campo_marcador" => ":idDepartamento",
                                    "campo_valor" => $idDepartamento
                                ],
                                [
                                    "campo_nombre" => "telefono",
                                    "campo_marcador" => ":telefono",
                                    "campo_valor" => $telefono
                                ],
                                [
                                    "campo_nombre" => "nivelAcademico",
                                    "campo_marcador" => ":nivelAcademico",
                                    "campo_valor" => $nivelAcademico
                                ],
                                [
                                    "campo_nombre" => "activo",
                                    "campo_marcador" => ":activo",
                                    "campo_valor" => 1
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
                            $parametro_empleado = [$idPersonal];
                            $check_regisEmpleados = $this->actualizarEmpleadoMode(
                                $idEstatus,
                                $idCargo,
                                $idDependencia,
                                $telefono,
                                $idDepartamento,
                                $fecha,
                                $hora,
                                $idPersonal,
                                $nivelAcademico
                            );
                            if ($check_regisEmpleados) {
                                $registroAuditoria = $this->auditoriaController->registrarAuditoria($this->idUsuario, 'Actualizar empleado', 'El usuario ' . $this->nombreUsuario . ' actualizo los datos del empleado con cedula ' . $cedula . '.');

                                $check_busEmpleado = $this->getExisteEmpleado($parametro_empleado);
                                foreach ($check_busEmpleado as $row) {
                                    $id_empleado = $row['id_empleados'];
                                    $data_json['exito'] = true;
                                    $data_json['mensaje'] = "Empleado Registrado Exitosamente.";
                                    $data_json['resultado'] = 2;
                                }
                                if ($registroAuditoria) {
                                    $data_json["exitoAuditoria"] = true;
                                    $data_json['messengerAuditoria'] = "Auditoria registrada con exito.";
                                } else {
                                    $data_json["exitoAuditoria"] = false;
                                    $data_json['messengerAuditoria'] = "Error al registrar la auditoria.";
                                }
                            } else {
                                $data_json['exito'] = false;
                                $data_json['mensaje'] = "Los datos Del Personal fueron registrados exitosamente, pero el de los datos empleados";
                                $data_json['resultado'] = 1;
                            }
                        }
                    }
                }
            }
        }
        header('Content-Type: application/json');
        echo json_encode($data_json);
    }

    //Actualizar familiar empleado
    public function actualizarFamiliar(
        $idfamiliar,
        $parentesco,
        $cedulaEmpleado,
        $primerNombre,
        $segundoNombre,
        $primerApellido,
        $segundoApellido,
        $cedula,
        $edad,
        $ano,
        $mes,
        $dia,
        $numeroCarnet,
        $tomo,
        $folio
    ) {
        $primerNombre = $this->limpiarCadena($primerNombre);
        $segundoNombre = $this->limpiarCadena($segundoNombre);
        $primerApellido = $this->limpiarCadena($primerApellido);
        $segundoApellido = $this->limpiarCadena($segundoApellido);
        $cedula = $this->limpiarCadena($cedula);
        $cedulaEmpleado = $this->limpiarCadena($cedulaEmpleado);
        $edad = $this->limpiarCadena($edad);
        $ano = $this->limpiarCadena($ano);
        $mes = $this->limpiarCadena($mes);
        $dia = $this->limpiarCadena($dia);
        $numeroCarnet = $this->limpiarCadena($numeroCarnet);
        $tomo = $this->limpiarCadena($tomo);
        $folio = $this->limpiarCadena($folio);
        $parentesco = $this->limpiarCadena($parentesco);

        $fileInputName = 'docArchivo';
        $fileInputName2 = 'docArchivoDis';
        $uploadDir1 = App::URL_PARTIDANACIMIENTO;
        $uploadDir2 = App::URL_PARTIDADEISCAPACIDAD;

        if ($tomo == '') {
            $tomo = null;
        }
        if ($folio == '') {
            $folio = null;
        }
        if ($numeroCarnet == '') {
            $numeroCarnet = null;
        }
        if ($cedula == '') {
            $cedulaEmpleado = null;
        }
        $data_json = [
            'exito' => false, // Inicializamos a false por defecto
            'mensaje' => '',
            'resultado' => 0,
        ];

        $parametro = [$cedulaEmpleado];
        $check_empleado = $this->getExisteEmpleado_datos($parametro);
        if ($check_empleado) {
            foreach ($check_empleado as $row) {
                $id_empleado = $row['id_empleados'];
                $nombreEmpleado = $row['primerNombre'] . " " . $row['primerApellido'];
                $parametrofamili = [$idfamiliar];
                $parametrosFamilia = [
                    [
                        "campo_nombre" => "cedula",
                        "campo_marcador" => ":cedula",
                        "campo_valor" => $cedula
                    ],
                    [
                        "campo_nombre" => "primerNombre",
                        "campo_marcador" => ":primerNombre",
                        "campo_valor" => $primerNombre
                    ],
                    [
                        "campo_nombre" => "segundoNombre",
                        "campo_marcador" => ":segundoNombre",
                        "campo_valor" => $segundoNombre
                    ],
                    [
                        "campo_nombre" => "primerApellido",
                        "campo_marcador" => ":primerApellido",
                        "campo_valor" => $primerApellido
                    ],
                    [
                        "campo_nombre" => "segundoApellido",
                        "campo_marcador" => ":segundoApellido",
                        "campo_valor" => $segundoApellido
                    ],
                    [
                        "campo_nombre" => "parentesco",
                        "campo_marcador" => ":parentesco",
                        "campo_valor" => $parentesco
                    ],
                    [
                        "campo_nombre" => "edad",
                        "campo_marcador" => ":edad",
                        "campo_valor" => $edad
                    ],
                    [
                        "campo_nombre" => "anoNacimiento",
                        "campo_marcador" => ":anoNacimiento",
                        "campo_valor" => $ano
                    ],
                    [
                        "campo_nombre" => "mesNacimiento",
                        "campo_marcador" => ":mesNacimiento",
                        "campo_valor" => $mes
                    ],
                    [
                        "campo_nombre" => "diaNacimiento",
                        "campo_marcador" => ":diaNacimiento",
                        "campo_valor" => $dia
                    ],
                    [
                        "campo_nombre" => "codigoCarnet",
                        "campo_marcador" => ":codigoCarnet",
                        "campo_valor" => $numeroCarnet
                    ],
                    [
                        "campo_nombre" => "idEmpleado",
                        "campo_marcador" => ":idEmpleado",
                        "campo_valor" => $id_empleado
                    ],
                    [
                        "campo_nombre" => "tomo",
                        "campo_marcador" => ":tomo",
                        "campo_valor" => $tomo
                    ],
                    [
                        "campo_nombre" => "folio",
                        "campo_marcador" => ":folio",
                        "campo_valor" => $folio
                    ],
                    [
                        "campo_nombre" => "activo",
                        "campo_marcador" => ":activo",
                        "campo_valor" => 1
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

                // Verificar si los archivos tienen nombres diferentes
                $nombreArchivo1 = isset($_FILES[$fileInputName]) ? $_FILES[$fileInputName]['name'] : null;
                $nombreArchivo2 = isset($_FILES[$fileInputName2]) ? $_FILES[$fileInputName2]['name'] : null;

                if ($nombreArchivo1 && $nombreArchivo2 && $nombreArchivo1 === $nombreArchivo2) {
                    $data_json['exito'] = false;
                    $data_json['mensaje'] = 'Los dos archivos no pueden tener el mismo nombre.';
                } else {
                    // Crear un array con los archivos que se están subiendo
                    $archivosASubir = [];
                    if ($nombreArchivo1) {
                        $archivosASubir[] = ['input' => $fileInputName, 'dir' => $uploadDir1];
                    }
                    if ($nombreArchivo2) {
                        $archivosASubir[] = ['input' => $fileInputName2, 'dir' => $uploadDir2];
                    }

                    // Ejecutar el código de subida si hay archivos para subir
                    if (!empty($archivosASubir)) {
                        $resultados = [];
                        $existeArchivo = false;
                        // Verificar si alguno de los archivos ya existe
                        foreach ($archivosASubir as $archivo) {
                            $inputName = $archivo['input'];
                            $nombreArchivos[$inputName] = $this->fileUploader->obtenerNombreArchivo($_FILES[$inputName], $cedula);
                            $direccion = $archivo['dir'] . $nombreArchivos[$inputName]['nombre'];
                            $existeArchivoCheck = $this->fileUploader->archivoExiste2($direccion);
                            if ($existeArchivoCheck['error']) {
                                $existeArchivo = true;
                                $data_json['mensaje'] = $existeArchivoCheck['mensaje'];
                                break;
                            }
                        }
                        // Si alguno de los archivos ya existe, no subir ninguno
                        if ($existeArchivo) {
                            $data_json['exito'] = false;
                            $data_json['resultado'] = 3;
                        } else {

                            $check_exisfamiliar = $this->getExisteFamiliarID($parametrofamili);
                            if ($check_exisfamiliar) {
                                foreach ($check_exisfamiliar as $rowFamiliar) {
                                    $id_nino = $rowFamiliar['id_ninos'];
                                    $nombreFamiliar = $rowFamiliar['primerNombre'] . " " . $rowFamiliar['primerApellido'];
                                    // Si ninguno de los archivos existe, proceder con la subida
                                    foreach ($archivosASubir as $archivo) {
                                        $inputName = $archivo['input'];
                                        $direccion = $archivo['dir'] . $nombreArchivos[$inputName]['nombre'];
                                        $resultados[$inputName] = $this->fileUploader->subirArchivo($_FILES[$inputName], $cedula, $archivo['dir'], $id_empleado, $id_nino);
                                        if ($resultados[$inputName]['error']) {
                                            $data_json['mensaje'] = $resultados[$inputName]['mensaje'];
                                            $data_json['resultado'] = 3;
                                            break;
                                        }
                                    }
                                    $condicion = [
                                        "condicion_campo" => "id_ninos",
                                        "condicion_marcador" => ":id_ninos",
                                        "condicion_valor" => $id_nino
                                    ];
                                    $check_familiar = $this->getActualizar('datosFamilia', $parametrosFamilia, $condicion);

                                    if ($check_familiar) {
                                        $registrarAuditoria = $this->auditoriaController->registrarAuditoria($this->idUsuario, 'Actualizar familiar', 'El usuario ' . $this->nombreUsuario . ' Se actualizo los datos del familiar ' . $nombreFamiliar . ' asociados al empleado ' . $nombreEmpleado . '.');
                                        if ($registrarAuditoria) {
                                            $data_json['exitoAuditoria'] = true;
                                            $data_json['messengerAuditoria'] = "Auditoria registrada con exito.";
                                        } else {
                                            $data_json['exitoAuditoria'] = false;
                                            $data_json['messengerAuditoria'] = "Error al registrar la auditoria.";
                                        }
                                        $data_json['exito'] = true;
                                        $data_json['mensaje'] = "Familiar actualizado exitosamente.";
                                        $data_json['resultado'] = 2;
                                    } else {
                                        $data_json['exito'] = false;
                                        $data_json['mensaje'] = "Error al registrar el familiar.";
                                        $data_json['resultado'] = 1;
                                    }
                                    if ($nombreArchivo1) {
                                        $data_json['archivo1'] = $resultados[$fileInputName];
                                    }
                                    if ($nombreArchivo2) {
                                        $data_json['archivo2'] = $resultados[$fileInputName2];
                                    }
                                }
                            } else {
                                $data_json['exito'] = false;
                                $data_json['mensaje'] = "Los documentos fueron cargados exitosamente, pero no el familiar.";
                                $data_json['resultado'] = 1;
                            }
                        }
                    } else {
                        $check_exisfamiliar = $this->getExisteFamiliarID($parametrofamili);
                        if ($check_exisfamiliar) {
                            foreach ($check_exisfamiliar as $rowFamiliar) {
                                $id_nino = $rowFamiliar['id_ninos'];
                                $nombreFamiliar = $rowFamiliar['primerNombre'] . " " . $rowFamiliar['primerApellido'];
                                $condicion = [
                                    "condicion_campo" => "id_ninos",
                                    "condicion_marcador" => ":id_ninos",
                                    "condicion_valor" => $id_nino
                                ];
                                $check_familiar = $this->getActualizar('datosFamilia', $parametrosFamilia, $condicion);;
                                if ($check_familiar) {
                                    $registrarAuditoria = $this->auditoriaController->registrarAuditoria($this->idUsuario, 'Actualizar familiar', 'El usuario ' . $this->nombreUsuario . ' actualizo los datos del familiar ' . $nombreFamiliar . ' asociados al empleado ' . $nombreEmpleado . '.');
                                    if ($registrarAuditoria) {
                                        $data_json['exitoAuditoria'] = true;
                                        $data_json['messengerAuditoria'] = "Auditoria registrada con exito.";
                                    } else {
                                        $data_json['exitoAuditoria'] = false;
                                        $data_json['messengerAuditoria'] = "Error al registrar la auditoria.";
                                    }
                                    $data_json['exito'] = true;
                                    $data_json['mensaje'] = "Familiar Registrado Exitosamente.";
                                    $data_json['resultado'] = 2;
                                } else {
                                    $data_json['exito'] = false;
                                    $data_json['mensaje'] = "Error al registrar el familiar.";
                                    $data_json['resultado'] = 1;
                                }
                            }
                        }
                    }
                }
            }
        } else {
            $data_json['exito'] = false;
            $data_json['mensaje'] = 'No existe el empleado al que intentas asignar el familiar.';
        }

        header('Content-Type: application/json');
        echo json_encode($data_json);
    }
}
