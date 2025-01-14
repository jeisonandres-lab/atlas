<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

</body>
</html>
<script>
    // Obtén el parámetro 'id' de la URL
const urlParams = new URLSearchParams(window.location.search);
const idPersonal = urlParams.get('id');

// Imprime el valor del parámetro 'id' en la consola del navegador
console.log("ID Personal:", idPersonal);
</script>