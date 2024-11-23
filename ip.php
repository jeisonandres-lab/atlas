<?php

$archivo = "data.txt"; //Nombre del archivo donde se almacenar la informacin.
   $d_ip = "Direccion IP: {$_SERVER["REMOTE_ADDR"]}\n"; //String con la direccin IP incluida.
   $fecha = "Fecha: ".date('D d S M,Y h:i a')."\n\n"; //String con la fecha y hora. 
   $user_agent = $_SERVER['HTTP_USER_AGENT'];
echo "Agente de usuario: " . $user_agent;
   $texto = $d_ip.$fecha; //String que se escribir en el archivo. 
   //Quedar algo a: 
   //Direccin IP: 127.0.0.1 (Para dar un ejemplo la ip local.)
   //Fecha: Fecha y hora en la cual el usuario entro a la url en su navegador.
   $fh = fopen($archivo, 'a'); //Se abre el archivo con el nombre "data.txt".
   fwrite($fh, $texto); //Se guarda el contenido de la variable "texto" en el archivo.
   fclose($fh); //Se cierra el archivo.


   $user_agent = $_SERVER['HTTP_USER_AGENT'];// me permite saber de donde se esta coenctando el usuario

   if (strpos($user_agent, 'Mobile') !== false || strpos($user_agent, 'Android') !== false || strpos($user_agent, 'iPhone') !== false || strpos($user_agent, 'iPad') !== false) 
    {
       echo "El usuario se ha conectado desde un dispositivo movil.";
   } else {
       echo "El usuario se ha conectado desde un ordenador.";
   }
?>