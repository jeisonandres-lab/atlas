<?php

namespace App\Atlas\controller;

use App\Atlas\models\personalModel;

class personalController extends personalModel
{

    public function registro($primerNombre, $segundoNombre, $primerApellido, $segundoApellido, $cedula, $civil, $correo, $ano, $mes, $dia){
        $primerNombre = $this->limpiarCadena($primerNombre);
        $segundoNombre = $this->limpiarCadena($segundoNombre);
        $primerApellido= $this->limpiarCadena($primerApellido);
        $segundoApellido = $this->limpiarCadena($segundoApellido);
        $cedula = $this->limpiarCadena($cedula);
        $civil = $this->limpiarCadena($civil);
        $correo = $this->limpiarCadena($correo);
        $ano = $this->limpiarCadena($ano);
        $mes = $this->limpiarCadena($mes);
        $dia = $this->limpiarCadena($dia);

        $personal_datos_reg=[
            [
                "campo_nombre"=>"primerNombre",
                "campo_marcador"=>":primerNombre",
                "campo_valor"=>$primerNombre
            ],
            [
                "campo_nombre"=>"segundoNombre",
                "campo_marcador"=>":segundoNombre",
                "campo_valor"=>$segundoNombre
            ],
            [
                "campo_nombre"=>"primerApellido",
                "campo_marcador"=>":primerApellido",
                "campo_valor"=>$primerApellido
            ],
            [
                "campo_nombre"=>"segundoApellido",
                "campo_marcador"=>":segundoApellido",
                "campo_valor"=>$segundoApellido
            ],
            [
                "campo_nombre"=>"cedula",
                "campo_marcador"=>":cedula",
                "campo_valor"=>$cedula
            ],
            [
                "campo_nombre"=>"estadoCivil",
                "campo_marcador"=>":estadoCivil",
                "campo_valor"=>$civil
            ],
            [
                "campo_nombre"=>"correo",
                "campo_marcador"=>":correo",
                "campo_valor"=>$correo
            ],
            [
                "campo_nombre"=>"anoNacimiento",
                "campo_marcador"=>":anoNacimiento",
                "campo_valor"=>$ano
            ],
            [
                "campo_nombre"=>"mesNacimiento",
                "campo_marcador"=>":mesNacimiento",
                "campo_valor"=>$mes
            ],
            [
                "campo_nombre"=>"diaNacimiento",
                "campo_marcador"=>":diaNacimiento",
                "campo_valor"=>$dia
            ],
            [
                "campo_nombre"=>"fecha",
                "campo_marcador"=>":fecha",
                "campo_valor"=>date("Y-m-d")
            ],
            [
                "campo_nombre"=>"hora",
                "campo_marcador"=>":hora",
                "campo_valor"=>date("H:i:s")
            ]
        ];

        $registrarPersonal = $this->getRegistrar("datosPersonales", $personal_datos_reg);
        if($registrarPersonal->rowCount()==1){
            echo "datos si se registraron";
        }

        header('Content-Type: application/json');
        echo json_encode($registrarPersonal);
    }
}
