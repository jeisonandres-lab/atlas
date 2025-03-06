<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desplazamiento con Bootstrap 5</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body data-bs-spy="scroll" data-bs-target="#navbar-example">

    <nav id="navbar-example" class="navbar navbar-light bg-light px-3">
        <a class="navbar-brand" href="#">Mi Página</a>
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link" href="#contacto">Contacto</a>
            </li>
        </ul>
    </nav>

    <div data-bs-offset="0" class="scrollspy-example" tabindex="0">
        <div id="contenido">
            <p>Contenido de la página...</p>
            <p>Más contenido...</p>
            <p>Mucho más contenido...</p>
            <p>Contenido adicional...</p>
            <p>Contenido de relleno...</p>
            <p>Contenido de relleno...</p>
            <p>Contenido de relleno...</p>
            <p>Contenido de relleno...</p>
            <p>Contenido de relleno...</p>
            <p>Contenido de relleno...</p>
            <p>Contenido de relleno...</p>
            <p>Contenido de relleno...</p>
            <p>Contenido de relleno...</p>
            <p>Contenido de relleno...</p>
            <p>Contenido de relleno...</p>
        </div>
        <div id="contacto">
            <h2>Contacto</h2>
            <p>Aquí va la información de contacto...</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>