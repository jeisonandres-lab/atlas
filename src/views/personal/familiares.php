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
            <!-- FORMULARIO DE ENVIOS DE DATOS DE EMPLEADO -->
            <form action="#" class="pe-3 ps-3 formulario_empleado row animate__animated animate__slideInUp contact-form form-validate justify-content-center" novalidate="novalidate" id="formulario_empleado">
                <div class=" col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-9 ">
                    <div class="row col-sm-12 col-md-9 h-100 bg-white w-100 p-3 m-0 content">
                        <p class="mb-0 mt-2">Datos del Empleado</p>
                        <hr class="mb-3">
                        <div class="col-sm-4 mb-2">
                            <label class="form-label mb-0" for="cedula_trabajador">Cédula</label>
                            <div class="input-group">
                                <span class="input-group-text span_cedula_empleado "><i class="fa-regular fa-address-card"></i></span>
                                <input type="text" class="form-control " id="cedula_trabajador" name="cedula_familiar" placeholder="Cédula">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4 mb-2">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <div class="input-group">
                                    <span class="input-group-text span_nombre"><i class="fa-regular fa-user"></i></span>
                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Primer Nombre" required readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4 mb-2">
                            <div class="form-group">
                                <label for="apellido">apellido</label>
                                <div class="input-group">
                                    <span class="input-group-text span_apellido"><i class="fa-regular fa-user"></i></span>
                                    <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Primer Nombre" required readonly>
                                </div>
                            </div>
                        </div>

                        <p class="mb-0 mt-2">Datos Del Familiar</p>
                        <hr class="mb-3">
                        <div class="col-sm-6 col-md-6 mb-3">
                            <div class="form-group">
                                <label for="primerNombre">Primer Nombre</label>
                                <div class="input-group">
                                    <span class="input-group-text span_nombre1"><i class="fa-regular fa-user"></i></span>
                                    <input type="text" class="form-control" id="primerNombre" name="primerNombre" placeholder="Primer Nombre" required disabled>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-6 mb-3">
                            <div class="form-group">
                                <label for="segundoNombre">Segundo Nombre</label>
                                <div class="input-group ">
                                    <span class="input-group-text span_nombre2"><i class="fa-regular fa-user"></i></span>
                                    <input type="text" class="form-control" id="segundoNombre" name="segundoNombre" placeholder="Segundo Nombre" required disabled>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-6 mb-3">
                            <div class="form-group">
                                <label for="primerApellido">Primer Apellido</label>
                                <div class="input-group">
                                    <span class="input-group-text span_apellido1"><i class="fa-regular fa-user"></i></span>
                                    <input type="text" class="form-control" id="primerApellido" name="primerApellido" placeholder="Primer Apellido" required disabled>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-6 mb-3">
                            <div class="form-group">
                                <label for="segundoApellido">Segundo Apellido</label>
                                <div class="input-group">
                                    <span class="input-group-text span_apellido2"><i class="fa-regular fa-user"></i></span>
                                    <input type="text" class="form-control" id="segundoApellido" name="segundoApellido" placeholder="segundo Apellido" required disabled>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label for="cedula">Cédula</label>
                                <div class="input-group">
                                    <span class="input-group-text span_cedula"><i class="fa-regular fa-address-card"></i></span>
                                    <input type="text" class="form-control" id="cedula" name="cedula" placeholder="Cédula de Identidad" required disabled>
                                </div>
                            </div>
                            <p class="text-body-secondary">Este campo es opcional</p>
                        </div>

                        <div class="col-sm-6 col-md-6 ">
                            <div class="form-group">
                                <label for="cedula">Edad</label>
                                <div class="input-group">
                                    <span class="input-group-text span_edad"><i class="fa-regular fa-user"></i></span>
                                    <input type="number" class="form-control" id="edad" name="edad" placeholder="Cédula de Identidad" required disabled>
                                </div>
                            </div>
                        </div>

                        <p class="mb-0">Fecha de nacimiento</p>
                        <hr class="mb-2">

                        <div class="col-sm-4  ">
                            <div class="form-group">
                                <label class="required-field" for="message">Año</label>
                                <div class="input-group">
                                    <span class="input-group-text span_ano"><i class="fa-regular fa-calendar"></i></i></span>
                                    <select class="form-select form-select-md" name="ano" id="ano" required disabled></select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4  ">
                            <div class="form-group">
                                <label class="required-field" for="message">Mes</label>
                                <div class="input-group">
                                    <span class="input-group-text span_mes"><i class="fa-regular fa-calendar"></i></i></span>
                                    <select class="form-select" id="meses" name="meses" aria-label="Default select example" required disabled></select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4  mb-3">
                            <div class="form-group ">
                                <label class="required-field" for="message">Día</label>
                                <div class="input-group">
                                    <span class="input-group-text span_dia"><i class="fa-regular fa-calendar"></i></i></span>
                                    <select class="form-select w-5" id="dia" name="dia" aria-label="Default select example" required disabled></select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 ">
                            <button type="submit" id="aceptar_emepleado" name="aceptar" class="btn btn-primary" disabled style="display: none;">
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
    <script src="<?php echo App::URL_SCRIPS . "familiares.js" ?>" type="module"></script>
</body>

</html>