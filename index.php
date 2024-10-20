<?php
require_once './vendor/autoload.php';
use App\Atlas\config\Conexion;

$conec = new Conexion();
$conec->validarConexion();
// if (isset($_GET['views'])) {
//     $url = explode("/", $_GET['views']);
// } else {
//     $url = ["login"];
// }
