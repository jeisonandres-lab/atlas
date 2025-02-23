<?php

use App\Atlas\config\App;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ATLAS | Registros</title>
    <?php require_once App::URL_INC . "total_css.php"; ?>
    <?php require_once App::URL_INC . "tablets_css.php"; ?>
    <link rel="stylesheet" href="<?php echo App::URL_CSS . "registroFamiliares.css"; ?>">
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <?php require("./src/views/inc/load.php"); ?>
    <div class="app-wrapper conten-main" id="conten-main">
        <?php require_once App::URL_INC . "utils/menu.php"; ?>
        <!-- MODAL RESPONSIVEk -->
        <!-- CUERPO DEL SISTEMA -->
        <main class=" app-main p-0 pb-4">
            <!-- NOMBRE DEL MODULO -->
            <div class="imagen-pages mb-3" style="height: 75px;">
                <div class="d-flex aling-items-center " style="position: absolute; ">
                    <span class="ms-4 fw-bold fs-4 mt-3 text-white">Registros Del Personal Y Familiares</span>
                </div>
                <img src="<?php echo App::URL_IMG . "top-header.png"; ?>" alt="" class="w-100 h-100" style="object-fit: cover; object-position:center;">
            </div>
            <!-- SUB MENU DEL MODULO -->
            <?php require_once App::URL_INC . "utils/menu_bienestar.php" ?>
            <div class="container-fluid px-3">
                <div class="row">
                    <div class="col-lg-12">
                        <section class="card contenTable p-3" style="background-color: white; box-shadow: 0px 6px 16px 2px rgba(0, 0, 0, 0.05) !important;">
                            <div class="contenTablet mitable table-responsive">
                                <table id="myTable" class="mitable table  table-bordered table-hover nowrap display">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-secondary fw-medium">Trabajador</th>
                                            <th scope="col" class="text-secondary fw-medium">Correo</th>
                                            <th scope="col" class="text-secondary fw-medium">Cargo</th>
                                            <th scope="col" class="text-secondary fw-medium">Telefono</th>
                                            <th scope="col" class="text-secondary fw-medium">Descargar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>

                        </section>
                        <div style="background-color:#FE9001;" class="barra_naranja"></div>
                    </div>
                </div>

            </div>
        </main>
        <?php require_once App::URL_INC . "/footer.php"; ?>
    </div>


    <?php require_once App::URL_INC . "/scrips.php"; ?>
    <?php require_once App::URL_INC . "/tablets.php"; ?>

    <script src="./src/libs/select2/select2.min.js"></script>
    <script src="<?php echo App::URL_SCRIPS . "fichaTecnica.js" ?>" type="module"></script>

</body>

</html>