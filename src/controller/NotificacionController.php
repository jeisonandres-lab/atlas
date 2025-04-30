<?php

namespace App\Atlas\controller;

use App\Atlas\models\NotificacionModel;

date_default_timezone_set("America/Caracas");

class NotificacionController extends NotificacionModel
{
    public function __construct()
    {
        parent::__construct();
    }

    public function notificar() {}

    public function generarNotificacion(string $id, $idUserDirec, string $notificacion)
    {

        $data_json = [
            'exito' => false,
            'menssenger' => 'No se pudo enviar la notificación'
        ];

        $parametros = [
            [
                "campo_nombre" => "idUser",
                "campo_marcador" => ":idUser",
                "campo_valor" =>  $id
            ],
            [
                "campo_nombre" => "userRol",
                "campo_marcador" => ":userRol",
                "campo_valor" =>  $idUserDirec
            ],
            [
                "campo_nombre" => "notificacion",
                "campo_marcador" => ":notificacion",
                "campo_valor" => $notificacion
            ],
            [
                "campo_nombre" => "fecha",
                "campo_marcador" => ":fecha",
                "campo_valor" => date("Y-m-d")
            ],
            [
                "campo_nombre" => "hora",
                "campo_marcador" => ":hora",
                "campo_valor" =>  date("h:i:s A")
            ],

        ];

        $enviarNotificacion = $this->getGenerarNotificacion("notificaciones", $parametros);
        if ($enviarNotificacion) {
            $data_json = [
                'exito' => true,
                'menssenger' => 'Notificación enviada con éxito'
            ];
        }

        // Devolver la respuesta en formato JSON
        header('Content-Type: application/json');
        echo json_encode($data_json);
    }

    public function obtenerNotificacion($idRol)
    {

        $data_json = [
            'exito' => false, // Inicializamos a false por defecto
            'mensaje' => ''
        ];

        $data = [];
        $fecha = date("Y-m-d");
        $parametro = [$idRol, $fecha];
        $contadorNoti = $this->contarNotiRol($parametro);
        $data = [$contadorNoti];
        $notificacion = $this->buscarNotiRol($parametro);

        $data = [$notificacion, $contadorNoti];

        echo json_encode($data);
        header('Content-Type: application/json');
    }
}
