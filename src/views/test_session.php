<?php
// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Mostrar información de la sesión
echo '<h2>Información de la Sesión</h2>';
echo '<pre>';
echo 'Estado de la sesión: ' . session_status() . "\n";
echo 'ID de la sesión: ' . session_id() . "\n";
echo 'Nombre de la sesión: ' . session_name() . "\n";
echo 'Cookie de sesión: ';
print_r($_COOKIE);
echo "\nVariables de sesión: ";
print_r($_SESSION);
echo '</pre>';

// Mostrar información del servidor
echo '<h2>Información del Servidor</h2>';
echo '<pre>';
echo 'session.save_path: ' . ini_get('session.save_path') . "\n";
echo 'session.cookie_lifetime: ' . ini_get('session.cookie_lifetime') . "\n";
echo 'session.cookie_path: ' . ini_get('session.cookie_path') . "\n";
echo 'session.cookie_domain: ' . ini_get('session.cookie_domain') . "\n";
echo 'session.cookie_secure: ' . ini_get('session.cookie_secure') . "\n";
echo 'session.cookie_httponly: ' . ini_get('session.cookie_httponly') . "\n";
echo '</pre>';