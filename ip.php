<!DOCTYPE html>
<html>

<head>
    <title>Generar Excel</title>
</head>

<body>
    <button id="generateButton">Generar Excel</button>

    <script>
        document.getElementById('generateButton').addEventListener('click', function() {
            const sexoFiltrado = 'Masculino'; // Valor que quieres enviar

            // Construir la URL con el parámetro sexo_filtrado
            const url = `./src/ajax/tablasDescargar.php?accion=impirimirEmpleadosSexoExcel&sexo_filtrado=${encodeURIComponent(sexoFiltrado)}`;

            fetch(url)
                .then(response => response.blob())
                .then(blob => {
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = 'datos_tabla.xlsx';
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                });
        });
    </script>
</body>

</html>
<?php
// Obtener la fecha y hora actual del servidor en formato ISO 8601
$fecha_hora_servidor = date('c');
echo $fecha_hora_servidor;

// También puedes obtener la hora en otros formatos
// por ejemplo, para obtener el timestamp unix.
$timestamp = time();
echo $timestamp;
?>