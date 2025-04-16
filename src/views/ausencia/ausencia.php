<?php

use App\Atlas\config\App; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ausencia | ATLAS</title>
    <?php require_once App::URL_INC . "total_css.php"; ?>
    <?php require_once App::URL_INC . "tablets_css.php"; ?>

    <link rel="stylesheet" href="<?php echo App::URL_CSS . "trabajadores.css"; ?>">
    <link rel="stylesheet" href="<?php echo App::URL_CSS . "cssUtils/buttons.css"; ?>">
    <link rel="stylesheet" href="<?php echo App::URL_CSS . "cssUtils/colorTableButtons.css"; ?>">
    <link rel="stylesheet" href="./src/libs/jQueryUI/bootstrap-datepicker.css">
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
                <img src="<?php echo App::URL_IMG . "top-header.webp"; ?>" alt="" class="w-100 h-100" style="object-fit: cover; object-position:center;">
            </div>
            <!-- SUB MENU DEL MODULO -->
            <?php require_once App::URL_INC . "utils/menu_ausencia.php" ?>
            <!-- FORMULARIO DE ENVIOS DE DATOS DEL PERSONAL -->
            <div class="container-fluid px-3">
                <section class="card modalContent" style="background-color: white; box-shadow: none;">
                    <form action="" class="row p-2 formAusento" id="formAusento">
                        <div class="col-sm-12 col-md-7 col-lg-7 col-xl-7 col-xxl-8  p-3">
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
                                            <span class="input-group-text span_cedula"><i class="icons fa-regular fa-address-card"></i></span>
                                            <input type="text" class="form-control" id="cedula" name="cedula" placeholder="Cédula de Identidad" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 mb-2">
                                    <div class="form-group">
                                        <label for="cargo">Cargo</label>
                                        <div class="input-group">
                                            <span class="input-group-text span_cargo"><i class="icons fa-duotone fa-regular fa-arrows-down-to-people"></i></span>
                                            <input type="text" class="form-control" id="cargo" name="cargo" placeholder="Cargo" required readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 mb-2">
                                    <div class="form-group">
                                        <label for="primerNombre">Nombre</label>
                                        <div class="input-group">
                                            <span class="input-group-text span_nombre"><i class="icons fa-regular fa-user"></i></span>
                                            <input type="text" class="form-control" id="primerNombre" name="primerNombre" placeholder="Nombre" required readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 mb-2">
                                    <div class="form-group">
                                        <label for="primerApellido">Apellido</label>
                                        <div class="input-group">
                                            <span class="input-group-text span_apellido"><i class="icons fa-regular fa-user"></i></span>
                                            <input type="text" class="form-control" id="primerApellido" name="primerApellido" placeholder="Apellido" required readonly>
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
                                            <span class="input-group-text span_fecha_ini"><i class="icons fa-regular fa-calendars"></i></span>
                                            <input type="date" class="form-control fecha_ini" id="fecha_ini" name="fecha_ini" placeholder="Fecha Inicio" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <div class="form-group">
                                        <label for="fecha_fin">Fecha Fin</label>
                                        <div class="input-group">
                                            <span class="input-group-text span_fecha_fin"><i class="icons fa-regular fa-calendars"></i></span>
                                            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" placeholder="Fecha Fin" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="alert alert-danger mt-2" role="alert" id="alerta" style="display: none;">

                                    </div>
                                </div>

                                <div class="col-sm-12 mb-2">
                                    <div class="form-group">
                                        <label for="permiso">Persimos</label>
                                        <div class="input-group">
                                            <span class="input-group-text span_permiso"><i class="icons fa-solid fa-triangle-instrument"></i></span>
                                            <select class="form-select form-select-md estado-permiso" id="permiso" name="permiso" aria-label="Small select example" aria-placeholder="dasdas" required>
                                                <option value="">Seleciona Un Permiso</option>
                                                <option value="Administrativo">Administrativo</option>
                                                <option value="Descanso">Descanso</option>
                                                <option value="Urgencia">Urgencia</option>
                                                <option value="Vacaciones">Vacaciones</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 mt-3 ">
                                    <button type="submit" id="aceptar" name="submit" class="aceptar btn btn-success btn-hover-azul px-4 py-2 fs-6" disabled>
                                        <i class="fa-solid fa-plus me-2"></i>
                                        Aceptar
                                    </button>
                                    <button type="button" id="limpiar" name="submit" class="btn btn-warning btn-hover-amarillo px-4 py-2 fs-6">
                                        <i class="fa-solid fa-rotate-right me-2"></i>Limpiar
                                    </button>
                                    <button type="button" id="verAusencia" class="btn btn-primary btn-hover-azul  px-4 py-2 fs-6"  data-bs-toggle="modal" data-bs-target="#verAausencia">
                                        <i class="fa-regular fa-magnifying-glass me-2"></i>Ausencias
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-5 col-lg-5 col-xl-5 col-xxl-4 pt-3" style="height: 365px;">
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

            <!-- Modal Tabla Ausencia-->
            <div class="modal  fade modal-xl " id="verAausencia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header d-flex justify-content-between bg-primary" style=" color: #fff;">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Ausencias emitidas</h1>
                            <i type="button" data-bs-dismiss="modal" aria-label="Close" class="close fa-solid fa-xmark"></i>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid px-4">

                                <section class="card p-2" style="background-color: white; box-shadow: none;">
                                    <table id="myTable" class="mitable table table-striped table-hover nowrap display">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-white bg-primary">Nombre</th>
                                                <th scope="col" class="text-white text-center bg-primary">Cédula</th>
                                                <th scope="col" class="text-white text-center bg-primary">Permiso</th>
                                                <th scope="col" class="text-white text-center bg-primary">Fecha_inicio</th>
                                                <th scope="col" class="text-white text-center bg-primary">Fecha_fin</th>
                                                <th scope="col" class="text-white text-center bg-primary">Acciones</th>
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

            <!-- Modal Editar Ausencia-->
            <div class="modal  fade modal-lg " id="editarAausencia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header d-flex justify-content-between bg-primary" style=" color: #fff;">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Ausencias emitidas</h1>
                            <i type="button" data-bs-dismiss="modal" aria-label="Close" class="close fa-solid fa-xmark"></i>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid px-4">
                                <section class="card p-2 modalContent" style="background-color: white; box-shadow: none;">
                                    <form action="" class="row p-2 formEditarAusencia" id="formEditarAusencia">
                                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12  p-3">
                                            <div class="row pe-4 ps-4">
                                                <div class="col-sm-12 mb-2">
                                                    <p class="mb-0 mt-2">Datos del Personal</p>
                                                    <hr class="mb-0 mt-0">
                                                </div>

                                                <input type="text" id="identificador2" name="id" class="cumplido" readonly hidden>
                                                <div class="col-sm-6 mb-2">
                                                    <div class="form-group">
                                                        <label for="cedula">Cédula</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text span_cedula2"><i class="fa-regular fa-address-card"></i></span>
                                                            <input type="text" class="form-control" id="cedula2" name="cedula" placeholder="Cédula de Identidad" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6 mb-2">
                                                    <div class="form-group">
                                                        <label for="cargo">Cargo</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text span_cargo2"><i class="fa-regular fa-clipboard"></i></span>
                                                            <input type="text" class="form-control" id="cargo2" name="cargo" placeholder="Cargo" required readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6 mb-2">
                                                    <div class="form-group">
                                                        <label for="primerNombre">Nombre</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text span_nombre2"><i class="fa-regular fa-user"></i></span>
                                                            <input type="text" class="form-control" id="primerNombre2" name="primerNombre" placeholder="Nombre" required readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6 mb-2">
                                                    <div class="form-group">
                                                        <label for="primerApellido">Apellido</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text span_apellido2"><i class="fa-regular fa-user"></i></span>
                                                            <input type="text" class="form-control" id="primerApellido2" name="primerApellido" placeholder="Apellido" required readonly>
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
                                                            <span class="input-group-text span_fecha_ini2"><i class="fa-regular fa-clipboard"></i></span>
                                                            <input type="date" class="form-control fecha_ini" id="fecha_ini2" name="fecha_ini" placeholder="Fecha Inicio" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6 mb-3">
                                                    <div class="form-group">
                                                        <label for="fecha_fin">Fecha Fin</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text span_fecha_fin2"><i class="fa-regular fa-clipboard"></i></span>
                                                            <input type="date" class="form-control" id="fecha_fin2" name="fecha_fin" placeholder="Fecha Fin" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12">
                                                    <div class="alert alert-danger mt-2" role="alert" id="alerta2" style="display: none;">

                                                    </div>
                                                </div>

                                                <div class="col-sm-12 mb-2">
                                                    <div class="form-group">
                                                        <label for="permiso">Persimos</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text span_permiso2"><i class="fa-solid fa-triangle-instrument"></i></span>
                                                            <select class="form-select form-select-md estado-permiso" id="permiso2" name="permiso" aria-label="Small select example" aria-placeholder="dasdas" required>
                                                                <option value="">Seleciona Un Permiso</option>
                                                                <option value="Administrativo">Administrativo</option>
                                                                <option value="Descanso">Descanso</option>
                                                                <option value="Urgencia">Urgencia</option>
                                                                <option value="Vacaciones">Vacaciones</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12 mt-3 ">
                                                    <button type="submit" id="aceptar" name="submit" class="aceptar btn btn-primary" disabled>
                                                        <i class="fa-solid fa-plus me-3"></i>
                                                        Aceptar
                                                    </button>
                                                    <button type="button" id="limpiar" name="submit" class="btn btn-warning" style="color: white;">
                                                        <i class="fa-solid fa-rotate-right me-2"></i>Limpiar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
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
        </main>
        <?php require_once App::URL_INC . "/footer.php"; ?>

    </div>
    <?php require_once App::URL_INC . "/scrips.php"; ?>
    <?php require_once App::URL_INC . "/tablets.php"; ?>
    <script src="./src/libs/select2/select2.min.js"></script>
    <script src="<?php echo App::URL_SCRIPS . "ausencia.js" ?>" type="module"></script>
</body>

</html>