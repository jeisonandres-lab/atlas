<?php

namespace App\Atlas\controller;

use App\Atlas\models\personalModel;
use App\Atlas\controller\fileUploaderController;
use App\Atlas\models\tablasModel;
use App\Atlas\config\App;

date_default_timezone_set("America/Caracas");

class personalController extends personalModel
{


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
        $nivelAcademico,
        $vivienda,
        $sexo,
        $idestado,
        $idMunicipio,
        $idParroquia,
        $calle,
        $numeroVivienda,
        $pisoUrba,
        $nombreUrba,
        $numeroDepa,
        $fechaING,
        $edad,
        $discapacidad,
        $FamiliarInces,
        $primerNombreFamiliar,
        $primerApellidoFamiliar,
        $cedulaFamiliar,

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
        $sexo = $this->limpiarCadena($sexo);

        $vivienda = $this->limpiarCadena($vivienda);
        $idestado = $this->limpiarCadena($idestado);
        $idMunicipio = $this->limpiarCadena($idMunicipio);
        $idParroquia = $this->limpiarCadena($idParroquia);
        $numeroVivienda = $this->limpiarCadena($numeroVivienda);
        $pisoUrba = $this->limpiarCadena($pisoUrba);

        $calle = $this->limpiarCadena($calle);
        $nombreUrba = $this->limpiarCadena($nombreUrba);
        $numeroDepa = $this->limpiarCadena($numeroDepa);

        // DATOS DE EMPLEAODS
        $idEstatus = $this->limpiarCadena($idEstatus);
        $idCargo = $this->limpiarCadena($idCargo);
        $idDependencia = $this->limpiarCadena($idDependencia);
        $idDepartamento = $this->limpiarCadena($idDepartamento);
        $telefono = $this->limpiarCadena($telefono);

        $discapacidad = $this->limpiarCadena($discapacidad);
        $FamiliarInces = $this->limpiarCadena($FamiliarInces);
        $primerNombreFamiliar = $this->limpiarCadena($primerNombreFamiliar);
        $primerApellidoFamiliar = $this->limpiarCadena($primerApellidoFamiliar);
        $cedulaFamiliar = $this->limpiarCadena($cedulaFamiliar);


        $fileInputName = 'contratoArchivo';
        $fileInputName2 = 'notacionAchivo';
        $fileInputName3 = "";
        $fileInputName4 = "";
        $fileInputName5 = 'docArchivoDis';

        $fileInputName3 = (isset($_FILES['docEstadoDerechoArchivo']) && $_FILES['docEstadoDerechoArchivo']['error'] === UPLOAD_ERR_OK) ? 'docEstadoDerechoArchivo' : '';
        $fileInputName4 = (isset($_FILES['docCasadoArchivo']) && $_FILES['docCasadoArchivo']['error'] === UPLOAD_ERR_OK) ? 'docCasadoArchivo' : '';

        if ($fileInputName == "") {
            $fileInputName = null;
        }

        if ($fileInputName2 == "") {
            $fileInputName2 = null;
        }

        if ($fileInputName3 == "") {
            $fileInputName3 = null;
        }

        if ($fileInputName4 == "") {
            $fileInputName4 = null;
        }

        if ($fileInputName5 == "") {
            $fileInputName5 = null;
        }

