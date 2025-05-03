<?php

namespace App\Atlas\controller;

use App\Atlas\models\familiarModel;
use App\Atlas\models\personalModel;
use App\Atlas\controller\fileUploaderController;
use App\Atlas\models\tablasModel;
use App\Atlas\config\App;
use App\Atlas\controller\auditoria\AuditoriaController;

date_default_timezone_set("America/Caracas");

class familiarController extends familiarModel
{


    private $fileUploader;
    private $personalModel;
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
        $this->personalModel = new personalModel();
        $this->app = new App();
        $this->auditoriaController = new auditoriaController();
        $this->app->iniciarSession();
        $this->idUsuario = $_SESSION['id'];
        $this->nombreUsuario = $_SESSION['usuario'];
    }

    // FUNCION PARA BUSCAR LOS FAMILIAR EN ESTUS PENDIENTES
    public function buscarFamilairPendiente(string $cedula): array
    {
        /*----------- BUSCAR FAMILIAR PENDIENTE ----------*/
        // datos json
        $data_json = [];
        // buscar familiar pendiente por medio de su identificar cedula
        $bfPendiente = $this->getDatosFamiliarFiltro('df.cedula = ? AND df.activo = ?', [$cedula, "2"]);
        if (!empty($bfPendiente)) {

            // iterar sobre los datos para organizar la informacion
            foreach ($bfPendiente as $row) {
                $data_json['exito'] = true;
                $data_json['mensaje'] = 'Familiar pendiente encontrado.';
                $data_json['primerNombre'] = $row['primerNombreFamiliar'];
                $data_json['primerApellido'] = $row['primerApellidoFamiliar'];
                $data_json['cedula'] = $row['cedulaFamiliar'];
                $data_json['nombreEmpleado'] = $row['primerNombreEmpleado'];
                $data_json['apellidoEmpledo'] = $row['primerApellidoEmpleado'];
                $data_json['cedulaEmpleado'] = $row['cedulaEmpleado'];
            }
        } else {
            //en caso a que falle
            $data_json['exito'] = false;
            $data_json['mensaje'] = 'No se encontro ningun familiar con esta cédula.';
        }

        return $this->app->imprimirRespuestaJSON($data_json);
    }

    // FUNCION DE REGISTRO FAMILIAR
    public function registrarFamiliar(
        string $parentesco,
        string $cedulaEmpleado,
        string $primerNombre,
        string $segundoNombre,
        string $primerApellido,
        string $segundoApellido,
        string $cedula,
        string $edad,
        string $ano,
        string $mes,
        string $dia,
        string $numeroCarnet,
        string $tomo,
        string $folio,
        string $discapacidad,
        string $sexo,
        string $familiarInces
    ): array {
        $discapacidad = empty($discapacidad) ? null : $discapacidad;
        $numeroCarnet = empty($numeroCarnet) ? null : $numeroCarnet;

        $data_json = [
            'exito' => false,
            'mensaje' => ''
        ];

        // aqui se valida que ambas cedulas no sean iguales
        if ($cedulaEmpleado === $cedula) {
            $data_json['exito'] = false;
            $data_json['mensaje'] = 'Las dos cédulas del empleado y el familiar son iguales';
            return $this->app->imprimirRespuestaJSON($data_json);
        }

        // si el trabajdor a afiliar existe
        $Datosempleado = $this->personalModel->getTotalDatosPE([$cedulaEmpleado]);
        // validar que si tenga datos
        if (empty($Datosempleado)) {
            //en caso de que la validacion del trabajador falle
            $data_json['exito'] = false;
            $data_json['mensaje'] = 'El empleado al que se le intenta afiliar el familiar no se logra encontrar.';
        } else {
            // recorres array de los datos
            foreach ($Datosempleado as $row) {
                // datos del trabajador
                $id_empleado = $row['id_empleados'];
                $nombreEmpleado = $row['primerNombre'];
                $apellidoEmpleado = $row['primerApellido'];

                // parametros de registro del familiar
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

                /*-------------------- VALIDACION SI FAMILIAR EXISTE--------------------- */
                // si el familiar asignar existe en el registro
                $check_familiar_exis = $this->getExisteFamilar([$cedula, $tomo, $folio]);
                if ($check_familiar_exis) {
                    // si salio bien es porque se encontro un familiar
                    $data_json['exito'] = false;
                    $data_json['mensaje'] = $check_familiar_exis['mensaje'];
                    return $this->app->imprimirRespuestaJSON($data_json);
                }

                /*-------------------- VALIDACION SI EL FAMILIAR ES INCES --------------------- */
                // Si el familiar en inces se ejecuta este apartado
                if ($familiarInces == "si") {
                    // En caso que el familiar sea trabajador inces ya registrado
                    $existeFamiliarInces = $this->getExisteFamiliarIncesPorCedula([$cedula]);
                    if ($existeFamiliarInces) {
                        // en caso de que si exista un familiar registrado inces
                        $data_json['exito'] = false;
                        $data_json['mensaje'] = "Este familiar inces ya esta asignado a otro trabajador";
                        return $this->app->imprimirRespuestaJSON($data_json);
                    }

                    // registro del familiar inces
                    $registrarFamiliarInces = $this->registrarFamiliarInces($familiarInces, $primerNombre, $primerApellido, $cedula, $id_empleado);
                    //valdiamos si se cumplio el registro
                    if (!$registrarFamiliarInces['exito']) {
                        $data_json['exito'] = false;
                        $data_json['mensaje'] = $registrarFamiliarInces['mensaje'];
                    } else {
                        //registrar documentacion
                        $registrarDocumentos = $this->fileUploader->registrarArchivos($cedula, $id_empleado, $parentesco);

                        //validamos la subida de los archivos y damos evento de exito del registro
                        if ($registrarDocumentos['exito']) {
                            // si se valida que algun archivo se subio con existo
                            $data_json['exito'] = true;
                            $data_json['mensajearchivo1'] = "Registrado exitosamente";
                            $data_json['archivos'] = $registrarDocumentos;
                        } else {
                            // si se valida que se cargo el familiar pero no los archivos
                            $data_json['exito'] = false; // si la carga de los archivos salio mal igual se cargaron lso datos del empleado
                            $data_json['mensaje'] = "El registro de los datos se completó con éxito. Sin embargo, se produjo un error al cargar los archivos adjuntos. Le pedimos que, por favor, acceda a la sección de edición del familiar y vuelva a cargar los archivos necesarios.";
                            $data_json['archivos'] = $registrarDocumentos;
                        }

                        $data_json['mensaje'] = "Registrado familiar exitosamente";
                    }

                    return $this->app->imprimirRespuestaJSON($data_json);
                }


                /*-------------------- REGISTROS DEL FAMILIAR --------------------- */
                // en caso que n oconsiga familiar asignado y que el familiar nbo es trabajador inces
                // registramos el familiar
                $check_familiar = $this->getRegistrar('datosFamilia', $parametrosFamilia);
                if ($check_familiar) {
                    // si se registro exitosamente podemos cargar la auditoria del registro
                    $registroAuditoria = $this->auditoriaController->registrarAuditoria(
                        $this->idUsuario,
                        'Registrar familiar',
                        'El usuario ' .
                            $this->nombreUsuario .
                            ' asigno un nuevo familiar en el sistema al empleado ' .
                            $nombreEmpleado . ' ' .
                            $apellidoEmpleado .
                            ' portador de la cedula ' .
                            $cedulaEmpleado .
                            ' el familiar asignado fue ' .
                            $primerNombre . ' ' .
                            $primerApellido . '.'
                    );

                    // si se carga la auditoria correctamente
                    if ($registroAuditoria) {
                        $data_json["exitoAuditoria"] = true;
                        $data_json['messengerAuditoria'] = "Auditoria registrada con exito.";
                    } else {
                        $data_json["exitoAuditoria"] = false;
                        $data_json['messengerAuditoria'] = "Error al registrar la auditoria.";
                    }

                    $data_json["exito"] = true;
                    $data_json['mensaje'] = "Registro del familiar exitoso";
                } else {

                    //en caso de que el registro del familiar falle
                    $data_json['exito'] = false;
                    $data_json['mensaje'] = 'El familiar no se logro registrar correctamente';
                }

                /*-------------------- SUBIR DOCUMENTOS POR FAMILIAR --------------------- */
                // despues de registrar el familiar registrarmos y subimos los documentos al sistema
                $registrarDocumentos = $this->fileUploader->registrarArchivos($cedula, $id_empleado);

                //validamos la subida de los archivos y damos evento de exito del registro
                if ($registrarDocumentos['exito']) {
                    $data_json['exito'] = true;
                    $data_json['mensajearchivo1'] = "Registrado exitosamente";
                    $data_json['archivos'] = $registrarDocumentos;
                } else {
                    $data_json['exito'] = false; // si la carga de los archivos salio mal igual se cargaron lso datos del empleado
                    $data_json['mensajearchivo2'] = "El registro de los datos se completó con éxito. Sin embargo, se produjo un error al cargar los archivos adjuntos. Le pedimos que, por favor, acceda a la sección de edición del empleado y vuelva a cargar los archivos necesarios.";
                    $data_json['archivos'] = $registrarDocumentos;
                }
            }
        }


        return $this->app->imprimirRespuestaJSON($data_json);
    }

    // METRODO PARA REGISTRAR A UN TRABAJOR INCES
    public function registrarFamiliarInces(
        string $FamiliarInces,
        string $primerNombreFamiliar,
        string $primerApellidoFamiliar,
        string $cedulaFamiliar,
        string $id_empleado,
        int $estatus = 1
    ): array {

        //en caso que el familiar sea inces
        if ($FamiliarInces == "si") {

            // se valida si existe la cedula del familiar inces que va hacer asignado
            $check_familiar = $this->personalModel->getreturnIDP([$cedulaFamiliar]);
            if (!$check_familiar) {
                // en caso que no se encuentra el empelado
                return ['exito' => false, 'mensaje' => 'No se encontró el familiar INCES para asignar.'];
            }

            // si se encontro recorremos el array de datos
            foreach ($check_familiar as $row) {
                $idPersonal = $row['id_personal']; // id personal del familiar inces

                // parametros de registro
                $registrarFamiliarInces = [
                    [
                        "campo_nombre" => "idEmpleado",
                        "campo_marcador" => ":idEmpleado",
                        "campo_valor" => $id_empleado
                    ],
                    [
                        "campo_nombre" => "idPersonal",
                        "campo_marcador" => ":idPersonal",
                        "campo_valor" => $idPersonal
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

                // Asignamos al registro el empleado con este empleado inces como familiar
                $check_familiar = $this->getRegistrar('datosFamiliarinces', $registrarFamiliarInces);
                if ($check_familiar) {
                    // si se logro
                    return ['exito' => true, 'mensaje' => 'El familiar INCES fue asignado.'];
                } else {
                    // si no se logro
                    return ['exito' => false, 'mensaje' => 'El familiar INCES no logró ser asignado.'];
                }
            }
        } else {
            // en caso que el familiar asignar a un trabajador tenga cedula
            // se le asigna como pendiente
            if (!$cedulaFamiliar == "") {
                //parametros de registro de familiar pendiente
                $registrarFamiliar = [
                    [
                        "campo_nombre" => "idEmpleado",
                        "campo_marcador" => ":idEmpleado",
                        "campo_valor" => $id_empleado
                    ],
                    [
                        "campo_nombre" => "primerNombre",
                        "campo_marcador" => ":primerNombre",
                        "campo_valor" => $primerNombreFamiliar
                    ],
                    [
                        "campo_nombre" => "primerApellido",
                        "campo_marcador" => ":primerApellido",
                        "campo_valor" => $primerApellidoFamiliar
                    ],
                    [
                        "campo_nombre" => "cedula",
                        "campo_marcador" => ":cedula",
                        "campo_valor" => $cedulaFamiliar
                    ],
                    [
                        "campo_nombre" => "activo",
                        "campo_marcador" => ":activo",
                        "campo_valor" => $estatus
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

                // registro como familair pendiente
                $check_familiar = $this->getRegistrar('datosFamilia', $registrarFamiliar);
                if ($check_familiar) {
                    // si se logro
                    return ['exito' => true, 'mensaje' => 'El familiar fue asignado.'];
                } else {
                    //si no se logro
                    return ['exito' => false, 'mensaje' => 'Error al asignar el familiar.'];
                }
            } else {
                return ['exito' => false, 'mensaje' => 'El empleado no tiene ningún familiar por asignar.'];
            }
        }
        return ['exito' => false, 'mensaje' => 'No se pudo procesar el registro del familiar.'];
    }

    // actualziar data de familiar
    public function actulizarFamiliar(
        string $parentesco,
        string $cedulaEmpleado,
        string $primerNombre,
        string $segundoNombre,
        string $primerApellido,
        string $segundoApellido,
        string $cedula,
        string $edad,
        string $ano,
        string $mes,
        string $dia,
        string $numeroCarnet,
        string $tomo,
        string $folio,
        string $discapacidad,
        string $sexo,
        string $familiarInces
    ) {}
}
