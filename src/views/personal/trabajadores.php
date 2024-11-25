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
    <link rel="stylesheet" href="<?php echo App::URL_CSS . "trabajadores.css"; ?>">
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
                    <span class="ms-4 fw-bold fs-4 mt-3 text-white">Registro trabajadores</span>
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
                            <a class="nav-link" aria-current="true" id="trabajadores" href="./trabajadores">Trabajadores</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " aria-current="true" id="registrosPersonal" href="./registrosPersonal">Registros</a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- FORMULARIO DE ENVIOS DE DATOS DE EMPLEADO -->
            <form action="#" class="formulario_empleado row animate__animated animate__slideInUp contact-form form-validate justify-content-center" novalidate="novalidate" id="formulario_empleado">
                <div class=" col-sm-12 col-md-7 col-lg-7 col-xl-8 col-xxl-5">
                    <div class="row col-sm-12 col-md-7 h-100 bg-white w-100 p-3 m-0 contenTrabajadores">
                        <p class="mb-0 mt-2">Registro de datos para empleado</p>
                        <hr class="mb-3">
                        <div class="col-sm-4 mb-2">
                            <label class="form-label mb-0" for="cedula_trabajador">Cédula</label>
                            <div class="input-group">
                                <span class="input-group-text span_cedula_empleado "><i class="fa-regular fa-user"></i></span>
                                <input type="text" class="form-control " id="cedula_trabajador" name="cedula" placeholder="Cédula">
                            </div>
                        </div>

                        <div class="col-sm-4 mb-2">
                            <label class="form-label mb-0" for="primerNombre">Nombre</label>
                            <div class="input-group">
                                <span class="input-group-text span_nombre_empleado "><i class="fa-regular fa-user"></i></span>
                                <input type="text" class="form-control " id="nombreTrabajador" name="primerNombre" placeholder="Nombre" disabled>
                            </div>
                        </div>

                        <div class="col-sm-4 mb-2">
                            <label class="form-label mb-0" for="apellido">Apellido</label>
                            <div class="input-group">
                                <span class="input-group-text span_apellido_empleado "><i class="fa-regular fa-user"></i></span>
                                <input type="text" class="form-control" id="apellidoTrabajador" name="apellido" placeholder="Apellido" disabled>
                            </div>
                        </div>
                        <div id="alert">
                            <div class="callout callout-danger">
                                <h5>I am a danger callout!</h5>

                                <p>There is a problem that we need to fix. A wonderful serenity has taken possession of my entire
                                    soul,
                                    like these sweet mornings of spring which I enjoy with my whole heart.</p>
                            </div>
                        </div>
                        <div class="col-sm-5 mb-2">
                            <label class="form-label mb-0" for="telefono">N.Telefono</label>
                            <div class="input-group">
                                <span class="input-group-text span_telefono"><i class="fa-regular fa-user"></i></span>
                                <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Telefono" required disabled>
                            </div>
                        </div>

                        <div class="col-sm-7 mb-2">
                            <div class="form-group">
                                <label for="estatus">Estatus</label>
                                <div class="input-group">
                                    <span class="input-group-text span_estatus"><i class="fa-regular fa-clipboard"></i></span>
                                    <select class="form-select form-select-md estado-estatus" id="estatus" name="estatus" aria-label="Small select example" aria-placeholder="dasdas" required disabled>
                                        <option value="">Selecione un estatus</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-5 mb-2">
                            <div class="form-group">
                                <label for="cargo">Cargo</label>
                                <div class="input-group">
                                    <span class="input-group-text span_cargo"><i class="fa-regular fa-clipboard"></i></span>
                                    <select class="form-select form-select-md estado-cargo" id="cargo" name="cargo" aria-label="Small select example" aria-placeholder="dasdas" required disabled>
                                        <option value="">Selecione un cargo</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-7 mb-2">
                            <div class="form-group">
                                <label for="departamento">Departamento</label>
                                <div class="input-group">
                                    <span class="input-group-text span_departamento"><i class="fa-regular fa-clipboard"></i></span>
                                    <select class="form-select form-select-md estado-departamento" id="departamento" name="departamento" aria-label="Small select example" aria-placeholder="dasdas" required disabled>
                                        <option value="">Selecione un departamento</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 mb-2">
                            <div class="form-group">
                                <label for="dependencia">Estado dependencia</label>
                                <div class="input-group">
                                    <span class="input-group-text span_dependencia"><i class="fa-regular fa-clipboard"></i></span>
                                    <select class="form-select form-select-md estado-dependencia" id="dependencia" name="dependencia" aria-label="Small select example" aria-placeholder="dasdas" required disabled>
                                        <option value="">Selecione la dependencia</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 ">
                            <button type="submit" id="aceptar_emepleado" name="submit" class="btn btn-primary" disabled style="display: none;">
                                <i class="fa-solid fa-plus me-2"></i>Aceptar
                            </button>
                            <button type="submit" id="buscador" name="buscar" class="btn btn-success">
                                <i class="fa-solid fa-magnifying-glass me-2"></i>Buscar
                            </button>
                            <button type="button" id="limpiar" name="submit" class="btn btn-warning" style="color: white;">
                                <i class="fa-solid fa-rotate-right me-2"></i>Limpiar
                            </button>
                        </div>
                    </div>
                    <div style="background-color:#FE9001;" class="barra_naranja"></div>
                </div>
            </form>
        </main>
        <?php require_once App::URL_INC . "/footer.php"; ?>
    </div>
    <?php require_once App::URL_INC . "/scrips.php"; ?>
    <script src="./src/libs/select2/select2.min.js"></script>
    <script src="<?php echo App::URL_SCRIPS . "trabajadores.js" ?>" type="module"></script>
</body>

</html>