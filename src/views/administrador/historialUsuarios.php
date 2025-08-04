<?php

use App\Atlas\config\App;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios | ATLAS</title>
    <?php require_once App::URL_INC . "total_css.php"; ?>
    <?php require_once App::URL_INC . "tablets_css.php"; ?>
    <link rel="stylesheet" href="<?php echo App::URL_CSS . "usuariosMovi.css"; ?>">

    <!-- <script src="./node_modules/Chart.js/auto/auto.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <?php require_once App::URL_INC . "load.php"; ?>
    <div class="app-wrapper conten-main" id="conten-main">
        <?php require_once App::URL_INC . "utils/menu.php"; ?>
        <!-- MODAL RESPONSIVEk -->
        <!-- CUERPO DEL SISTEMA -->
        <main class="app-main p-0 pb-4">
            <header class="imagen-pages mb-3" style="height: 75px;">
                <div class="d-flex align-items-center" style="position: absolute;">
                    <span class="ms-4 fw-bold fs-4 mt-3 text-white">Movimientos de usuarios</span>
                </div>
                <img src="<?php echo App::URL_IMG . "top-header.webp"; ?>" alt="Header Image" class="w-100 h-100" style="object-fit: cover; object-position:center;">
            </header>
            <?php require_once App::URL_INC . "utils/menu_usuarios.php" ?>
            <section class="card me-3 ms-3 mb-3 contentSubMenu" style="box-shadow: 0px 6px 16px 2px rgba(0, 0, 0, 0.05) !important;">
                <div class="p-3">
                    <div id="contenedor-buscar-usuario" class="search_bar_usuario">
                        <div class="row">
                            <div class="col-sm-10 col-md-11">
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa-regular fa-magnifying-glass"></i></span>
                                    <input type="text" class="form-control" id="buscadorUsuario" placeholder="Buscar datos de usuario" aria-label="Buscar datos de usuario" />
                                </div>
                            </div>
                            <div class="col-sm-2 col-md-1">
                                <div class="d-flex justify-content-end">
                                    <button type="button" id="butonUsuario" name="submit" class="btn btn-primary">
                                        Buscar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="container-fluid">
                <div id="contenedor-datos-usuario" class="">
                    <table id="tabla-datos-usuario" class="mitable table table-hover nowrap display">
                        <thead>
                            <tr id="tr-identity" class="tr-identity">
                            <th scope="col" class="bg-primary">Registros</th>
                            </tr>
                        </thead>
                        <tbody class="contenidoTable">
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
        <?php require_once App::URL_INC . "/footer.php"; ?>
    </div>


    <?php require_once App::URL_INC . "/scrips.php"; ?>
    <?php require_once App::URL_INC . "/tablets.php"; ?>

    <script src="./src/libs/select2/select2.min.js"></script>
    <script src="<?php echo App::URL_SCRIPS . "datosUsuario.js" ?>" type="module"></script>

</body>

</html>