<?php

use App\Atlas\config\App;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro | ATLAS</title>
    <?php require_once App::URL_INC . "icons.php"; ?>
    <link rel="stylesheet" href="<?php echo App::URL_CSS . "registroPersonal.css"; ?>">
    <link rel="stylesheet" href="./src/libs/select2/select2.min.css">
    <link rel="stylesheet" href="./src/libs/animate/animate.min.css">
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <?php require("./src/views/inc/load.php"); ?>
    <div class="app-wrapper conten-main" id="conten-main">
        <?php require_once App::URL_INC . "/menu.php"; ?>
        <!-- MODAL RESPONSIVEk -->
            <!-- CUERPO DEL SISTEMA -->
            <main class=" app-main p-0">
                <!-- NOMBRE DEL MODULO -->
                <div class="imagen-pages mb-3" style="height: 75px;" >
                    <div class="d-flex aling-items-center " style="position: absolute; ">
                        <span class="ms-4 fw-bold fs-4 mt-3 text-white">Registros del Personal</span>
                    </div>
                    <img src="<?php echo App::URL_IMG . "top-header.png"; ?>" alt="" class="w-100 h-100" style="object-fit: cover; object-position:center;">
                </div>
                <!-- SUB MENU DEL MODULO -->
                <div class="card text-center me-3 ms-3 mb-3 contentSubMenu">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs" id="list_sub_menu">
                            <li class="nav-item">
                                <a class="nav-link" aria-current="true" id="personal" href="./personal">Personal</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " aria-current="true" id="registrosPersonal"href="./registrosPersonal">Registros</a>
                            </li>
                        </ul>
                    </div>
                </div>

            </main>
            <?php require_once App::URL_INC . "/footer.php"; ?>
        </div>
        <?php require_once App::URL_INC . "/scrips.php"; ?>
        <script src="./src/libs/select2/select2.min.js"></script>
        <script src="<?php echo App::URL_SCRIPS . "registroPersonal.js" ?>" type="module"></script>
</body>

</html>