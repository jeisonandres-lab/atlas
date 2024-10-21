<?php
if (isset($_GET['view']) && !empty($_GET['view'])) {
    $view = $_GET['view'];
    switch ($view) {
        case 'login':
            require_once './src/views/start/login.php';
            break;
        case 'home=2':
            echo "hola 2";
            break;
        default:
            echo "No se encontró el valor especificado para 'view'";
            break;
    }
} else {
    require './src/views/start/login.php';
}
