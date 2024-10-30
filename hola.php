<?php

// Obtener los datos del formulario
$nombre = $_POST['usuario'];
$email = $_POST['password'];

// Preparar la respuesta JSON
$respuesta = array(
    'exito' => true,
    'mensaje' => 'Datos recibidos correctamente.'
);

// Enviar la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($respuesta);
