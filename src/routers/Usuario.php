<?php

namespace App\Atlas\routers;

/**
 * Router de Usuario
 *
 * Este archivo maneja todas las peticiones relacionadas con usuarios del sistema.
 * Recibe peticiones GET con el parámetro 'modulo_usuario' que determina la acción a ejecutar.
 *
 * @package App\Atlas\routers
 */

require_once '../../vendor/autoload.php';

use App\Atlas\controller\usuario\LoginController;
use App\Atlas\config\Peticiones;
use App\Atlas\controller\usuario\DatosUsuarios;
// use App\Atlas\controller\sistema\NotificacionController;

// Inicialización de controladores
$userLogin = new LoginController();
$peticion = new Peticiones();
$DatosUsuario = new DatosUsuarios();

// Extracción de variables de la petición
$variables = $peticion->obtenerVariables();
extract($variables);

// Validación de que existe el módulo de usuario en la petición
if (!isset($_GET['modulo_usuario'])) {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'Módulo de usuario no especificado']);
    exit;
}

// Router principal - Manejo de peticiones según el módulo
switch ($_GET['modulo_usuario']) {
    case 'login':
        // Autenticación de usuario
        $userLogin->logearse($usuario, $password);
        break;

    case 'cerrarSession':
        // Cierre de sesión del usuario
        $url = $_POST['url'] ?? '';
        echo $userLogin->cerrarSession_total($url);
        break;

    case 'datosUsuariosBasicos':
        // Obtención de datos básicos del usuario
        $DatosUsuario->datosUsuariosBasicos();
        break;

    case 'DatosUsuarios':
        // Obtención de datos completos del usuario
        $usercontroller->datosUsuarios();
        break;

    case 'desactivarUsuario':
        // Desactivación de un usuario específico
        $usercontroller->desactivarUsuario($id);
        break;

    case 'actualizarDatosUsuario':
        // Actualización de datos de usuario
        $usercontroller->desactivarUsuario($id);
        break;

    default:
        // Respuesta para módulos no reconocidos
        header('HTTP/1.1 404 Not Found');
        echo json_encode(['error' => 'Módulo de usuario no encontrado']);
        break;
}
