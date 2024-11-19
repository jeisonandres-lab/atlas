<?php

namespace App\Atlas\controller;

use App\Atlas\models\personalModel;
use App\Atlas\models\dependenciasModel;
use App\Atlas\models\estatusModel;

class personalController extends personalModel
{

    private $dependencia;
    private $estatus;

    // public function __construct(dependenciasModel $dependencia, estatusModel $estatus) {
    //     $this->dependencia = $dependencia;
    //     $this->estatus = $estatus;
    // }

    public function registro($primerNombre, $segundoNombre, $primerApellido, $segundoApellido, $cedula, $civil, $correo, $ano, $mes, $dia)
    {
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
        $data_json = [
            'exito' => false, // Inicializamos a false por defecto
            'mensaje' => ''
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
                "campo_nombre" => "correo",
                "campo_marcador" => ":correo",
                "campo_valor" => $correo
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
        $check_personal = $this->getExistePersonal($parametro);
        if ($check_personal == true) {
            $data_json['exito'] = false;
            $data_json['personalEncontrado'] = true;
            $data_json['mensaje'] = 'personal encontrado';
        } else {
            $registrarPersonal = $this->getRegistrar("datosPersonales", $personal_datos_reg);
            if ($registrarPersonal == true) {
                $check_personal_exis = $this->getDatosPersonal($parametro);
                if ($check_personal_exis == true) {
                    foreach ($check_personal_exis as $row) {
                        $data_json['exito'] = true;
                        $data_json['idPersonal'] = $row['id_personal'];
                        $data_json['cedula'] = $row['cedula'];
                        $data_json['nombre'] = $row['primerNombre'];
                        $data_json['apellido'] = $row['primerApellido'];
                        $data_json['mensaje'] = "Personal obtenido previamente registrado";
                    }
                } else {
                    $data_json['mensaje'] = "Error al consultar los datos del personal previamente registrado";
                }
            } else {
                $data_json['mensaje'] = "La consulta no se logro realizar correctamente";
            }
        }
        header('Content-Type: application/json');
        echo json_encode($data_json);
    }

    public function registroEmpleador($idPersonal, $idEstatus, $idCargo, $idDependencia, $idDepartamento, $idGrp, $especialidad, $telefono, $telOficina)
    {
        $idPersonal = $this->limpiarCadena($idPersonal);
        $idEstatus = $this->limpiarCadena($idEstatus);
        $idCargo = $this->limpiarCadena($idCargo);
        $idDependencia = $this->limpiarCadena($idDependencia);
        $idDepartamento = $this->limpiarCadena($idDepartamento);
        $idGrp = $this->limpiarCadena($idGrp);
        $especialidad = $this->limpiarCadena($especialidad);
        $telefono = $this->limpiarCadena($telefono);
        $telOficina = $this->limpiarCadena($telOficina);
    }

    // public function objetoDependencia()
    // {
    //     return $this->dependencia->getDatosDependencia();
    // }
    public function objetoDependencia()
    {
        return $this->dependencia = new dependenciasModel();
    }

    public function objetoEstatus()
    {
        return $this->estatus = new estatusModel();
    }

    protected function getEstatusPersonales()
    {
        $estatusPersonal = $this->objetoEstatus();
        return $estatusPersonal->getDatosEstatus();
    }

    protected function getCargoPersonales() {
        $cargoPersonal = $this->objetoEstatus();
        return $cargoPersonal->getDatosCargo();
    }
    protected function getDependenciasPersonales() {
        $dependenciaPersonal = $this->objetoDependencia();
        return $dependenciaPersonal->getDatosDependencia();
    }
    protected function getDepartamentosPersonales(){
        $departamentoPersonal = $this->objetoDependencia();
        return $departamentoPersonal->getDatosDepartamentos();
    }
}
