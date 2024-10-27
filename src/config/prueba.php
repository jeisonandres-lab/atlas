<?php
$cadena = "dasdadsadasad/////selectinsert";
$cadena = trim(stripslashes($cadena));
$cadena = htmlspecialchars($cadena, ENT_QUOTES, 'UTF-8');
$pattern = '/<script[^>]*>.*?<\/script>|SELECT|INSERT|DELETE|DROP|TRUNCATE|SHOW|<?php|?>|--/';
$completada = preg_replace($pattern, '', $cadena);
return $completada;
