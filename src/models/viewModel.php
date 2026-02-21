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
            // Login y Recuperacion
            'Identificarse' => 'src/views/login/login.php',
            'recuperarDatos' => 'src/views/login/recuperar.php',
            // Vistas Principales
            // Home
            'inicio' => 'src/views/home/home.php',

            // Registros de empleados
            'registrarEmpleado' => "src/views/personal/rgEmpleado.php",
            'registrosEmpleados' => "src/views/personal/rgsEmpleados.php",
            'registrarFamiliar' => "src/views/personal/rgFamiliar.php",
            'registrosFamiliares' => "src/views/personal/rgsFamiliares.php",

            'personal2' => "src/views/personal/registro-respaldo.php",


            'datosInces' => "src/views/personal/DatosInces.php",

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
