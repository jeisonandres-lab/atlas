<?php
require_once './vendor/autoload.php';

use App\Atlas\config\error;
use App\Atlas\config\Conexion;

$error = new error();
$error->configuracion();

$conec = new Conexion();
$conec->validarConexion();
// if (isset($_GET['views'])) {
//     $url = explode("/", $_GET['views']);
// } else {
//     $url = ["login"];
// }
