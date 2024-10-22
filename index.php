<?php
require_once './vendor/autoload.php';

if (isset($_GET['views'])) {
    $url = explode("/", $_GET['views']);
} else {
    $url = ["login"];
}

use App\Atlas\controller\viewController;

$viewsController = new viewController();
$vista = $viewsController->obtenerVistasControlador($url[0]);
require_once $vista;
