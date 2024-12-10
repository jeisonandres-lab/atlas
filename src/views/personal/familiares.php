<?php

use App\Atlas\config\App;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trabajadores | ATLAS</title>
    <?php require_once App::URL_INC . "icons.php"; ?>
    <link rel="stylesheet" href="<?php echo App::URL_CSS . "familiares.css"; ?>">
    <link rel="stylesheet" href="./src/libs/select2/select2.min.css">
    <link rel="stylesheet" href="./src/libs/animate/animate.min.css">
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <?php require("./src/views/inc/load.php"); ?>
    <div class="app-wrapper conten-main" id="conten-main">
        <?php require_once App::URL_INC . "/menu.php"; ?>
        <!-- MODAL RESPONSIVEk -->
        <!-- CUERPO DEL SISTEMA -->
        <main class=" app-main p-0 pb-4">
            <!-- NOMBRE DEL MODULO -->
            <div class="imagen-pages mb-3" style="height: 75px;">
                <div class="d-flex aling-items-center " style="position: absolute; ">
                    <span class="ms-4 fw-bold fs-4 mt-3 text-white">Registro De Familiares</span>
                </div>
                <img src="<?php echo App::URL_IMG . "top-header.png"; ?>" alt="" class="w-100 h-100" style="object-fit: cover; object-position:center;">
            </div>
            <!-- SUB MENU DEL MODULO -->
            <div class="card text-center me-3 ms-3 mb-3 contentSubMenu " style="box-shadow: none;">
                <div class="card-header ">
                    <ul class="nav nav-tabs card-header-tabs" id="list_sub_menu">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="true" id="personal" href="./personal">Personal</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="true" id="familiares" href="./familiares">Familiares</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " aria-current="true" id="registrosPersonal" href="./registrosPersonal">Registros</a>
                        </li>
                    </ul>
                </div>
            </div>
            <section class="botonSelect d-flex justify-content-center ms-3 me-3 mb-3">
                <div class="boton">
                    <button class="button" id="conCedula"><i class="fa-solid fa-address-card me-2"></i>Cedulado</button>
                    <button class="button" id="noCedulado"><i class="fa-solid fa-address-card me-2"></i>No Cedulado</button>
                    <button class="button" id="familiaJubilada"><i class="fa-solid fa-address-card me-2"></i>Jubilado</button>
                </div>
            </section>
            <!-- FORMULARIO DE ENVIOS DE DATOS DE EMPLEADO -->
            <form action="#" class="pe-3 ps-3 formulario_empleado row animate__animated animate__slideInUp contact-form form-validate justify-content-center" novalidate="novalidate" id="formulario_empleado">
                <div class=" col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-9 ">
                    <div class="row col-sm-12 col-md-9 h-100 bg-white w-100 p-3 m-0 content " id="formFamiliar">
                        
                    </div>
                    <div style="background-color:#FE9001;" class="barra_naranja"></div>
                </div>
            </form>
        </main>
        <?php require_once App::URL_INC . "/footer.php"; ?>
    </div>
    <?php require_once App::URL_INC . "/scrips.php"; ?>
    <script src="./src/libs/select2/select2.min.js"></script>
    <script src="<?php echo App::URL_SCRIPS . "familiares.js" ?>" type="module"></script>
</body>

</html>