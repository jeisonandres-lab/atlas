<?php

use App\Atlas\config\App; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vacaciones | ATLAS</title>
    <?php require_once App::URL_INC . "total_css.php"; ?>
    <?php require_once App::URL_INC . "tablets_css.php"; ?>

    <link rel="stylesheet" href="<?php echo App::URL_CSS . "trabajadores.css"; ?>">
    <link rel="stylesheet" href="<?php echo App::URL_CSS . "cssUtils/buttons.css"; ?>">
    <link rel="stylesheet" href="<?php echo App::URL_CSS . "cssUtils/colorTableButtons.css"; ?>">
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <?php require("./src/views/inc/load.php"); ?>
    <div class="app-wrapper conten-main" id="conten-main">
        <?php require_once App::URL_INC . "utils/menu.php"; ?>

        <main class=" app-main p-0 pb-4">
            <div class="imagen-pages mb-3" style="height: 75px;">
                <div class="d-flex aling-items-center " style="position: absolute; ">
                    <span class="ms-4 fw-bold fs-4 mt-3 text-white">Registros del Personal</span>
                </div>
                <img src="<?php echo App::URL_IMG . "top-header.png"; ?>" alt="" class="w-100 h-100" style="object-fit: cover; object-position:center;">
            </div>
            <!-- SUB MENU DEL MODULO -->
            <?php require_once App::URL_INC . "utils/menu_vacaciones.php" ?>
            <!-- FORMULARIO DE ENVIOS DE DATOS DEL PERSONAL -->
            <div class="container-fluid px-3">
                <section class="card modalContent" style="background-color: white; box-shadow: none;">
                    <form action="" class="row p-2 formVacaciones" id="formVacaciones">
                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-12  p-3">
                            <div class="row pe-4 ps-4">
                                <div class="col-sm-12 mb-2">
                                    <p class="mb-0 mt-2">Datos del Personal</p>
                                    <hr class="mb-0 mt-0">
                                </div>

                                <input type="text" id="identificador" name="id" class="cumplido" readonly hidden>
                                <div class="col-sm-6 mb-2">
                                    <div class="form-group">
                                        <label for="cedula">Cédula</label>
                                        <div class="input-group">
                                            <span class="input-group-text span_cedula"><i class="fa-regular fa-address-card"></i></span>
                                            <input type="text" class="form-control" id="cedula" name="cedula" placeholder="Cédula de Identidad" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 mb-2">
                                    <div class="form-group">
                                        <label for="cargo">Cargo</label>
                                        <div class="input-group">
                                            <span class="input-group-text span_cargo"><i class="fa-regular fa-clipboard"></i></span>
                                            <input type="text" class="form-control" id="cargo" name="cargo" placeholder="Cargo" required readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 mb-2">
                                    <div class="form-group">
                                        <label for="primerNombre">Nombre</label>
                                        <div class="input-group">
                                            <span class="input-group-text span_nombre"><i class="fa-regular fa-user"></i></span>
                                            <input type="text" class="form-control" id="primerNombre" name="primerNombre" placeholder="Nombre" required readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 mb-2">
                                    <div class="form-group">
                                        <label for="primerApellido">Apellido</label>
                                        <div class="input-group">
                                            <span class="input-group-text span_apellido"><i class="fa-regular fa-user"></i></span>
                                            <input type="text" class="form-control" id="primerApellido" name="primerApellido" placeholder="Apellido" required readonly>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-sm-12 mb-3">
                                    <p class="mb-0 mt-2">Año Asignar</p>
                                    <hr class="mb-0 mt-0">
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <div class="form-group">
                                        <label for="ano">Año</label>
                                        <div class="input-group">
                                            <span class="input-group-text span_ano"><i class="fa-regular fa-clipboard"></i></span>
                                            <select class="form-control ano" id="ano" name="ano" required></select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4 mb-3 col-xxl-2">
                                    <div class="form-group">
                                        <label for="dias">Dias</label>
                                        <div class="input-group">
                                            <span class="input-group-text span_dias"><i class="fa-regular fa-clipboard"></i></span>
                                            <input type="number" class="form-control dias" id="dias" name="dias" placeholder="Dias" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 mt-3 ">
                                    <button type="submit" id="aceptar" name="submit" class="aceptar btn btn-success btn-hover-verde px-4 py-2 fs-6" disabled>
                                        <i class="fa-solid fa-plus fa-sm me-2"></i>
                                        Aceptar
                                    </button>
                                    <button type="button" id="limpiar" name="submit" class="btn btn-warning btn-hover-amarillo px-4 py-2 fs-6">
                                        <i class="fa-solid fa-rotate-right fa-sm me-2"></i>Limpiar
                                    </button>
                                    <button type="button" id="verVacaciones" class="btn btn-primary  btn-hover-azul px-4 py-2 fs-6" data-bs-toggle="modal" data-bs-target="#verAausencia">
                                        <i class="fa-regular fa-magnifying-glass fa-sm me-2"></i>Vacaciones
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div style="background-color:#FE9001;" class="barra_naranja w-100" id="barra"></div>
                </section>
            </div>
        </main>
        <!-- Modal Tabla vacaciones-->
        <div class="modal  fade modal-xl " id="verAausencia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between bg-primary" style=" color: #fff;">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Vacaciones Emitidas</h1>
                        <i type="button" data-bs-dismiss="modal" aria-label="Close" class="close fa-solid fa-xmark"></i>
                    </div>
                    <div class="modal-body px-1">
                        <div class="container-fluid px-1">

                            <section class="card p-2" style="background-color: white; box-shadow: none;">
                                <table id="myTable" class="mitable table table-striped table-hover nowrap display">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="bg-primary fw-medium">Trabajador</th>
                                            <th scope="col" class="bg-primary fw-medium">Correo</th>
                                            <th scope="col" class="bg-primary fw-medium">Cargo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </section>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                            <i class="fa-solid fa-arrow-right me-2"></i>Cerrar
                        </button>
                    </div>
                    <div style="background-color:#FE9001;" class="barra_naranja"></div>
                </div>
            </div>
        </div>
        <?php require_once App::URL_INC . "/footer.php"; ?>

    </div>
    <?php require_once App::URL_INC . "/scrips.php"; ?>
    <?php require_once App::URL_INC . "/tablets.php"; ?>
    <script src="./src/libs/select2/select2.min.js"></script>
    <script src="<?php echo App::URL_SCRIPS . "vacaciones.js" ?>" type="module"></script>
</body>

</html>