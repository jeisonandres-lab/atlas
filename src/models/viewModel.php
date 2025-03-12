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
            'Identificarse' => 'src/views/start/login.php',
            'inicio' => 'src/views/home/home.php',
            'personal' => "src/views/personal/registro.php",
            'registrosFamiliares' => "src/views/personal/registrosFamiliares.php",
            'datosInces' => "src/views/personal/DatosInces.php",
            'familiares' => "src/views/personal/familiares.php",
            'registrosTotalFamilia' => "src/views/personal/registrosTotalFamilia.php",
            'ausencia' => "src/views/ausencia/ausencia.php",
            'vacaciones' => "src/views/ausencia/vacaciones.php",
            'historial' => "src/views/admin/usuarios.php",
            'usuarios' => "src/views/admin/totalusuarios.php",
            'datosPersonal' => "src/views/bienestarSocial/datosPersonal.php",
            'ficha' => "src/views/bienestarSocial/fichaTecnica.php",
            'error' => "src/error/error.html",
            'prueba' => "chart.html",
        ];
        // Obtener la ruta completa de la vista
        $rutaVista = $vistas[$vista] ?? null;

        // Verificar si la ruta existe y retornar la ruta o un 404
        if ($rutaVista && file_exists($rutaVista)) {
            return $rutaVista;
        } elseif ($vista == "Identificarse" || $vista == "index") {
            echo "Identificarse";
        } else {
            error::captureError("Vista no encontrada: $vista");
            header("location:Identificarse ");
        }
    }
}
