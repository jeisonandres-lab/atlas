<?php
// index.php
if (isset($_COOKIE)) {
    foreach ($_COOKIE as $key => $value) {
        setcookie($key, '', time() - 3600, '/'); // Ruta raíz
        setcookie($key, '', time() - 3600, '/', '.' . $_SERVER['HTTP_HOST']); // Subdominios
    }
}


if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
} else {
    // Si el usuario está logeado, redirige a otra página o muestra contenido personalizado
} 