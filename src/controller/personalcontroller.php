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

    public function registro($primerNombre, $segundoNombre, $primerApellido, $segundoApellido, $cedula, $civil, $correo, $ano, $mes, $dia, $idEstatus, $idCargo, $idDependencia, $idDepartamento, $telefono)
    {
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
                            $parametro =[$idPersonal];
                            $check_empleado_exis = $this->getExisteEmpleado($parametro);
                            if ($check_empleado_exis) {
                                $data_json['exito'] = true;
                                $data_json['mensaje'] = "Este trabajador ya esta registrado";
                            }else{
                                $check_empleado = $this->getRegistrarEmpleado("datosempleados", $empleados_datos_reg);
                                if($check_empleado == true){
                                    $data_json['exito'] = true;
                                    $data_json['mensaje'] = "Empleado guardado con exito";
                                }else{
                                    $data_json['exito'] = true;
                                    $data_json['mensaje'] = "No se logro realizar la consulta";
                                }
                            }
                        }else{
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
        header('Content-Type: application/json');
        echo json_encode($data_json);
    }

    public function obtenerDatosPersonal($cedula_familiar){
        $cedula_familiar = $this->limpiarCadena($cedula_familiar);
        $data_json = [
            'exito' => false, // Inicializamos a false por defecto
            'mensaje' => 'data del principio',
        ];

            $parametro = [$cedula_familiar];
            $check_personal = $this->getDatosPersonal($parametro);
                foreach($check_personal as $row){
                    $data_json['exito'] = true;
                    $data_json['idPersonal'] = $row['id_personal'];
                    $data_json['cedula'] = $row['cedula'];
                    $data_json['nombre'] = $row['primerNombre'];
                    $data_json['apellido'] = $row['primerApellido'];
                    $data_json['mensaje'] = "Personal obtenido previamente registrado";
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
}
