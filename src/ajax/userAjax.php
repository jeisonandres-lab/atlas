<?php

namespace App\Atlas\ajax;
require_once '../../vendor/autoload.php';
use App\Atlas\controller\userController;

$user = new userController();
switch (isset($_POST['modulo_usuario'])) {
    
    case 'login':
        $respuesta = array(
            'exito' => true,
            'mensaje' => 'Datos recibidos correctamente.'
        );
        
        // Enviar la respuesta como JSON
        header('Content-Type: application/json');
        echo json_encode($respuesta);
        
    break;

    default:
        # code...
        break;
}