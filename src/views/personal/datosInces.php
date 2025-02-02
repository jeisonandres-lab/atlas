<?php

use App\Atlas\config\App;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ATLAS | Datos</title>
    <?php require_once App::URL_INC . "total_css.php"; ?>
    <?php require_once App::URL_INC . "tablets_css.php"; ?>
    <link rel="stylesheet" href="<?php echo App::URL_CSS . "registroFamiliares.css"; ?>">
    <link rel="stylesheet" href="<?php echo App::URL_CSS . "cssUtils/switch.css"; ?>">
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
                    <span class="ms-4 fw-bold fs-4 mt-3 text-white">Datos Empleados</span>
                </div>
                <img src="<?php echo App::URL_IMG . "top-header.png"; ?>" alt="" class="w-100 h-100" style="object-fit: cover; object-position:center;">
            </div>
            <!-- SUB MENU DEL MODULO -->
            <?php require_once App::URL_INC . "utils/menu_registro.php" ?>
            <div class="container-fluid px-4">
                <div class="container-fluid card p-2" style="background-color: #f5f5f5; box-shadow: none;">
                    <div class="">
                        <div class="row">
                            <div class="col-lg-12">
                                <section class="card contenTable" style="background-color: white; box-shadow: none;">
                                    <div class="contenTablet mitable table-responsive">
                                        <!-- Boton Switch -->
                                        <div class="card radio-inputs m-2" style="flex-direction: row; box-shadow: none;">
                                            <label class="radio " >
                                                <input name="radio" id="switchDepe" type="radio" />
                                                <span class="name card">Dependencia</span>
                                            </label>
                                            <label class="radio">
                                                <input name="radio" id="switchCargo" type="radio" />
                                                <span class="name">Cargo</span>
                                            </label>
                                            <label class="radio">
                                                <input name="radio" id="switchEstatus" type="radio" />
                                                <span class="name">Estatus</span>
                                            </label>
                                            <label class="radio">
                                                <input name="radio" id="switchDepa" type="radio" />
                                                <span class="name">Departamentos</span>
                                            </label>
                                        </div>
                                        <div class="container">
                                            <button class="mt-2 btn btn-primary btn-sm btn-hover-azul" data-bs-toggle="modal" data-bs-target="#agregarDatosDependencia" id="btnAgregarDependencia"><i class="fa-solid fa-plus fa-sm me-2"></i>Agregar</button>
                                            <button class="mt-2 btn btn-primary btn-sm btn-hover-azul" data-bs-toggle="modal" data-bs-target="#agregarDatosDependencia" id="btnAgregarCargo"><i class="fa-solid fa-plus fa-sm me-2"></i>Agregar</button>
                                            <button class="mt-2 btn btn-primary btn-sm btn-hover-azul" data-bs-toggle="modal" data-bs-target="#agregarDatosDependencia" id="btnAgregarEstatus"><i class="fa-solid fa-plus fa-sm me-2"></i>Agregar</button>
                                            <button class="mt-2 btn btn-primary btn-sm btn-hover-azul" data-bs-toggle="modal" data-bs-target="#agregarDatosDependencia" id="btnAgregarDepartamento"><i class="fa-solid fa-plus fa-sm me-2"></i>Agregar</button>
                                        </div>
                                        <table id="tableInic" class="mitable table table-striped table-bordered table-hover nowrap display">
                                            <thead>
                                                <tr id="tr-identity" class="tr-identity">

                                                </tr>
                                            </thead>
                                            <tbody class="contenidoTable">
                                            </tbody>
                                        </table>
                                    </div>
                                    <div style="background-color:#FE9001;" class="barra_naranja"></div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php require_once App::URL_INC . "/footer.php"; ?>
    </div>

    <?php require_once App::URL_INC . "/scrips.php"; ?>
    <?php require_once App::URL_INC . "/tablets.php"; ?>
    <script src="./src/libs/select2/select2.min.js"></script>
    <script src="<?php echo App::URL_SCRIPS . "datosDecd.js" ?>" type="module"></script>

</body>

</html>