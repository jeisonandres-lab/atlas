<?php

namespace App\Atlas\controller;

use App\Atlas\models\personalModel;
use App\Atlas\controller\fileUploaderController;
use App\Atlas\models\tablasModel;
use App\Atlas\config\App;

date_default_timezone_set("America/Caracas");

class familiarController extends personalModel
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


    // FUNCION PARA BUSCAR LOS FAMILIAR EN ESTUS PENDIENTES
    public function buscarFamilairPendiente(string $cedula): array
    {
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
        $numeroCarnet = null,
        string $tomo,
        string $folio,
        $discapacidad = null,
        string $sexo,
        string $familiarInces
        
    ) {

        // datos del trabajador
        $Datosempleado = $this->getTotalDatosPE([$cedulaEmpleado]);

        // validar que si tenga datos
        if (empty($Datosempleado)) {

            // recorres array de los datos
            foreach ($Datosempleado as $row) {
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

                // validar si existe este familiar por cedula, tomo y folio
                $check_familiar_exis = $this->getExisteFamilar([$cedula, $tomo, $folio]);
                if ($check_familiar_exis) {
                    // si salio bien es porque se encontro un familiar
                    $data_json['exito'] = true;
                    $data_json['mensaje'] = $check_familiar_exis['mensaje'];
                } else {

                    // en caso que el familiar sea trabajador inces
                    if ($parentesco == "estado") {
                        # code...
                    }
                    // en caso en que no lo consiga podemos registrar
                    $check_familiar = $this->getRegistrar('datosFamilia', $parametrosFamilia);
                    if ($check_familiar) {
                        // si se registro exitosamente podemos cargar la auditoria del registro
                        $registroAuditoria = $this->auditoriaController->registrarAuditoria($this->idUsuario, 'Registrar familiar', 'El usuario ' . $this->nombreUsuario . ' asigno un nuevo familiar en el sistema al empleado ' . $nombreEmpleado . ' ' . $apellidoEmpleado . ' portador de la cedula ' . $cedulaEmpleado . ' el familiar asignado fue ' . $primerNombre . ' ' . $primerApellido . '.');

                        // si se carga la auditoria correctamente
                        if ($registroAuditoria) {
                            $data_json["exitoAuditoria"] = true;
                            $data_json['messengerAuditoria'] = "Auditoria registrada con exito.";
                        } else {
                            $data_json["exitoAuditoria"] = false;
                            $data_json['messengerAuditoria'] = "Error al registrar la auditoria.";
                        }






                    } else {

                        //en caso de que el registro del familiar falle
                        $data_json['exito'] = false;
                        $data_json['mensaje'] = 'El familiar no se logro registrar correctamente';
                    }
                }
            }
        }else{

            //en caso de que la validacion del trabajador falle
            $data_json['exito'] = false;
            $data_json['mensaje'] = 'El empleado al que se le intenta afiliar el familiar no se logra encontrar.';
        }
    }

    public function actulizarFamiliar(){}


}