        $uploadDir1 = App::URL_CONTRATOS;
        $uploadDir2 = App::URL_NOTACION;
        $uploadDir3 = App::URL_ESTADODEDERECHO;
        $uploadDir4 = App::URL_MATRIMONIO;
        $uploadDir5 = App::URL_DISCAPACIDADEMPELADO;

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
                "campo_nombre" => "discapacidadPersonal",
                "campo_marcador" => ":discapacidadPersonal",
                "campo_valor" =>  $discapacidad
            ],
            [
                "campo_nombre" => "anoNacimiento",
                "campo_marcador" => ":anoNacimiento",
                "campo_valor" => $ano
            ],
            [
                "campo_nombre" => "sexo",
                "campo_marcador" => ":sexo",
                "campo_valor" => $sexo
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
                "campo_nombre" => "edadPersonal",
                "campo_marcador" => ":edadPersonal",
                "campo_valor" => $edad
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

        $check_familiar_exis = $this->existeFamiliarCedula([$cedulaFamiliar]);
        if ($check_familiar_exis) {
            $data_json = [
                'exito' => true, // Inicializamos a false por defecto
                'mensaje' => 'El familiar que se intenta registrar ya existe',
                'resultado' => 0,
            ];
        } else {
        }


        $check_exisPersonal = $this->getExistePersonalCD([$cedula]);
        if (!$check_exisPersonal) {
            // Verificar si los archivos tienen nombres diferentes
            $nombreArchivo1 = isset($_FILES[$fileInputName]) ? $_FILES[$fileInputName]['name'] : 'sin archivo';
            $nombreArchivo2 = isset($_FILES[$fileInputName2]) ? $_FILES[$fileInputName2]['name'] : 'sin archivo';
            $nombreArchivo3 = isset($_FILES[$fileInputName3]) ? $_FILES[$fileInputName3]['name'] : 'sin archivo';
            $nombreArchivo4 = isset($_FILES[$fileInputName4]) ? $_FILES[$fileInputName4]['name'] : 'sin archivo';
            $nombreArchivo5 = isset($_FILES[$fileInputName5]) ? $_FILES[$fileInputName5]['name'] : 'sin archivo';

            if ($nombreArchivo1 && $nombreArchivo2 && $nombreArchivo1 === $nombreArchivo2) {
                $data_json['exito'] = false;
                $data_json['mensaje'] = 'Los dos archivos no pueden tener el mismo nombre.';
            } else {
                // Crear un array con los archivos que se están subiendo
                $archivosASubir = [];
                if ($nombreArchivo1) {
                    $archivosASubir[] = ['input' => $fileInputName, 'dir' => $uploadDir1, 'nombreArchivo' => 'Contrato'];
                }
                if ($nombreArchivo2) {
                    $archivosASubir[] = ['input' => $fileInputName2, 'dir' => $uploadDir2, 'nombreArchivo' => 'Notacion Achivo']; // Asegúrate de definir $uploadDir2
                }
                if (!empty($fileInputName3)) {
                    $archivosASubir[] = ['input' => $fileInputName3, 'dir' => $uploadDir3, 'nombreArchivo' => 'Documento Estado De Derecho'];
                }

                if (!empty($fileInputName4)) {
                    $archivosASubir[] = ['input' => $fileInputName4, 'dir' => $uploadDir4, 'nombreArchivo' => 'Acta De Matrimonio'];
                }
                if ($nombreArchivo5) {
                    $archivosASubir[] = ['input' => $fileInputName5, 'dir' => $uploadDir5, 'nombreArchivo' => 'Acta De Discapacidad']; // Asegúrate de definir $uploadDir2
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
                            $registroAuditoria = $this->auditoriaController->registrarAuditoria(
                                $this->idUsuario,
                                'Registrar personal',
                                'El usuario ' . $this->nombreUsuario . ' ha colocado un nuevo personal en el sistema con el nombre '
                                    . $primerNombre . ' ' . $primerApellido . ' y la cedula ' . $cedula . '.'
                            );
                            if ($registroAuditoria) {
                                $check_busPersonal = $this->getreturnIDP([$cedula]);

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
                                            "campo_nombre" => "fechaING",
                                            "campo_marcador" => ":fechaING",
                                            "campo_valor" => $fechaING
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

                                    $check_regisEmpleados = $this->getRegistrar('datosempleados', $empleados_datos_reg);
                                    if ($check_regisEmpleados) {
                                        $registroAuditoria = $this->auditoriaController->registrarAuditoria(
                                            $this->idUsuario,
                                            'Registrar empleado',
                                            'El usuario ' . $this->nombreUsuario . ' ha colocado un nuevo empleado en el sistema' . $primerNombre . ' ' . $primerApellido . ' y la cedula ' . $cedula . '.'
                                        );
                                        if ($registroAuditoria) {
                                            $check_busEmpleado = $this->getreturnIDPE([$cedula]);
                                            foreach ($check_busEmpleado as $row) {
                                                $id_empleado = $row['id_empleados'];

                                                $ubicacion_empleado = [
                                                    [
                                                        "campo_nombre" => "id_empleadoUbi",
                                                        "campo_marcador" => ":id_empleadoUbi",
                                                        "campo_valor" =>  $id_empleado
                                                    ],
                                                    [
                                                        "campo_nombre" => "idEstado",
                                                        "campo_marcador" => ":idEstado",
                                                        "campo_valor" =>  $idestado
                                                    ],
                                                    [
                                                        "campo_nombre" => "idMunicipio",
                                                        "campo_marcador" => ":idMunicipio",
                                                        "campo_valor" => $idMunicipio
                                                    ],
                                                    [
                                                        "campo_nombre" => "idParroquia",
                                                        "campo_marcador" => ":idParroquia",
                                                        "campo_valor" => $idParroquia
                                                    ],
                                                    [
                                                        "campo_nombre" => "vivienda",
                                                        "campo_marcador" => ":vivienda",
                                                        "campo_valor" => $vivienda
                                                    ],
                                                    [
                                                        "campo_nombre" => "calle",
                                                        "campo_marcador" => ":calle",
                                                        "campo_valor" => $calle
                                                    ],
                                                    [
                                                        "campo_nombre" => "nombre_urb",
                                                        "campo_marcador" => ":nombre_urb",
                                                        "campo_valor" =>   $nombreUrba
                                                    ],
                                                    [
                                                        "campo_nombre" => "num_depar",
                                                        "campo_marcador" => ":num_depar",
                                                        "campo_valor" =>  $numeroDepa
                                                    ],
                                                    [
                                                        "campo_nombre" => "numVivienda",
                                                        "campo_marcador" => ":numVivienda",
                                                        "campo_valor" =>  $numeroVivienda
                                                    ],
                                                    [
                                                        "campo_nombre" => "pisoVivienda",
                                                        "campo_marcador" => ":pisoVivienda",
                                                        "campo_valor" => $pisoUrba
                                                    ],
                                                ];

                                                // Si ninguno de los archivos existe, proceder con la subida
                                                foreach ($archivosASubir as $archivo) {
                                                    $inputName = $archivo['input'];
                                                    $nombreArchivo = $archivo['nombreArchivo'];
                                                    $direccion = $archivo['dir'] . $nombreArchivos[$inputName]['nombre'];
                                                    $resultados[$inputName] = $this->fileUploader->subirArchivo($_FILES[$inputName], $cedula, $archivo['dir'], $id_empleado, null, $nombreArchivo);
                                                    if ($resultados[$inputName]['error']) {
                                                        $data_json['mensaje'] = $resultados[$inputName]['mensaje'];
                                                        $data_json['resultado'] = 3;
                                                        break;
                                                    }
                                                }

                                                if ($FamiliarInces == "si") {
                                                    $check_familiar = $this->getreturnIDP([$cedulaFamiliar]);
                                                    foreach ($check_familiar as $row) {
                                                        $registrarFamiliarInces = [
                                                            [
                                                                "campo_nombre" => "idEmpleado",
                                                                "campo_marcador" => ":idEmpleado",
                                                                "campo_valor" =>  $id_empleado
                                                            ],
                                                            [
                                                                "campo_nombre" => "idPersonal",
                                                                "campo_marcador" => ":idPersonal",
                                                                "campo_valor" =>  $row['id_personal']
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
                                                        $check_familiar = $this->getRegistrar('datosFamiliarinces',   $registrarFamiliarInces);
                                                        if ($check_familiar) {
                                                            $data_json['mensaje'] = "El familiar inces fue asignado.";
                                                        }
                                                    }
                                                } else {
                                                    if (!$cedulaFamiliar == "") {
                                                        $registrarFamiliar = [
                                                            [
                                                                "campo_nombre" => "idEmpleado",
                                                                "campo_marcador" => ":idEmpleado",
                                                                "campo_valor" =>  $id_empleado
                                                            ],
                                                            [
                                                                "campo_nombre" => "primerNombre",
                                                                "campo_marcador" => ":primerNombre",
                                                                "campo_valor" =>  $primerNombreFamiliar
                                                            ],
                                                            [
                                                                "campo_nombre" => "primerApellido",
                                                                "campo_marcador" => ":primerApellido",
                                                                "campo_valor" =>  $primerApellidoFamiliar
                                                            ],
                                                            [
                                                                "campo_nombre" => "cedula",
                                                                "campo_marcador" => ":cedula",
                                                                "campo_valor" =>  $cedulaFamiliar
                                                            ],
                                                            [
                                                                "campo_nombre" => "activo",
                                                                "campo_marcador" => ":activo",
                                                                "campo_valor" =>  3
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
                                                        $check_familiar = $this->getRegistrar('datosFamilia',  $registrarFamiliar);
                                                        if ($check_familiar) {
                                                            $data_json['mensaje'] = "El familiar fue asignado.";
                                                        }
                                                    }
                                                }

                                                // imprimir los archivos que si se envian porque son obligatorio
                                                if ($nombreArchivo1) {
                                                    $data_json['archivo1'] = $resultados[$fileInputName];
                                                }
                                                if ($nombreArchivo2) {
                                                    $data_json['archivo2'] = $resultados[$fileInputName2];
                                                }

                                                if ($nombreArchivo5) {
                                                    $data_json['archivo5'] = $resultados[$fileInputName5];
                                                }

                                                // datos que no se registran ya que no son enviados
                                                if (!empty($fileInputName3)) {
                                                    $data_json['archivo3'] = $resultados[$fileInputName3];
                                                }

                                                if (!empty($fileInputName4)) {
                                                    $data_json['archivo4'] = $resultados[$fileInputName4];
                                                }
                                                $check_regisUbicacionEmpleado = $this->getRegistrar('ubicacion',  $ubicacion_empleado);
                                                if ($check_regisUbicacionEmpleado) {
                                                    $data_json['exito'] = true;
                                                    $data_json['mensaje'] = "Empleado Registrado Exitosamente.";
                                                    $data_json['resultado'] = 2;
                                                    $datos_json["exitoAuditoria"] = true;
                                                    $datos_json['messengerAuditoria'] = "Auditoria registrada con exito.";
                                                } else {
                                                    $data_json['exito'] = false;
                                                    $data_json['mensaje'] = "no se logro registrar la ubicación, pero el empleado ha sido registrado con exito";
                                                    $data_json['resultado'] = 1;
                                                }
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

    public function registrarDatosPersonal(
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
        $discapacidad,
        $sexo,
        $edad
    ) {
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
                "campo_nombre" => "discapacidadPersonal",
                "campo_marcador" => ":discapacidadPersonal",
                "campo_valor" =>  $discapacidad
            ],
            [
                "campo_nombre" => "anoNacimiento",
                "campo_marcador" => ":anoNacimiento",
                "campo_valor" => $ano
            ],
            [
                "campo_nombre" => "sexo",
                "campo_marcador" => ":sexo",
                "campo_valor" => $sexo
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
                "campo_nombre" => "edadPersonal",
                "campo_marcador" => ":edadPersonal",
                "campo_valor" => $edad
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
        $check_regisPersonal = $this->getRegistrar('datospersonales', $personal_datos_reg);
        if ($check_regisPersonal) {
            // Registrar auditoría
            $registroAuditoria = $this->auditoriaController->registrarAuditoria(
                $this->idUsuario,
                'Registrar Personal',
                'El usuario ' . $this->nombreUsuario . ' ha colocado un nuevo personal al sistema: ' . $primerNombre . ' ' . $primerApellido . ' con la cédula ' . $cedula . '.'
            );

            if ($registroAuditoria) {
                $data_json['auditoriaPersonal'] = "El registro del personal se logró.";
            }

            return true;
        } else {
            return false;
        }
    }

    public function registrarDatosEmpleado(
        $primerNombre,
        $primerApellido,
        $cedula,
        $idEstatus,
        $idCargo,
        $idDependencia,
        $idDepartamento,
        $telefono,
        $idPersonal,
        $nivelAcademico,
        $fechaING
    ) {
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
                "campo_nombre" => "fechaING",
                "campo_marcador" => ":fechaING",
                "campo_valor" => $fechaING
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

        // Intentar registrar los datos del empleado
        $check_regisEmpleados = $this->getRegistrar('datosempleados', $empleados_datos_reg);
        if ($check_regisEmpleados) {
            // Registrar auditoría
            $registroAuditoria = $this->auditoriaController->registrarAuditoria(
                $this->idUsuario,
                'Registrar empleado',
                'El usuario ' . $this->nombreUsuario . ' ha colocado un nuevo empleado en el sistema: ' . $primerNombre . ' ' . $primerApellido . ' con la cédula ' . $cedula . '.'
            );

            if ($registroAuditoria) {
                $data_json['auditoriaEmpleado'] = "El registro del empleado se logró.";
            }

            return true;
        } else {
            return false;
        }
    }

    public function registrarUbicacionEmpleado(
        $id_empleado,
        $idestado,
        $idMunicipio,
        $idParroquia,
        $calle,
        $numeroVivienda,
        $pisoUrba,
        $nombreUrba,
        $numeroDepa,
        $vivienda,
        $primerNombre,
        $primerApellido,
        $cedula
    ) {
        $ubicacion_empleado = [
            [
                "campo_nombre" => "id_empleadoUbi",
                "campo_marcador" => ":id_empleadoUbi",
                "campo_valor" =>  $id_empleado
            ],
            [
                "campo_nombre" => "idEstado",
                "campo_marcador" => ":idEstado",
                "campo_valor" =>  $idestado
            ],
            [
                "campo_nombre" => "idMunicipio",
                "campo_marcador" => ":idMunicipio",
                "campo_valor" => $idMunicipio
            ],
            [
                "campo_nombre" => "idParroquia",
                "campo_marcador" => ":idParroquia",
                "campo_valor" => $idParroquia
            ],
            [
                "campo_nombre" => "vivienda",
                "campo_marcador" => ":vivienda",
                "campo_valor" => $vivienda
            ],
            [
                "campo_nombre" => "calle",
                "campo_marcador" => ":calle",
                "campo_valor" => $calle
            ],
            [
                "campo_nombre" => "nombre_urb",
                "campo_marcador" => ":nombre_urb",
                "campo_valor" =>   $nombreUrba
            ],
            [
                "campo_nombre" => "num_depar",
                "campo_marcador" => ":num_depar",
                "campo_valor" =>  $numeroDepa
            ],
            [
                "campo_nombre" => "numVivienda",
                "campo_marcador" => ":numVivienda",
                "campo_valor" =>  $numeroVivienda
            ],
            [
                "campo_nombre" => "pisoVivienda",
                "campo_marcador" => ":pisoVivienda",
                "campo_valor" => $pisoUrba
            ],
        ];
        $check_regisUbicacionEmpleado = $this->getRegistrar('ubicacion',  $ubicacion_empleado);
        if ($check_regisUbicacionEmpleado) {
            // Registrar auditoría
            $registroAuditoria = $this->auditoriaController->registrarAuditoria(
                $this->idUsuario,
                'Registrar Ubicacion del Empleado',
                'El usuario ' . $this->nombreUsuario . ' ha registrado la ubicacion a ' . $primerNombre . ' ' . $primerApellido . ' con la cédula ' . $cedula . '.'
            );

            if ($registroAuditoria) {
                $data_json['auditoriaPersonal'] = "El registro de la unicacion para el empleado se logro.";
            }

            return true;
        } else {
            return false;
        }
    }

    public function registrarArchivos($cedula, $id_empleado)
    {
        $fileInputName = 'contratoArchivo';
        $fileInputName2 = 'notacionAchivo';
        $fileInputName3 = "";
        $fileInputName4 = "";
        $fileInputName5 = 'docArchivoDis';

        $fileInputName3 = (isset($_FILES['docEstadoDerechoArchivo']) && $_FILES['docEstadoDerechoArchivo']['error'] === UPLOAD_ERR_OK) ? 'docEstadoDerechoArchivo' : '';
        $fileInputName4 = (isset($_FILES['docCasadoArchivo']) && $_FILES['docCasadoArchivo']['error'] === UPLOAD_ERR_OK) ? 'docCasadoArchivo' : '';

        if ($fileInputName == "") {
            $fileInputName = null;
        }

        if ($fileInputName2 == "") {
            $fileInputName2 = null;
        }

        if ($fileInputName3 == "") {
            $fileInputName3 = null;
        }

        if ($fileInputName4 == "") {
            $fileInputName4 = null;
        }

        if ($fileInputName5 == "") {
            $fileInputName5 = null;
        }

        $uploadDir1 = App::URL_CONTRATOS;
        $uploadDir2 = App::URL_NOTACION;
        $uploadDir3 = App::URL_ESTADODEDERECHO;
        $uploadDir4 = App::URL_MATRIMONIO;
        $uploadDir5 = App::URL_DISCAPACIDADEMPELADO;

        $nombreArchivo1 = isset($_FILES[$fileInputName]) ? $_FILES[$fileInputName]['name'] : 'sin archivo';
        $nombreArchivo2 = isset($_FILES[$fileInputName2]) ? $_FILES[$fileInputName2]['name'] : 'sin archivo';
        $nombreArchivo3 = isset($_FILES[$fileInputName3]) ? $_FILES[$fileInputName3]['name'] : 'sin archivo';
        $nombreArchivo4 = isset($_FILES[$fileInputName4]) ? $_FILES[$fileInputName4]['name'] : 'sin archivo';
        $nombreArchivo5 = isset($_FILES[$fileInputName5]) ? $_FILES[$fileInputName5]['name'] : 'sin archivo';

        // Crear un array con los archivos que se están subiendo
        $archivosASubir = [];
        if ($nombreArchivo1) {
            $archivosASubir[] = ['input' => $fileInputName, 'dir' => $uploadDir1, 'nombreArchivo' => 'Contrato'];
        }
        if ($nombreArchivo2) {
            $archivosASubir[] = ['input' => $fileInputName2, 'dir' => $uploadDir2, 'nombreArchivo' => 'Notacion Achivo']; // Asegúrate de definir $uploadDir2
        }
        if (!empty($fileInputName3)) {
            $archivosASubir[] = ['input' => $fileInputName3, 'dir' => $uploadDir3, 'nombreArchivo' => 'Documento Estado De Derecho'];
        }

        if (!empty($fileInputName4)) {
            $archivosASubir[] = ['input' => $fileInputName4, 'dir' => $uploadDir4, 'nombreArchivo' => 'Acta De Matrimonio'];
        }
        if ($nombreArchivo5) {
            $archivosASubir[] = ['input' => $fileInputName5, 'dir' => $uploadDir5, 'nombreArchivo' => 'Acta De Discapacidad']; // Asegúrate de definir $uploadDir2
        }

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

        if ($existeArchivo) {
            $data_json['exito'] = false;
            $data_json['resultado'] = 3;
        }else{
            // Si ninguno de los archivos existe, proceder con la subida
            foreach ($archivosASubir as $archivo) {
                $inputName = $archivo['input'];
                $nombreArchivo = $archivo['nombreArchivo'];
                $direccion = $archivo['dir'] . $nombreArchivos[$inputName]['nombre'];
                $resultados[$inputName] = $this->fileUploader->subirArchivo($_FILES[$inputName], $cedula, $archivo['dir'], $id_empleado, null, $nombreArchivo);
                if ($resultados[$inputName]['error']) {
                    $data_json['mensaje'] = $resultados[$inputName]['mensaje'];
                    $data_json['resultado'] = 3;
                    break;
                }
            }
        }
    }

    public function registrarFamiliarInces(
        $FamiliarInces,
        $primerNombreFamiliar,
        $primerApellidoFamiliar,
        $cedulaFamiliar,
        $id_empleado
    ){
        if ($FamiliarInces == "si") {
            $check_familiar = $this->getreturnIDP([$cedulaFamiliar]);
            foreach ($check_familiar as $row) {
                $registrarFamiliarInces = [
                    [
                        "campo_nombre" => "idEmpleado",
                        "campo_marcador" => ":idEmpleado",
                        "campo_valor" =>  $id_empleado
                    ],
                    [
                        "campo_nombre" => "idPersonal",
                        "campo_marcador" => ":idPersonal",
                        "campo_valor" =>  $row['id_personal']
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
                $check_familiar = $this->getRegistrar('datosFamiliarinces',   $registrarFamiliarInces);
                if ($check_familiar) {
                    $data_json['mensaje'] = "El familiar inces fue asignado.";
                }
            }
        } else {
            if (!$cedulaFamiliar == "") {
                $registrarFamiliar = [
                    [
                        "campo_nombre" => "idEmpleado",
                        "campo_marcador" => ":idEmpleado",
                        "campo_valor" =>  $id_empleado
                    ],
                    [
                        "campo_nombre" => "primerNombre",
                        "campo_marcador" => ":primerNombre",
                        "campo_valor" =>  $primerNombreFamiliar
                    ],
                    [
                        "campo_nombre" => "primerApellido",
                        "campo_marcador" => ":primerApellido",
                        "campo_valor" =>  $primerApellidoFamiliar
                    ],
                    [
                        "campo_nombre" => "cedula",
                        "campo_marcador" => ":cedula",
                        "campo_valor" =>  $cedulaFamiliar
                    ],
                    [
                        "campo_nombre" => "activo",
                        "campo_marcador" => ":activo",
                        "campo_valor" =>  3
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
                $check_familiar = $this->getRegistrar('datosFamilia',  $registrarFamiliar);
                if ($check_familiar) {
                    $data_json['mensaje'] = "El familiar fue asignado.";
                }
            }
        }

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
        $folio,
        $discapacidad,
        $sexo
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
        $discapacidad = $this->limpiarCadena($discapacidad);
        $sexo = $this->limpiarCadena($sexo);

        if ($numeroCarnet == "") {
            $numeroCarnet = null;
        }

        if ($discapacidad == "") {
            $discapacidad = null;
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

        $parametro = [$cedulaEmpleado, $cedulaEmpleado . "%"];
        if ($cedula == '') {
            $noCedulaFamiliar = $this->retornaNoCedula($parametro);
            if (empty($noCedulaFamiliar)) {
                $cedula = $cedulaEmpleado . "001";
            } else {
                $cedula = intval($noCedulaFamiliar[0]['cedula']) + 1;
            }
        }

        if ($fileInputName == "") {
            $fileInputName = null;
        }

        if ($fileInputName2 == "") {
            $fileInputName2 = null;
        }

        $check_empleado = $this->getTotalDatosPE([$cedulaEmpleado]);
        if ($check_empleado) {
            foreach ($check_empleado as $row) {

                $id_empleado = $row['id_empleados'];
                $nombreEmpleado = $row['primerNombre'];
                $apellidoEmpleado = $row['primerApellido'];
                $id_nino = $check_empleado;

                $parametrofamili = [$cedula, $tomo, $folio];

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
                        "campo_nombre" => "discapacidad",
                        "campo_marcador" => ":discapacidad",
                        "campo_valor" => $discapacidad
                    ],
                    [
                        "campo_nombre" => "sexoFamiliar",
                        "campo_marcador" => ":sexoFamiliar",
                        "campo_valor" => $sexo
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

                $parametro_registrar = $parametrosFamilia;
                $check_familiar_exis = $this->getExisteFamilar($parametrofamili);

                if ($check_familiar_exis) {
                    $data_json['exito'] = true;
                    $data_json['mensaje'] = $check_familiar_exis['mensaje'];
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
                            $archivosASubir[] = ['input' => $fileInputName, 'dir' => $uploadDir1, 'nombreArchivo' => 'Partida Nacimiento'];
                        }
                        if ($nombreArchivo2) {
                            $archivosASubir[] = ['input' => $fileInputName2, 'dir' => $uploadDir2, 'nombreArchico' => 'Partida Discapacidad']; // Asegúrate de definir $uploadDir2
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

                                    $check_familiar = $this->getRegistrar('datosFamilia', $parametro_registrar);

                                    if ($check_familiar) {

                                        $registroAuditoria = $this->auditoriaController->registrarAuditoria($this->idUsuario, 'Registrar familiar', 'El usuario ' . $this->nombreUsuario . ' asigno un nuevo familiar en el sistema al empleado ' . $nombreEmpleado . ' ' . $apellidoEmpleado . ' portador de la cedula ' . $cedulaEmpleado . ' el familiar asignado fue ' . $primerNombre . ' ' . $primerApellido . '.');

                                        if ($registroAuditoria) {
                                            $data_json["exitoAuditoria"] = true;
                                            $data_json['messengerAuditoria'] = "Auditoria registrada con exito.";
                                        } else {
                                            $data_json["exitoAuditoria"] = false;
                                            $data_json['messengerAuditoria'] = "Error al registrar la auditoria.";
                                        }

                                        $check_exisfamiliar = $this->getExisteFamilar($parametrofamili);
                                        foreach ($check_exisfamiliar['datos'] as $row) {
                                            $id_nino = $row['id_ninos'];
                                            // Si ninguno de los archivos existe, proceder con la subida
                                            foreach ($archivosASubir as $archivo) {
                                                $inputName = $archivo['input'];
                                                $nombreArchivoDoc = $archivo['nombreArchivo'];

                                                $direccion = $archivo['dir'] . $nombreArchivos[$inputName]['nombre'];
                                                $resultados[$inputName] = $this->fileUploader->subirArchivo($_FILES[$inputName], $cedula, $archivo['dir'], $id_empleado, $id_nino, $nombreArchivoDoc);
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
                                            $data_json['mensaje'] = "Familiar Registrado Exitosamente.";
                                            $data_json['resultado'] = 2;
                                        }
                                    } else {
                                        $data_json['exito'] = false;
                                        $data_json['mensaje'] = "Los documentos fueron cargados exitosamente, pero no el familiar.";
                                        $data_json['resultado'] = 1;
                                    }
                                }
                            } else {
                                // Si no hay archivos para subir, registrar el familiar sin archivos
                                $check_familiar = $this->getRegistrar('datosFamilia', $parametro_registrar);
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
            $data_json['mensaje'] = 'No existe el empleado al que intentas asignar el familiar.';
        }

        header('Content-Type: application/json');
        echo json_encode($data_json);
    }

    //Obtener todos los datos de personal
    public function obtenerDatosPersonal(
        string $cedualEmpleado
    ) {
        $cedualEmpleado = $this->limpiarCadena($cedualEmpleado);
        $data_json = [
            'exito' => false, // Inicializamos a false por defecto
            'mensaje' => 'data del principio',
        ];
        if ($cedualEmpleado == "") {
            $data_json['exito'] = true;
            $data_json['mensaje'] = "Debes de llenar el campo de la Cédula para hacer la busqueda del empleado";
            $data_json['logrado'] = false;
        } else {

            $check_personal = $this->getTotalDatosCDEmpleados([$cedualEmpleado]);
            if ($check_personal == true) {
                foreach ($check_personal as $row) {
                    $nivelacademico = ucfirst($row['nivelAcademico']);
                    $nombre = ucfirst($row['primerNombre']);
                    $segundoNombre = ucfirst($row['segundoNombre']);
                    $apellido = ucfirst($row['primerApellido']);
                    $segundoApellido = ucfirst($row['segundoApellido']);
                    $estadoCivil = ucfirst($row['estadoCivil']);
                    $estatus = ucfirst($row['estatus']);
                    $cargo = ucfirst($row['cargo']);
                    $dependencia = ucfirst($row['dependencia']);
                    $departamento = ucfirst($row['departamento']);
                    $sexo = ucfirst($row['sexo']);

                    $municipio = ucfirst($row['municipio']);
                    $parroquia = ucfirst($row['parroquia']);
                    $calle = ucfirst($row['calle']);
                    $vivienda = ucfirst($row['vivienda']);
                    $nombre_urb = ucfirst($row['nombre_urb']);

                    $activo = $row['activo'] == 1 ? 'Activo' : 'Inactivo';
                    $data_json['activo'] = $activo;
                    $data_json['exito'] = true;
                    $data_json['idPersonal'] = $row['id_personal'];
                    $data_json['idestatus'] = $row['id_estatus'];
                    $data_json['idEmpleado'] = $row['id_empleados'];
                    $data_json['iddepartamento'] = $row['id_departamento'];
                    $data_json['idcargo'] = $row['id_cargo'];
                    $data_json['iddependencia'] = $row['id_dependencia'];
                    $data_json['cedula'] = $row['cedula'];

                    $data_json['nombre'] = $nombre;
                    $data_json['segundoNombre'] = $segundoNombre;
                    $data_json['apellido'] = $apellido;
                    $data_json['segundoApellido'] = $segundoApellido;
                    $data_json['estadoCivil'] = $estadoCivil;
                    $data_json['estatus'] = $estatus;
                    $data_json['cargo'] = $cargo;
                    $data_json['dependencia'] = $dependencia;
                    $data_json['departamento'] = $departamento;
                    $data_json['sexo'] = $sexo;
                    $data_json['nivelAcademico'] = $nivelacademico;

                    $data_json['diaNacimiento'] = $row['diaNacimiento'];
                    $data_json['mesNacimiento'] = $row['mesNacimiento'];
                    $data_json['anoNacimiento'] = $row['anoNacimiento'];
                    $data_json['telefono'] = $row['telefono'];
                    $data_json['edad'] = $row['edadPersonal'];
                    $data_json['fechaing'] = $row['fechaING'];

                    //ubicacion de personal
                    $data_json['idEstado'] = $row['idEstado'];
                    $data_json['estado'] = $row['estado'];
                    $data_json['idMunicipio'] = $row['idMunicipio'];
                    $data_json['idParroquia'] = $row['idParroquia'];

                    $data_json['municipio'] = $municipio;
                    $data_json['parroquia'] = $parroquia;
                    $data_json['calle'] = $calle;
                    $data_json['vivienda'] = $vivienda;
                    $data_json['nombre_urb'] = $nombre_urb;

                    $data_json['numVivienda'] = $row['numVivienda'];
                    $data_json['num_depar'] = $row['num_depar'];
                    $data_json['pisoVivienda'] = $row['pisoVivienda'];


                    $data_json['mensaje'] = "Trabajador Encontrado";
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
            $check_familiar = $this->getDatosFamiliarID([$idPersonal]);
            if ($check_familiar) {
                foreach ($check_familiar as $row) {
                    $data_json['exito'] = true;
                    $data_json['idEmpleado'] = $row['idEmpleado'];
                    $data_json['cedulaEmpleado'] = $row['cedulaEmpleado'];
                    $data_json['nombreEmpleado'] = ucfirst($row['primerNombreEmpleado']);
                    $data_json['apellidoEmpleado'] = ucfirst($row['primerApellidoEmpleado']);

                    $data_json['idfamiliar'] = $row['id_ninos'];
                    $data_json['cedula'] = $row['cedula'];
                    $data_json['nombre'] = ucfirst($row['primerNombre']);
                    $data_json['segundoNombre'] = ucfirst($row['segundoNombre']);
                    $data_json['apellido'] = ucfirst($row['primerApellido']);
                    $data_json['segundoApellido'] = ucfirst($row['segundoApellido']);
                    $data_json['parentesco'] = ucfirst($row['parentesco']);
                    $data_json['edad'] = $row['edad'];
                    $data_json['anoNacimiento'] = $row['anoNacimiento'];
                    $data_json['mesNacimiento'] = $row['mesNacimiento'];
                    $data_json['diaNacimiento'] = $row['diaNacimiento'];
                    $data_json['codigoCarnet'] = $row['codigoCarnet'];
                    $data_json['tomo'] = $row['tomo'];
                    $data_json['folio'] = $row['folio'];
                    $data_json['sexoFamiliar'] = ucfirst($row['sexoFamiliar']);
                    $data_json['discapacidad'] = ucfirst($row['discapacidad']);
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

    //Obtener todos los datos de personal para la tabla
    public function obtenerTodoPersonal()
    {
        $data_json['data'] = []; // Array de datos para enviar
        $tabla = 'datosempleados e
              INNER JOIN datospersonales d ON e.idPersonal = d.id_personal
              INNER JOIN estatus es ON e.idEstatus = es.id_estatus
              INNER JOIN cargo ca ON e.idCargo = ca.id_cargo
              INNER JOIN dependencia depe ON e.idDependencia = depe.id_dependencia
              INNER JOIN departamento depa ON e.idDepartamento = depa.id_departamento
              INNER JOIN ubicacion ubi ON e.id_empleados = ubi.id_empleadoUbi
              INNER JOIN estados est ON ubi.idEstado = est.id_estado
              INNER JOIN municipios m ON ubi.idMunicipio = m.id_municipio
              INNER JOIN parroquias p ON ubi.idParroquia = p.id_parroquia
              '; // Tabla a consultar
        $selectoresCantidad = 'COUNT(e.idPersonal) as cantidad'; // Selector para contar la cantidad de registros de la tabla
        $datosBuscar = ['depe.dependencia', 'd.primerNombre', 'd.cedula', 'ca.cargo']; // Array de selectores para buscar en la tabla
        $campoOrden = 'e.idPersonal'; // Campo por el cual se ordenará la tabla
        $selectores = '*, DATE_FORMAT(fechaING, "%d-%m-%Y") AS fechaCreada'; // Selectores para obtener los datos de la tabla
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
            $validarFamiliar = $this->getDatosFamiliarEmpleadoID($parametro);
            $botones = "

                <button class='btn btn-primary btn-sm btn-hover-azul btnEditar '  data-cedula=" . $row['cedula'] . "><i class='fa-solid fa-pencil fa-sm me-2'></i>Editar</button>
                <button class='btn btn-danger btn-sm btn-hover-rojo btnEliminar ' data-swal-toast-template='#my-template' data-id=" . $row['id_empleados'] . "><i class='fa-solid fa-trash fa-sm me-2'></i>Eliminar</button>
                ";

            if ($validarFamiliar) {
                $botones .= "<button class='btn btn-warning btn-sm btn-familiar btn-hover-amarillo ' data-swal-toast-template='#my-template' data-id=" . $row['id_empleados'] . "><i class='fa-duotone fa-solid fa-people-group fa-sm me-2'></i>Familiar</button>";
            }

            if ($row['pisoVivienda'] == null) {
                $info = "";
            } else {
                $info = "piso" . "-";
            }
            $nivelacademico = ucfirst($row['nivelAcademico']);
            $nombre = ucfirst($row['primerNombre']);
            $segundoNombre = ucfirst($row['segundoNombre']);
            $apellido = ucfirst($row['primerApellido']);
            $segundoApellido = ucfirst($row['segundoApellido']);
            $estadoCivil = ucfirst($row['estadoCivil']);
            $estatus = ucfirst($row['estatus']);
            $cargo = ucfirst($row['cargo']);
            $dependencia = ucfirst($row['dependencia']);
            $departamento = ucfirst($row['departamento']);
            $sexo = ucfirst($row['sexo']);

            $municipio = ucfirst($row['municipio']);
            $parroquia = ucfirst($row['parroquia']);
            $calle = ucfirst($row['calle']);
            $vivienda = ucfirst($row['vivienda']);
            $nombre_urb = ucfirst($row['nombre_urb']);

            $data_json['data'][] = [
                '0' =>  $nombre . " " . $segundoNombre,
                '1' => $apellido  . " " . $segundoApellido,
                '2' => $row['diaNacimiento'] . "-" . $row['mesNacimiento'] . "-" . $row['anoNacimiento'],
                '3' => $row['cedula'],
                '4' => $estadoCivil,
                '5' =>  $estatus,
                '6' => $cargo,
                '7' => $dependencia,
                '8' => $departamento,
                '9' => $nivelacademico,
                '10' => $row['telefono'],
                '11' => $row['fechaCreada'],
                '12' => $sexo,
                '13' => $row['vivienda'],
                '14' =>  $row['estado'],
                '15' => $municipio,
                '16' => $parroquia,
                '17' =>  $calle . " " . $nombre_urb . " " .  $vivienda . " " . $row['numVivienda'] . " " . $row['num_depar'] . " " . $info . $row['pisoVivienda'] . " ",
                '18' => $botones
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
            // $validarFamiliar = $this->getExisteEmpleadoFamiliar($parametro);
            // $botones = "
            //     <button class='btn btn-primary btn-sm btn-hover-azul btnEditarFamiliar ' data-bs-toggle='modal' data-bs-target='#editarDatosFamiliar' data-cedula=" . $row['id_ninos'] . "><i class='fa-solid fa-pencil fa-sm me-2'></i>Editar</button>
            //     <button class='btn btn-danger btn-sm btn-hover-rojo btnEliminar'  data-swal-toast-template='#my-template' data-id=" . $row['id_ninos'] .  "><i class='fa-solid fa-trash fa-sm me-2'></i>Eliminar</button>
            // ";

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
                '6' => $botonDoc,
                '7' => 1,
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
    public function obtenerFamiliarTotal()
    {
        $data_json['data'] = []; // Array de datos para enviar
        $tabla = 'datosfamilia df INNER JOIN datosempleados de ON df.idEmpleado = de.id_empleados INNER JOIN datospersonales p ON de.idPersonal = p.id_personal'; // Tabla a consultar
        $selectoresCantidad = 'COUNT(id_ninos) as cantidad'; // Selector para contar la cantidad de registros de la tabla
        $datosBuscar = []; // Array de selectores para buscar en la tabla
        $campoOrden = ' df.id_ninos'; // Campo por el cual se ordenará la tabla
        $selectores = '*, df.primerNombre AS primerNombreFamiliar, df.primerApellido AS primerApellidoFamiliar, p.primerNombre AS primerNombreEmpleado, p.primerApellido AS primerApellidoEmpleado, df.discapacidad AS discapacidadFamiliar'; // Selectores para obtener los datos de la tabla
        $conditions = [" df.activo = ?"];
        $conditionParams = ['1'];

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
            $parametro3 = $row['id_ninos'];
            $tabla2 = 'documentacion'; // Tabla a consultar
            $campoOrden2 = 'idNinos'; // Campo por el cual se ordenará la tabla
            $selectores2 = '*'; // Selectores para obtener los datos de la tabla
            $conditions2 = ["idNinos = ?"];
            $conditionParams2 = [$parametro3];

            $validarDocumentos = $this->tablas->tablas($selectores2, $tabla2, $campoOrden2, $conditions2, $conditionParams2);
            // $validarFamiliar = $this->getExisteEmpleadoFamiliar($parametro);
            $botones = "
                <button class='btn btn-primary btn-sm btn-hover-azul btnEditarFamiliar ' data-cedula=" . $row['id_ninos'] . "><i class='fa-solid fa-pencil fa-sm me-2'></i>Editar</button>
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
                '0' => $row['primerNombreEmpleado'] . " " . $row['primerApellidoEmpleado'],
                '1' => $row['primerNombreFamiliar'] . " " . $row['primerApellidoFamiliar'],
                '2' => $row['cedula'],
                '3' => $row['sexoFamiliar'],
                '4' => $row['codigoCarnet'],
                '5' => $row['discapacidadFamiliar'],
                '6' => $row['edad'],
                '7' => $row['tomo'],
                '8' => $row['folio'],
                '9' => $botones,
                '10' => $botonDoc,
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

    //Eliminar personal empleado
    public function eliminarEmpleado($idEmpleado)
    {
        $idEmpleado = $this->limpiarCadena($idEmpleado);
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
            "condicion_valor" => $idEmpleado
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
            $data_json['mensaje'] = 'Eliminado correctamente.';
        } else {
            $data_json['exito'] = false;
            $data_json['mensaje'] = 'Error al eliminar al familiar.';
        }

        header('Content-Type: application/json');
        echo json_encode($data_json);
    }

    //Actualizar personal empleado
    public function actualizarPersonal(
        $idPersonal,
        $idEmpleado,
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
        $nivelAcademico,
        $vivienda,
        $sexo,
        $idestado,
        $idMunicipio,
        $idParroquia,
        $calle,
        $numeroVivienda,
        $pisoUrba,
        $nombreUrba,
        $numeroDepa,
        $fechaING
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
        $nivelAcademico = $this->limpiarCadena($nivelAcademico);
        $sexo = $this->limpiarCadena($sexo);

        //Ubicacion
        $vivienda = $this->limpiarCadena($vivienda);
        $idestado = $this->limpiarCadena($idestado);
        $idMunicipio = $this->limpiarCadena($idMunicipio);
        $idParroquia = $this->limpiarCadena($idParroquia);
        $numeroVivienda = $this->limpiarCadena($numeroVivienda);
        $pisoUrba = $this->limpiarCadena($pisoUrba);
        $calle = $this->limpiarCadena($calle);
        $nombreUrba = $this->limpiarCadena($nombreUrba);
        $numeroDepa = $this->limpiarCadena($numeroDepa);

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
        $condicion_personal = [
            "condicion_campo" => "id_personal",
            "condicion_marcador" => ":id_personal",
            "condicion_valor" =>  $idPersonal
        ];

        $condicion_empleado = [
            "condicion_campo" => "id_empleados",
            "condicion_marcador" => ":id_empleados",
            "condicion_valor" => $idEmpleado
        ];

        $condicion_empleadoUbi = [
            "condicion_campo" => "id_empleadoUbi",
            "condicion_marcador" => ":id_empleadoUbi",
            "condicion_valor" => $idEmpleado
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
                "campo_nombre" => "sexo",
                "campo_marcador" => ":sexo",
                "campo_valor" => $sexo
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
                "campo_nombre" => "fechaING",
                "campo_marcador" => ":fechaING",
                "campo_valor" => $fechaING
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
                $archivosASubir[] = ['input' => $fileInputName, 'dir' => $uploadDir1, 'nombreArchivo' => 'contrato'];
            }
            if ($nombreArchivo2) {
                $archivosASubir[] = ['input' => $fileInputName2, 'dir' => $uploadDir2, 'nombreArchivo' => 'Notacion']; // Asegúrate de definir $uploadDir2
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
                    $viejosDatos = $this->getTotalDatosPEID([$idPersonal]);
                    foreach ($viejosDatos as $row) {
                        $check_regisPersonal = $this->getActualizar('datospersonales', $personal_datos_reg,  $condicion_personal);
                        if ($check_regisPersonal) {

                            $registroAuditoria = $this->auditoriaController->registrarAuditoria($this->idUsuario, 'Actualizar personal', 'El usuario ' . $this->nombreUsuario . ' actualizo los datos del personal con cedula ' . $cedula . '.');
                            $check_regisEmpleados = $this->getActualizar('datosempleados', $empleados_datos_reg,  $condicion_empleado);
                            if ($check_regisEmpleados) {
                                $registroAuditoria = $this->auditoriaController->registrarAuditoria($this->idUsuario, 'Actualizar empleado', 'El usuario ' . $this->nombreUsuario . ' actualizo los datos del empleado con cedula ' . $cedula . '.');

                                $check_busEmpleado = $this->getTotalDatosPEID([$idPersonal]);
                                foreach ($check_busEmpleado as $row) {
                                    $id_empleado = $row['id_empleados'];
                                    // Si ninguno de los archivos existe, proceder con la subida
                                    foreach ($archivosASubir as $archivo) {
                                        $inputName = $archivo['input'];
                                        $direccion = $archivo['dir'] . $nombreArchivos[$inputName]['nombre'];
                                        $nombreArchivodoc =  $archivo['nombreArchivo'];
                                        $resultados[$inputName] = $this->fileUploader->subirArchivo($_FILES[$inputName], $cedula, $archivo['dir'], $id_empleado, null, $nombreArchivodoc);
                                        if ($resultados[$inputName]['error']) {
                                            $data_json['mensaje'] = $resultados[$inputName]['mensaje'];
                                            $data_json['resultado'] = 3;
                                            break;
                                        }
                                    }

                                    $ubicacion_empleado = [
                                        [
                                            "campo_nombre" => "idEstado",
                                            "campo_marcador" => ":idEstado",
                                            "campo_valor" =>  $idestado
                                        ],
                                        [
                                            "campo_nombre" => "idMunicipio",
                                            "campo_marcador" => ":idMunicipio",
                                            "campo_valor" => $idMunicipio
                                        ],
                                        [
                                            "campo_nombre" => "idParroquia",
                                            "campo_marcador" => ":idParroquia",
                                            "campo_valor" => $idParroquia
                                        ],
                                        [
                                            "campo_nombre" => "vivienda",
                                            "campo_marcador" => ":vivienda",
                                            "campo_valor" => $vivienda
                                        ],
                                        [
                                            "campo_nombre" => "calle",
                                            "campo_marcador" => ":calle",
                                            "campo_valor" => $calle
                                        ],
                                        [
                                            "campo_nombre" => "nombre_urb",
                                            "campo_marcador" => ":nombre_urb",
                                            "campo_valor" =>   $nombreUrba
                                        ],
                                        [
                                            "campo_nombre" => "num_depar",
                                            "campo_marcador" => ":num_depar",
                                            "campo_valor" =>  $numeroDepa
                                        ],
                                        [
                                            "campo_nombre" => "numVivienda",
                                            "campo_marcador" => ":numVivienda",
                                            "campo_valor" =>  $numeroVivienda
                                        ],
                                        [
                                            "campo_nombre" => "pisoVivienda",
                                            "campo_marcador" => ":pisoVivienda",
                                            "campo_valor" => $pisoUrba
                                        ],
                                    ];

                                    $check_actUbicacionEmpleado = $this->getActualizar('ubicacion', $ubicacion_empleado, $condicion_empleadoUbi);
                                    if ($check_actUbicacionEmpleado) {
                                        $data_json['exito'] = true;
                                        $data_json['mensaje'] = "Empleado Registrado Exitosamente.";
                                        $data_json['resultado'] = 2;
                                        $datos_json["exitoAuditoria"] = true;
                                        $datos_json['messengerAuditoria'] = "Auditoria registrada con exito.";
                                    } else {
                                        $data_json['exito'] = false;
                                        $data_json['mensaje'] = "no se logro registrar la ubicación, pero el empleado ha sido registrado con exito";
                                        $data_json['resultado'] = 1;
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
                $viejosDatos = $this->getTotalDatosPEID([$idPersonal]);
                foreach ($viejosDatos as $row) {
                    $idPersonal = $row['id_personal'];

                    $check_regisPersonal = $this->getActualizar('datospersonales', $personal_datos_reg,  $condicion_personal);
                    if ($check_regisPersonal) {
                        $registroAuditoria = $this->auditoriaController->registrarAuditoria($this->idUsuario, 'Actualizar personal', 'El usuario ' . $this->nombreUsuario . ' actualizo los datos del personal ' . $primerNombre . ' ' . $primerApellido . ' por tador de la cédula ' . $cedula . '.');

                        $check_busEmpleado = $this->getActualizar('datosempleados', $empleados_datos_reg, $condicion_empleado);
                        if ($check_busEmpleado) {
                            $registroAuditoria = $this->auditoriaController->registrarAuditoria($this->idUsuario, 'Actualizar empleado', 'El usuario ' . $this->nombreUsuario . ' actualizo los datos del empleado con cedula ' . $cedula . '.');
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
                        } else {
                            $data_json['exito'] = false;
                            $data_json['mensaje'] = "Los datos Del Personal fueron registrados exitosamente, pero el de los datos empleados";
                            $data_json['resultado'] = 1;
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
        $idPersonal,
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
        $folio,
        $sexo,
        $discapacidad
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
        $sexo = $this->limpiarCadena($sexo);
        $discapacidad = $this->limpiarCadena($discapacidad);

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
        if ($discapacidad == '') {
            $discapacidad = null;
        }
        $parametro = [$cedulaEmpleado, $cedulaEmpleado . "%"];
        if ($cedula == '') {
            $noCedulaFamiliar = $this->retornaNoCedula($parametro);
            if (empty($noCedulaFamiliar)) {
                $cedula = $cedulaEmpleado . "001";
            } else {
                $cedula = intval($noCedulaFamiliar[0]['cedula']) + 1;
            }
        }

        $data_json = [
            'exito' => false, // Inicializamos a false por defecto
            'mensaje' => '',
            'resultado' => 0,
        ];
        $check_empleado = $this->getTotalDatosIDEmpleados([$idPersonal]);
        if ($check_empleado) {
            foreach ($check_empleado as $row) {
                $id_empleado = $row['id_empleados'];
                $nombreEmpleado = $row['primerNombre'] . " " . $row['primerApellido'];
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
                        "campo_nombre" => "sexoFamiliar",
                        "campo_marcador" => ":sexoFamiliar",
                        "campo_valor" => $sexo
                    ],
                    [
                        "campo_nombre" => "discapacidad",
                        "campo_marcador" => ":discapacidad",
                        "campo_valor" => $discapacidad
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
                        $archivosASubir[] = ['input' => $fileInputName, 'dir' => $uploadDir1, 'nombreArchico' => 'Partida Nacimiento'];
                    }
                    if ($nombreArchivo2) {
                        $archivosASubir[] = ['input' => $fileInputName2, 'dir' => $uploadDir2, 'nombreArchico' => 'Partida Discapacidad'];
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

                            $check_exisfamiliar = $this->getDatosFamiliarID([$idfamiliar]);
                            if ($check_exisfamiliar) {
                                foreach ($check_exisfamiliar as $rowFamiliar) {
                                    $id_nino = $rowFamiliar['id_ninos'];
                                    $nombreFamiliar = $rowFamiliar['primerNombreFamiliar'] . " " . $rowFamiliar['primerApellidoFamiliar'];
                                    // Si ninguno de los archivos existe, proceder con la subida
                                    foreach ($archivosASubir as $archivo) {
                                        $inputName = $archivo['input'];
                                        $nombreArchivodoc = $archivo['nombreArchico'];

                                        $direccion = $archivo['dir'] . $nombreArchivos[$inputName]['nombre'];
                                        $resultados[$inputName] = $this->fileUploader->subirArchivo($_FILES[$inputName], $cedula, $archivo['dir'], $id_empleado, $id_nino, $nombreArchivodoc);
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
                                        $id = intval($idPersonal);
                                        $checkidFamilia = $this->actualuzarIDfamiliar('datosfamilia', "idEmpleado =" . $id, 'id_ninos = ' . $id_nino);
                                        $checkiddocFamilia = $this->actualuzarIDfamiliar('documentacion', "idEmpleados =" . $id, 'idNinos = ' . $id_nino);
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
                        $check_exisfamiliar = $this->getDatosFamiliarID([$idfamiliar]);
                        if ($check_exisfamiliar) {
                            foreach ($check_exisfamiliar as $rowFamiliar) {
                                $id_nino = $rowFamiliar['id_ninos'];
                                $nombreFamiliar = $rowFamiliar['primerNombreFamiliar'] . " " . $rowFamiliar['primerApellidoFamiliar'];
                                $condicion = [
                                    "condicion_campo" => "id_ninos",
                                    "condicion_marcador" => ":id_ninos",
                                    "condicion_valor" => $id_nino
                                ];
                                $check_familiar = $this->getActualizar('datosFamilia', $parametrosFamilia, $condicion);

                                if ($check_familiar) {
                                    $id = intval($idPersonal);
                                    $checkidFamilia = $this->actualuzarIDfamiliar('datosfamilia', "idEmpleado =" . $id, 'id_ninos = ' . $id_nino);
                                    if ($checkidFamilia) {
                                        $data_json['idFamiliar'] = 'Actualizacion de id de documento listo';
                                    } else {
                                        $data_json['idFamiliar'] = 'error al actualizar el id ';
                                    }

                                    $checkiddocFamilia = $this->actualuzarIDfamiliar('documentacion', "idEmpleados =" . $id, 'idNinos = ' . $id_nino);
                                    if ($checkiddocFamilia) {
                                        $data_json['idDocFamiliar'] = 'Actualizacion de id de documento listo';
                                    } else {
                                        $data_json['idDocFamiliar'] = 'error al actualizar el id del documento';
                                    }

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
