<?php

namespace App\Atlas\controller;

use App\Atlas\models\personalModel;
use App\Atlas\models\dependenciasModel;
use App\Atlas\models\estatusModel;
use App\Atlas\controller\fileUploaderController;
use App\Atlas\models\tablasModel;
use App\Atlas\config\App;

class personalController extends personalModel
{

    private $dependencia;
    private $estatus;
    private $archivo;

    private $fileUploader;
    private $tablas;
    private $app;

    public function __construct()
    {
        parent::__construct();
        $this->fileUploader = new fileUploaderController(['pdf', 'jpg', 'png'], '../controller/');
        $this->tablas = new tablasModel();
        $this->app = new App();
    }
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
        $telefono
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

        // DATOS DE EMPLEAODS
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
                "campo_valor" => date("H:i:s")
            ]
        ];

        $parametro = [$cedula];
        // Verificar si los archivos tienen nombres diferentes
        $nombreArchivo1 = isset($_FILES[$fileInputName]) ? $_FILES[$fileInputName]['name'] : null;
        $nombreArchivo2 = isset($_FILES[$fileInputName2]) ? $_FILES[$fileInputName2]['name'] : null;

        if ($nombreArchivo1 && $nombreArchivo2 && $nombreArchivo1 === $nombreArchivo2) {
            $data_json['exito'] = false;
            $data_json['mensaje'] = 'Los dos archivos no pueden tener el mismo nombre.';
        } else {
            // Crear un array con los archivos que se están subiendo
            $archivosASubir = [];
            $nombreArchivo1 = $_FILES[$fileInputName]['name'];
            $nombreArchivo2 = $_FILES[$fileInputName2]['name'];

            if ($nombreArchivo1 && $nombreArchivo2) {
                $archivosASubir[] = ['input' => $fileInputName, 'dir' => $uploadDir1];
                $archivosASubir[] = ['input' => $fileInputName2, 'dir' => $uploadDir2];
                // Ejecutar el código de subida si hay archivos para subir
                if (!empty($archivosASubir)) {
                    $check_personal = $this->getExistePersonal($parametro);
                    if ($check_personal) {
                        $data_json['exito'] = false;
                        $data_json['personalEncontrado'] = true;
                        $data_json['mensaje'] = 'personal encontrado';
                        $data_json['cedula'] = $cedula;
                    } else {
                        $registrarPersonal = $this->getRegistrar("datosPersonales", $personal_datos_reg);
                        if ($registrarPersonal == true) {
                            $check_personal_exis = $this->getDatosPersonal($parametro);
                            if ($check_personal_exis == true) {
                                foreach ($check_personal_exis as $row) {
                                    $idPersonal = $row['id_personal'];
                                    if ($idPersonal) {
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
                                                "campo_nombre" => "fecha",
                                                "campo_marcador" => ":fecha",
                                                "campo_valor" => date("Y-m-d")
                                            ],
                                            [
                                                "campo_nombre" => "hora",
                                                "campo_marcador" => ":hora",
                                                "campo_valor" => date("H:i:s")
                                            ]
                                        ];
                                        $parametro = [$idPersonal];
                                        $check_empleado_exis = $this->getExisteEmpleado($parametro);
                                        if ($check_empleado_exis) {
                                            $data_json['exito'] = true;
                                            $data_json['mensaje'] = "Este trabajador ya esta registrado";
                                        } else {
                                            $check_empleado = $this->getRegistrarEmpleado("datosempleados", $empleados_datos_reg);
                                            if ($check_empleado == true) {
                                                $check_idEmpleado = $this->getExisteEmpleado($parametro);
                                                foreach ($check_idEmpleado as $row) {
                                                    $idEmpleado = $row['id_empleados'];
                                                    if ($idEmpleado) {
                                                        $resultados = [];
                                                        foreach ($archivosASubir as $archivo) {
                                                            $inputName = $archivo['input'];
                                                            $resultados[$inputName] = $this->fileUploader->upload($_FILES[$inputName], $archivo['dir'], $cedula);
                                                        }
                                                        // Manejar los resultados
                                                        $error = false;
                                                        $mensajeError = 'Error al subir los archivos.';
                                                        if ($nombreArchivo1 && isset($resultados[$fileInputName]['error']) && $resultados[$fileInputName]['error']) {
                                                            $error = true;
                                                            $mensajeError .= ' ' . $resultados[$fileInputName]['mensaje'];
                                                        }
                                                        if ($nombreArchivo2 && isset($resultados[$fileInputName2]['error']) && $resultados[$fileInputName2]['error']) {
                                                            $error = true;
                                                            $mensajeError .= ' ' . $resultados[$fileInputName2]['mensaje'];
                                                        }

                                                        if ($error) {
                                                            $data_json['exito'] = false;
                                                            $data_json['mensaje'] = $mensajeError;
                                                            $data_json['personal'] = 'los datos del nuevo personal y empleado si fueron registrados';
                                                        } else {
                                                            if ($nombreArchivo1) {
                                                                $data_json['archivo1'] = $resultados[$fileInputName];
                                                            }
                                                            if ($nombreArchivo2) {
                                                                $data_json['archivo2'] = $resultados[$fileInputName2];
                                                            }
                                                            $parametros_doc = [];
                                                            if ($nombreArchivo1) {
                                                                $parametros_doc[] = [
                                                                    [
                                                                        "campo_nombre" => "idEmpleados",
                                                                        "campo_marcador" => ":idEmpleados",
                                                                        "campo_valor" => $idEmpleado
                                                                    ],
                                                                    [
                                                                        "campo_nombre" => "size",
                                                                        "campo_marcador" => ":size",
                                                                        "campo_valor" => $resultados[$fileInputName]['tamano']
                                                                    ],
                                                                    [
                                                                        "campo_nombre" => "doc",
                                                                        "campo_marcador" => ":doc",
                                                                        "campo_valor" => $resultados[$fileInputName]['nombre']
                                                                    ],
                                                                    [
                                                                        "campo_nombre" => "tipoDoc",
                                                                        "campo_marcador" => ":tipoDoc",
                                                                        "campo_valor" => $resultados[$fileInputName]['extension']
                                                                    ]
                                                                ];
                                                            }

                                                            if ($nombreArchivo2) {
                                                                $parametros_doc[] = [
                                                                    [
                                                                        "campo_nombre" => "idEmpleados",
                                                                        "campo_marcador" => ":idEmpleados",
                                                                        "campo_valor" => $idEmpleado
                                                                    ],
                                                                    [
                                                                        "campo_nombre" => "size",
                                                                        "campo_marcador" => ":size",
                                                                        "campo_valor" => $resultados[$fileInputName2]['tamano']
                                                                    ],
                                                                    [
                                                                        "campo_nombre" => "doc",
                                                                        "campo_marcador" => ":doc",
                                                                        "campo_valor" => $resultados[$fileInputName2]['nombre']
                                                                    ],
                                                                    [
                                                                        "campo_nombre" => "tipoDoc",
                                                                        "campo_marcador" => ":tipoDoc",
                                                                        "campo_valor" => $resultados[$fileInputName2]['extension']
                                                                    ]
                                                                ];
                                                            }
                                                            $tabla = 'documentacion';
                                                            // Guardar los datos en la base de datos
                                                            foreach ($parametros_doc as $datos) {
                                                                $jo = $this->getRegistrarDOCS($tabla, $datos);
                                                            }
                                                            $data_json['exito'] = true;
                                                            $data_json['mensaje'] = "Familiar Registrado Exitosamente.";
                                                            $data_json['resultado'] = 2;
                                                        }
                                                    } else {
                                                        $data_json['mensaje'] = "no se encontro el trabajador";
                                                    }
                                                }
                                            } else {
                                                $data_json['exito'] = true;
                                                $data_json['mensaje'] = "No se logro realizar la consulta";
                                            }
                                        }
                                    } else {
                                        $data_json['mensaje'] = "No se pudo recorrer el identificador";
                                    }
                                }
                            } else {
                                $data_json['mensaje'] = "Error al consultar los datos del personal previamente registrado";
                            }
                        } else {
                            $data_json['mensaje'] = "La consulta no se logro realizar correctamente";
                        }
                    }
                } else {
                    // Establecer un mensaje de error si uno o ambos archivos no están presentes
                    $data_json['exito'] = false;
                    $data_json['mensaje'] = "Debe subir ambos archivos";
                    $data_json['resultado'] = 3;
                }
            }
        }
        header('Content-Type: application/json');
        echo json_encode($data_json);
    }

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
            $check_personal = $this->getDatosPersonal($parametro);
            if ($check_personal == true) {
                foreach ($check_personal as $row) {
                    $data_json['exito'] = true;
                    $data_json['idPersonal'] = $row['id_personal'];
                    $data_json['cedula'] = $row['cedula'];
                    $data_json['nombre'] = $row['primerNombre'];
                    $data_json['apellido'] = $row['primerApellido'];
                    $data_json['mensaje'] = "Trabajador Encontrado";
                    $data_json['logrado'] = true;
                }
            } else {
                $data_json['exito'] = true;
                $data_json['mensaje'] = "Este trabajador no se encuentra registrado en nuestro sistema.";
                $data_json['logrado'] = false;
            }
        }
        header('Content-Type: application/json');
        echo json_encode($data_json);
    }

    public function registrarFamilia(
        $cedula_familiar,
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
        $cedula_familiar = $this->limpiarCadena($cedula_familiar);
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

        $fileInputName = 'docArchivo';
        $fileInputName2 = 'docArchivoDis';
        $uploadDir1 = App::URL_PARTIDANACIMIENTO;
        $uploadDir2 = App::URL_PARTIDADEISCAPACIDAD;

        $data_json = [
            'exito' => true, // Inicializamos a false por defecto
            'mensaje' => 'si llego hasta aqui',
            'resultado' => 0,
            'archivo1' => 'no hay primer archivo',
            'archivo2' => 'no hay segundo archivo',
        ];

        if ($cedula == "") {
            $cedula == "No Cédulado";
        }

        $parametro = [$cedula_familiar];
        $check_empleado = $this->getExisteEmpleado_datos($parametro);
        if ($check_empleado) {
            foreach ($check_empleado as $row) {
                $id_empleado = $row['id_empleados'];
                $parametrofamili = [$cedula, $numeroCarnet];
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
                        "campo_nombre" => "edad",
                        "campo_marcador" => ":edad",
                        "campo_valor" => $edad
                    ],
                    [
                        "campo_nombre" => "fechaNacimiento",
                        "campo_marcador" => ":fechaNacimiento",
                        "campo_valor" => $ano . "/" . $mes . "/" . $dia
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
                        "campo_nombre" => "fecha",
                        "campo_marcador" => ":fecha",
                        "campo_valor" => date("Y-m-d")
                    ],
                    [
                        "campo_nombre" => "hora",
                        "campo_marcador" => ":hora",
                        "campo_valor" => date("H:i:s")
                    ]
                ];
                $tabla = 'datosFamilia';
                $parametro_registrar = $parametrosFamilia;
                $check_familiar_exis = $this->getExisteFamiliar($parametrofamili);
                if ($check_familiar_exis) {
                    $data_json['exito'] = true;
                    $data_json['mensaje'] = "Este familiar ya esta registrado";
                    $data_json['resultado'] = 1;
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
                        // Ejecutar el código de subida si hay archivos para subir
                        if (!empty($archivosASubir)) {
                            $resultados = [];
                            foreach ($archivosASubir as $archivo) {
                                $inputName = $archivo['input'];
                                $resultados[$inputName] = $this->fileUploader->upload($_FILES[$inputName], $archivo['dir'], $cedula);
                            }
                            // Manejar los resultados
                            $error = false;
                            $mensajeError = 'Error al subir los archivos.';
                            if ($nombreArchivo1 && isset($resultados[$fileInputName]['error']) && $resultados[$fileInputName]['error']) {
                                $error = true;
                                $mensajeError .= ' ' . $resultados[$fileInputName]['mensaje'];
                            }
                            if ($nombreArchivo2 && isset($resultados[$fileInputName2]['error']) && $resultados[$fileInputName2]['error']) {
                                $error = true;
                                $mensajeError .= ' ' . $resultados[$fileInputName2]['mensaje'];
                            }

                            if ($error) {
                                $data_json['exito'] = false;
                                $data_json['mensaje'] = $mensajeError;
                            } else {
                                if ($nombreArchivo1) {
                                    $data_json['archivo1'] = $resultados[$fileInputName];
                                }
                                if ($nombreArchivo2) {
                                    $data_json['archivo2'] = $resultados[$fileInputName2];
                                }

                                $check_familiar = $this->getRegistrarEmpleado($tabla, $parametro_registrar);
                                if ($check_familiar) {
                                    $parametros_doc = [];
                                    if ($nombreArchivo1) {
                                        $parametros_doc[] = [
                                            [
                                                "campo_nombre" => "idEmpleados",
                                                "campo_marcador" => ":idEmpleados",
                                                "campo_valor" => $id_empleado
                                            ],
                                            [
                                                "campo_nombre" => "size",
                                                "campo_marcador" => ":size",
                                                "campo_valor" => $resultados[$fileInputName]['tamano']
                                            ],
                                            [
                                                "campo_nombre" => "doc",
                                                "campo_marcador" => ":doc",
                                                "campo_valor" => $resultados[$fileInputName]['nombre']
                                            ],
                                            [
                                                "campo_nombre" => "tipoDoc",
                                                "campo_marcador" => ":tipoDoc",
                                                "campo_valor" => $resultados[$fileInputName]['extension']
                                            ],
                                            [
                                                "campo_nombre" => "fecha",
                                                "campo_marcador" => ":fecha",
                                                "campo_valor" => date("Y-m-d")
                                            ],
                                            [
                                                "campo_nombre" => "hora",
                                                "campo_marcador" => ":hora",
                                                "campo_valor" => date("H:i:s")
                                            ]
                                        ];
                                    }

                                    if ($nombreArchivo2) {
                                        $parametros_doc[] = [
                                            [
                                                "campo_nombre" => "idEmpleados",
                                                "campo_marcador" => ":idEmpleados",
                                                "campo_valor" => $id_empleado
                                            ],
                                            [
                                                "campo_nombre" => "size",
                                                "campo_marcador" => ":size",
                                                "campo_valor" => $resultados[$fileInputName2]['tamano']
                                            ],
                                            [
                                                "campo_nombre" => "doc",
                                                "campo_marcador" => ":doc",
                                                "campo_valor" => $resultados[$fileInputName2]['nombre']
                                            ],
                                            [
                                                "campo_nombre" => "tipoDoc",
                                                "campo_marcador" => ":tipoDoc",
                                                "campo_valor" => $resultados[$fileInputName2]['extension']
                                            ],
                                            [
                                                "campo_nombre" => "fecha",
                                                "campo_marcador" => ":fecha",
                                                "campo_valor" => date("Y-m-d")
                                            ],
                                            [
                                                "campo_nombre" => "hora",
                                                "campo_marcador" => ":hora",
                                                "campo_valor" => date("H:i:s")
                                            ]
                                        ];
                                    }
                                    $tabla = 'documentacion';
                                    // Guardar los datos en la base de datos
                                    foreach ($parametros_doc as $datos) {
                                        $jo = $this->getRegistrarDOCS($tabla, $datos);
                                    }
                                    $data_json['exito'] = true;
                                    $data_json['mensaje'] = "Familiar Registrado Exitosamente.";
                                    $data_json['resultado'] = 2;
                                } else {
                                    $data_json['exito'] = false;
                                    $data_json['mensaje'] = "No se logro registrar el familiar";
                                    $data_json['resultado'] = 3;
                                }
                            }
                        } else {
                            $data_json['exito'] = true;
                            $data_json['mensaje'] = "Debe subir al menos un archivo";
                            $data_json['resultado'] = 3;
                        }
                    }
                }
            }
        } else {
            // $data_json['exito'] = true;
            // $data_json['mensaje'] = $parametro;
        }


        header('Content-Type: application/json');
        echo json_encode($data_json);
    }

    public function obtenerDependencias()
    {
        $dependencias = $this->getDependenciasPersonales();
        foreach ($dependencias as $row) {
            $data_json['exito'] = true;
            $data_json['data'][] = [
                'iddependencia' => $row['id_dependencia'],
                'dependencia' => $row['dependencia']
            ];
            $data_json['mensaje'] = "todas las dependencias exitoso";
        }
        header('Content-Type: application/json');
        echo json_encode($data_json);
    }

    public function obtenerEstatus()
    {
        $estatus = $this->getEstatusPersonales();
        foreach ($estatus as $row) {
            $data_json['exito'] = true;
            $data_json['data'][] = [
                'idestatus' => $row['id_estatus'],
                'estatus' => $row['estatus']
            ];
            $data_json['mensaje'] = "todas las estatus exitoso";
        }
        header('Content-Type: application/json');
        echo json_encode($data_json);
    }

    public function obtenerCargo()
    {
        $cargo = $this->getCargoPersonales();
        foreach ($cargo as $row) {
            $data_json['exito'] = true;
            $data_json['data'][] = [
                'idcargo' => $row['id_cargo'],
                'cargo' => $row['cargo']
            ];
            $data_json['mensaje'] = "todas las cargo exitoso";
        }
        header('Content-Type: application/json');
        echo json_encode($data_json);
    }

    public function obtenerDepartamento()
    {
        $departamento = $this->getDepartamentosPersonales();
        foreach ($departamento as $row) {
            $data_json['exito'] = true;
            $data_json['data'][] = [
                'iddepartamento' => $row['id_departamento'],
                'departamento' => $row['departamento']
            ];
            $data_json['mensaje'] = "todas las departamento exitoso";
        }
        header('Content-Type: application/json');
        echo json_encode($data_json);
    }

    public function objetoDependencia()
    {
        return $this->dependencia = new dependenciasModel();
    }

    public function objetoEstatus()
    {
        return $this->estatus = new estatusModel();
    }

    // public function objetoArchivo()
    // {
    //     return $this->archivo = new archivo();
    // }

    // public function getArchivoDatos()
    // {
    //     $datosArch = $this->objetoArchivo();
    //     return $datosArch->datosArchivos();
    // }

    protected function getEstatusPersonales()
    {
        $estatusPersonal = $this->objetoEstatus();
        return $estatusPersonal->getDatosEstatus();
    }

    protected function getCargoPersonales()
    {
        $cargoPersonal = $this->objetoEstatus();
        return $cargoPersonal->getDatosCargo();
    }
    protected function getDependenciasPersonales()
    {
        $dependenciaPersonal = $this->objetoDependencia();
        return $dependenciaPersonal->getDatosDependencia();
    }
    protected function getDepartamentosPersonales()
    {
        $departamentoPersonal = $this->objetoDependencia();
        return $departamentoPersonal->getDatosDepartamentos();
    }

    public function obtenerTodoPersonal()
    {
        $data_json = []; // Array de datos para enviar
        $tabla = 'datosempleados e
              INNER JOIN datospersonales d ON e.idPersonal = d.id_personal
              INNER JOIN estatus es ON e.idEstatus = es.id_estatus
              INNER JOIN cargo ca ON e.idCargo = ca.id_cargo
              INNER JOIN dependencia depe ON e.idDependencia = depe.id_dependencia
              INNER JOIN departamento depa ON e.idDepartamento = depa.id_departamento'; // Tabla a consultar
        $selectoresCantidad = 'COUNT(e.idPersonal) as cantidad'; // Selector para contar la cantidad de registros de la tabla
        $datosBuscar = [
            'e.idPersonal',
            'd.primerNombre',
            'd.segundoNombre',
            'd.primerApellido',
            'd.segundoApellido',
            'd.cedula',
            'es.estatus',
            'ca.cargo',
            'depe.dependencia',
            'depa.departamento'
        ]; // Array de selectores para buscar en la tabla
        $campoOrden = 'e.idPersonal'; // Campo por el cual se ordenará la tabla
        $selectores = 'e.id_empleados, e.idPersonal, d.primerNombre, d.segundoNombre, d.primerApellido, d.segundoApellido, d.cedula, es.estatus, ca.cargo, depe.dependencia, depa.departamento'; // Selectores para obtener los datos de la tabla

        $draw = $_REQUEST['draw'];
        $start = $_REQUEST['start'];
        $length = $_REQUEST['length'];
        $searchValue = $_REQUEST['search']['value'];

        // Obtener la cantidad de los datos de la tabla
        $cantidadRegistro = $this->tablas->getCantidadRegistros($tabla, $selectoresCantidad);
        // Obtener los datos de la tabla
        $personal = $this->tablas->getTodoDatosPersonal($selectores, $tabla, $start, $length, $searchValue, $datosBuscar, $campoOrden);
        // Recorrer datos de la tabla
        foreach ($personal as $row) {
            $data_json['exito'] = true;
            $parametro = [$row['id_empleados']];
            $validarFamiliar = $this->getExisteEmpleadoFamiliar($parametro);
            $botones = "
            <div class='btn-group' role='group' aria-label='Basic example'>
                <button class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#exampleModal' onclick='editarPersonal(" . $row['id_empleados'] . ")'>Editar</button>
                <button class='btn btn-danger btn-sm' onclick='eliminarPersonal(" . $row['id_empleados'] . ")'>Eliminar</button>
        ";

            if ($validarFamiliar) {
                $botones .= "<button class='btn btn-warning btn-sm btn-familiar' data-id=" . $row['id_empleados'] . ">Familiar</button>";
            }


            $botones .= "</div>";
            $data_json['data'][] = [
                '0' => $row['primerNombre'] . " " . $row['primerApellido'],
                '1' => $row['estatus'],
                '2' => $row['cargo'],
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
}
