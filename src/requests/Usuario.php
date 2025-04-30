<?php

namespace App\Atlas\requests;

require_once '../../vendor/autoload.php';

use App\Atlas\config\Conexion;
use App\Atlas\controller\UsuarioController;
use App\Atlas\controller\NotificacionController;
use App\Atlas\config\Error;

/**
 * Este archivo actúa como router para las peticiones relacionadas con usuarios
 * Su función principal es recibir la petición y redirigirla al controlador correspondiente
 */

// Inicializar controladores y utilidades
$conexion = new Conexion();
$controladorUsuario = new UsuarioController();
$controladorLogin = new UsuarioController();
$controladorNotificacion = new NotificacionController();
$manejadorErrores = new Error();

try {
    // Validar que exista el módulo de usuario
    if (!isset($_GET['modulo_usuario'])) {
        throw new \InvalidArgumentException('Módulo de usuario no especificado');
    }

    // Obtener y limpiar el módulo
    $modulo = $conexion->limpiarCadena($_GET['modulo_usuario']);

    // Procesar la petición según el módulo
    switch ($modulo) {
        case 'login':
            // Validar credenciales
            $usuario = $conexion->limpiarCadena($_POST['usuario'] ?? '');
            $contrasena = $conexion->limpiarCadena($_POST['password'] ?? '');

            if (empty($usuario) || empty($contrasena)) {
                throw new \InvalidArgumentException('Usuario y contraseña son requeridos');
            }

            $controladorLogin->logearse($usuario, $contrasena);
            break;

        case 'redireccionar':
            // Redirigir al usuario
            $url = $_POST['url'] ?? '';
            if (empty($url)) {
                throw new \InvalidArgumentException('URL de redirección no especificada');
            }
            echo $controladorLogin->redireccionarUsuario($url);
            break;

        case 'cerrarSession':
            // Cerrar sesión
            $url = $_POST['url'] ?? '';
            echo $controladorLogin->cerrarSession_total($url);
            break;

        case 'datosUsuariosBasicos':
            // Obtener datos básicos de usuarios
            $controladorUsuario->datosUsuariosBasicos();
            break;

        case 'DatosUsuarios':
            // Obtener datos completos de usuarios
            $controladorUsuario->datosUsuarios();
            break;

        case 'desactivarUsuario':
            // Desactivar un usuario
            $id = $conexion->limpiarCadena($_POST['id'] ?? '');
            if (empty($id)) {
                throw new \InvalidArgumentException('ID de usuario no especificado');
            }
            $controladorUsuario->desactivarUsuario($id);
            break;

        case 'actualizarDatosUsuario':
            // Actualizar datos de usuario
            $id = $conexion->limpiarCadena($_POST['id'] ?? '');
            if (empty($id)) {
                throw new \InvalidArgumentException('ID de usuario no especificado');
            }
            $controladorUsuario->desactivarUsuario($id);
            break;

        default:
            throw new \InvalidArgumentException('Módulo de usuario no válido');
    }

} catch (\Exception $e) {
    // Manejar errores
    $manejadorErrores->captureError();

    // Enviar respuesta de error
    header('Content-Type: application/json');
    echo json_encode([
        'exito' => false,
        'mensaje' => $e->getMessage()
    ]);
}