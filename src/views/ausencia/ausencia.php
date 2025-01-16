<?php

use App\Atlas\config\App; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ausencia | ATLAS</title>
    <?php require_once App::URL_INC . "total_css.php"; ?>
    <link rel="stylesheet" href="<?php echo App::URL_CSS . "trabajadores.css"; ?>">
    <script src="<?php echo App::URL_NODE."bootstrap/dist/js/bootstrap.bundle.min.js";?>"></script>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <?php require("./src/views/inc/load.php"); ?>
    <div class="app-wrapper conten-main" id="conten-main">
        <?php require_once App::URL_INC . "/menu.php"; ?>

        <main class=" app-main p-0 pb-4">
            <div class="imagen-pages mb-3" style="height: 75px;">
                <div class="d-flex aling-items-center " style="position: absolute; ">
                    <span class="ms-4 fw-bold fs-4 mt-3 text-white">Registros del Personal</span>
                </div>
                <img src="<?php echo App::URL_IMG . "top-header.png"; ?>" alt="" class="w-100 h-100" style="object-fit: cover; object-position:center;">
            </div>
            <!-- SUB MENU DEL MODULO -->
            <?php require_once App::URL_INC . "menu_ausencia.php" ?>
            <!-- FORMULARIO DE ENVIOS DE DATOS DEL PERSONAL -->
            <div class="container-fluid px-4">
                <div class="container-fluid card p-2" style="background-color: #f5f5f5; box-shadow: none;">
                    <section class="card" style="background-color: white; box-shadow: none;">
                        <form action="" class="row p-2">
                            <div class="col-sm-12 col-md-7 col-lg-7 col-xl-7 col-xxl-8">
                                <div class="row">
                                    <div class="col-sm-12 mb-2">
                                        <p class="mb-0 mt-2">Datos del Personal</p>
                                        <hr class="mb-0 mt-0">
                                    </div>

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
                                            <label for="primerNombre">Nombre</label>
                                            <div class="input-group">
                                                <span class="input-group-text span_nombre"><i class="fa-regular fa-user"></i></span>
                                                <input type="text" class="form-control" id="primerNombre" name="primerNombre" placeholder="Nombre" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 mb-2">
                                        <div class="form-group">
                                            <label for="primerApellido">Apellido</label>
                                            <div class="input-group">
                                                <span class="input-group-text span_apellido"><i class="fa-regular fa-user"></i></span>
                                                <input type="text" class="form-control" id="primerApellido" name="primerApellido" placeholder="Apellido" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 mb-2">
                                        <div class="form-group">
                                            <label for="cargo">Cargo</label>
                                            <div class="input-group">
                                                <span class="input-group-text span_cargo"><i class="fa-regular fa-clipboard"></i></span>
                                                <input type="text" class="form-control" id="cargo" name="cargo" placeholder="Cargo" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 mb-3">
                                        <p class="mb-0 mt-2">Fecha De Ausencia</p>
                                        <hr class="mb-0 mt-0">
                                    </div>

                                    <div class="col-sm-6 mb-3">
                                        <div class="form-group">
                                            <label for="fecha_ini">Fecha Inicio</label>
                                            <div class="input-group">
                                                <span class="input-group-text span_fecha_ini"><i class="fa-regular fa-clipboard"></i></span>
                                                <input type="text" class="form-control" id="fecha_ini" name="fecha_ini" placeholder="Fecha Inicio" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 mb-3">
                                        <div class="form-group">
                                            <label for="fecha_fin">Fecha Fin</label>
                                            <div class="input-group">
                                                <span class="input-group-text span_fecha_fin"><i class="fa-regular fa-clipboard"></i></span>
                                                <input type="text" class="form-control" id="fecha_fin" name="fecha_fin" placeholder="Fecha Fin" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 mb-2">
                                        <div class="form-group">
                                            <label for="permiso">Persimos</label>
                                            <div class="input-group">
                                                <span class="input-group-text span_permiso"><i class="fa-solid fa-triangle-instrument"></i></span>
                                                <select class="form-select form-select-md estado-permiso" id="permiso" name="permiso" aria-label="Small select example" aria-placeholder="dasdas" required>
                                                    <option value="">Seleciona Un Permiso</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 mt-3 ">
                                        <button type="button" id="aceptar" name="submit" data-bs-toggle="modal" data-bs-target="#estadosInfor" class="btn btn-primary" disabled>
                                            <i class="fa-solid fa-plus me-2"></i>
                                            Aceptar
                                        </button>
                                        <button type="button" id="limpiar" name="submit" class="btn btn-warning" style="color: white;">
                                            <i class="fa-solid fa-rotate-right me-2"></i>Limpiar
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-5 col-lg-5 col-xl-5 col-xxl-4" style="height: 365px;">
                                <div class=" w-100 h-100 bg-white containerImg col-12 mb-3">
                                <div class="content d-flex justify-content-center align-items-center h-100 w-100" id="img-contener">
                                    <!-- Contenido aquí -->
                                </div>
                            </div>
                </div>

                </form>
                <div style="background-color:#FE9001;" class="barra_naranja w-100" id="barra"></div>
                </section>
            </div>
    </div>
    </main>
    <?php require_once App::URL_INC . "/footer.php"; ?>

    </div>
    <?php require_once App::URL_INC . "/scrips.php"; ?>

    <script src="<?php echo App::URL_SCRIPS . "ausencia.js" ?>" type="module"></script>
</body>

</html>