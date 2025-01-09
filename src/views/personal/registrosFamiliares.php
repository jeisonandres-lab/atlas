<?php

use App\Atlas\config\App;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro | ATLAS</title>
    <?php require_once App::URL_INC . "total_css.php"; ?>
    <?php require_once App::URL_INC . "tablets_css.php"; ?>
    <link rel="stylesheet" href="<?php echo App::URL_CSS . "registroFamiliares.css"; ?>">
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <?php require("./src/views/inc/load.php"); ?>
    <div class="app-wrapper conten-main" id="conten-main">
        <?php require_once App::URL_INC . "/menu.php"; ?>
        <!-- MODAL RESPONSIVEk -->
        <!-- CUERPO DEL SISTEMA -->
        <main class=" app-main p-0">
            <!-- NOMBRE DEL MODULO -->
            <div class="imagen-pages mb-3" style="height: 75px;">
                <div class="d-flex aling-items-center " style="position: absolute; ">
                    <span class="ms-4 fw-bold fs-4 mt-3 text-white">Registros del Personal</span>
                </div>
                <img src="<?php echo App::URL_IMG . "top-header.png"; ?>" alt="" class="w-100 h-100" style="object-fit: cover; object-position:center;">
            </div>
            <!-- SUB MENU DEL MODULO -->
            <?php require_once App::URL_INC . "menu_registro.php" ?>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <section class="card m-1 contenTable" style="background-color: white; box-shadow: none;">
                            <div class="contenTablet mitable table-responsive">
                                <!-- Boton Switch -->
                                <div class="togglewrapper m-2">
                                    <input type="checkbox" name="" id="dn" class="dn">
                                    <label for="dn" class="toggle">
                                        <span class="toggle_handler"></span>
                                    </label>
                                </div>
                                <table id="myTable" class="mitable table table-striped table-bordered table-hover nowrap display">
                                    <thead>
                                        <tr>
                                            <th scope="col">Cédula</th>
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Estatus</th>
                                            <th scope="col">Dependencia</th>
                                            <th scope="col">Cargo</th>
                                            <th scope="col">Departamento</th>
                                            <th scope="col">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div style="background-color:#FE9001;" class="barra_naranja"></div>
                        </section>
                    </div>
                </div>
            </div>
        </main>
        <?php require_once App::URL_INC . "/footer.php"; ?>
    </div>
    <?php require_once App::URL_INC . "/scrips.php"; ?>
    <?php require_once App::URL_INC . "/tablets.php"; ?>

    <script src="<?php echo App::URL_SCRIPS . "registroFamiliar.js" ?>" type="module"></script>

</body>

</html>