<?php

namespace App\Atlas\models;

use App\Atlas\config\error;


class viewModel extends error
{
    /*---------- Modelo obtener vista ----------*/
    protected function obtenerVistasModelo($vista)
    {
        error::captureError();

        // Configuración de rutas de vistas
        $vistas = [
            'login' => 'src/views/start/login.php',
            'home' => 'src/views/home/hom.php',
            'error' => "src/config/error.html",
        ];
        // Obtener la ruta completa de la vista
        $rutaVista = $vistas[$vista] ?? null;

        // Verificar si la ruta existe y retornar la ruta o un 404
        if ($rutaVista && file_exists($rutaVista)) {
            return $rutaVista;
        } elseif ($vista == "login" || $vista == "index") {
            echo "login";
        } else {
            error::captureError("Vista no encontrada: $vista");
            header("location:error ");
        }
    }
}
