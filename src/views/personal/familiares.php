<?php

use App\Atlas\config\App;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trabajadores | ATLAS</title>
    <?php require_once App::URL_INC . "total_css.php"; ?>
    <link rel="stylesheet" href="<?php echo App::URL_CSS . "trabajadores.css"; ?>">
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
                    <span class="ms-4 fw-bold fs-4 mt-3 text-white">Registro De Familiares</span>
                </div>
                <img src="<?php echo App::URL_IMG . "top-header.png"; ?>" alt="" class="w-100 h-100" style="object-fit: cover; object-position:center;">
            </div>
            <!-- SUB MENU DEL MODULO -->
            <?php require_once App::URL_INC . "utils/menu_registro.php" ?>
            <!-- FORMULARIO DE ENVIOS DE DATOS DE EMPLEADO -->
            <div class="container-fluid px-3">
                <form action="#" class="justify'content-center formulario_empleado contact-form form-validate justify-content-center" novalidate="novalidate" id="formulario_empleado">
                    <div class=" col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 ">
                        <div class="row col-sm-12 col-md-9 h-100 bg-white w-100 p-2 m-0 content">
                            <p class="mb-0 mt-2">Datos del Empleado</p>
                            <hr class="mb-3">
                            <div class="col-sm-4 col-xl-4 col-xxl-4  mb-2">
                                <label class="form-label mb-0" for="cedula_trabajador">Cédula</label>
                                <div class="input-group">
                                    <span class="input-group-text span_cedula_empleado "><i class="icons fa-regular fa-address-card"></i></span>
                                    <input type="text" class="form-control " id="cedula_trabajador" name="cedulaEmpleado" placeholder="Cédula">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4 col-xl-4 col-xxl-4  mb-2">
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <div class="input-group">
                                        <span class="input-group-text span_nombre"><i class="icons fa-regular fa-user"></i></span>
                                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Primer Nombre" required readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4 col-xl-4 col-xxl-4 mb-2">
                                <div class="form-group">
                                    <label for="apellido">apellido</label>
                                    <div class="input-group">
                                        <span class="input-group-text span_apellido"><i class="icons fa-regular fa-user"></i></span>
                                        <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Primer Nombre" required readonly>
                                    </div>
                                </div>
                            </div>

                            <p class="mb-0 mt-2">Datos Del Familiar</p>
                            <hr class="mb-3">
                            <!-- <div class="contenCedula d-flex mb-3">
                                <div class="cedu ceduact" id="cedulado">Cédulado</div>
                                <div class="cedu " id="noCedulado">No Cédulado</div>
                            </div> -->
                            <div class=" d-flex justify-content-center">
                                <!-- CHECK NO CEDULADO -->
                                <div class="checkbox-wrapper-12 d-flex me-3">
                                    <div class="cbx ">
                                        <input id="noCedula" class="cumplidoNormal" type="checkbox" disabled />
                                        <label for="noCedula"></label>
                                        <i class="icons fa-solid fa-check fa-xs"></i>
                                    </div>
                                    <p>No Cédulado</p>
                                </div>

                                <!-- CHECK DE DISCAPACIDAD -->
                                <div class="checkbox-wrapper-12 d-flex">
                                    <div class="cbx ">
                                        <input id="disca" class="cumplidoNormal" type="checkbox" disabled />
                                        <label for="disca"></label>
                                        <i class="icons fa-solid fa-check fa-xs"></i>
                                    </div>
                                    <p>Discapacidad</p>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-xl-4 col-xxl-4 mb-3">
                                <div class="form-group">
                                    <label for="primerNombre">Primer Nombre</label>
                                    <div class="input-group">
                                        <span class="input-group-text span_nombre1"><i class="icons fa-regular fa-user"></i></span>
                                        <input type="text" class="form-control" id="primerNombre" name="primerNombre" placeholder="Primer Nombre" required disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-6 col-xl-4 col-xxl-4 mb-3">
                                <div class="form-group">
                                    <label for="segundoNombre">Segundo Nombre</label>
                                    <div class="input-group ">
                                        <span class="input-group-text span_nombre2"><i class="icons fa-regular fa-user"></i></span>
                                        <input type="text" class="form-control" id="segundoNombre" name="segundoNombre" placeholder="Segundo Nombre" required disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-6 col-xl-4 col-xxl-4 mb-3">
                                <div class="form-group">
                                    <label for="primerApellido">Primer Apellido</label>
                                    <div class="input-group">
                                        <span class="input-group-text span_apellido1"><i class="icons fa-regular fa-user"></i></span>
                                        <input type="text" class="form-control" id="primerApellido" name="primerApellido" placeholder="Primer Apellido" required disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-6 col-xl-4 col-xxl-4 mb-3" id="contenApellidoDos">
                                <div class="form-group">
                                    <label for="segundoApellido">Segundo Apellido</label>
                                    <div class="input-group">
                                        <span class="input-group-text span_apellido2"><i class="icons fa-regular fa-user"></i></span>
                                        <input type="text" class="form-control" id="segundoApellido" name="segundoApellido" placeholder="segundo Apellido" required disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-6 col-xl-4 col-xxl-4 mb-3" id="contenCedula">
                                <div class="form-group">
                                    <label for="cedula">Cédula</label>
                                    <div class="input-group">
                                        <span class="input-group-text span_cedula "><i class="icons fa-regular fa-address-card"></i></span>
                                        <input type="text" class="form-control " id="cedula" name="cedula" placeholder="Cédula de Identidad" required disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-6 col-xl-4 col-xxl-4 mb-3 ">
                                <div class="form-group">
                                    <label for="parentesco">Parentesco</label>
                                    <div class="input-group">
                                        <span class="input-group-text span_parentesco"><i class="icons fa-regular fa-clipboard"></i></span>
                                        <select class="form-select form-select-md estado-parentesco" id="parentesco" name="parentesco" aria-label="Small select example" aria-placeholder="dasdas" required disabled>
                                            <option value="">Selecione</option>
                                            <option value="Hijo">Hijo</option>
                                            <option value="Hija">Hija</option>
                                            <option value="Padre">Padre</option>
                                            <option value="Madre">Madre</option>
                                            <option value="Hermano">Hermano</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-6 col-xl-4 col-xxl-4 mb-3" id="contenEdad">
                                <div class="form-group">
                                    <label for="cedula">Edad</label>
                                    <div class="input-group">
                                        <span class="input-group-text span_edad"><i class="icons fa-regular fa-user-clock"></i></span>
                                        <input type="text" class="form-control" id="edad" name="edad" placeholder="Edad Del Familiar" required disabled>
                                    </div>
                                    <p class="parrafo fs-6 fw-light mb-0">La edad del familiar se ingresa automáticamente con la fecha de nacimiento.</p>
                                </div>
                            </div>

                            <div class="col-sm-6  col-xl-12 col-xxl-12 mb-2" id="contenDoc">
                                <div class="form-group">
                                    <label for="correo">Partida De Nacimiento</label>
                                    <div class="input-group">
                                        <span class="input-group-text span_docArchivo"><i class="icons fa-regular fa-file-zipper"></i></span>
                                        <input type="file" class="form-control" name="docArchivo" id="achivo" aria-describedby="inputGroupFileAddon04" aria-label="Upload" required disabled>
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="col-sm-12 mb-2" id="contentPartida">
                                <div class="form-group">
                                    <label for="correo">Partida De Discapacidad</label>
                                    <div class="input-group">
                                        <span class="input-group-text span_docArchivoDis"><i class="fa-regular fa-file-zipper"></i></span>
                                        <input type="file" class="form-control" name="docArchivoDis" id="achivoDis" aria-describedby="inputGroupFileAddon04" aria-label="Upload" required>
                                    </div>
                                </div>
                            </div> -->

                            <p class="mb-0">Fecha de nacimiento</p>
                            <hr class="mb-2">

                            <div class="col-sm-4 mb-2">
                                <div class="form-group">
                                    <label class="required-field" for="message">Año</label>
                                    <div class="input-group">
                                        <span class="input-group-text span_ano "><i class="icons fa-regular fa-calendar"></i></i></span>
                                        <select class="form-select form-select-md" name="ano" id="ano" required disabled></select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4 mb-2">
                                <div class="form-group">
                                    <label class="required-field" for="message">Mes</label>
                                    <div class="input-group">
                                        <span class="input-group-text span_mes"><i class="icons fa-regular fa-calendar"></i></i></span>
                                        <select class="form-select" id="meses" name="meses" aria-label="Default select example" required disabled></select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4 mb-3">
                                <div class="form-group ">
                                    <label class="required-field" for="message">Día</label>
                                    <div class="input-group">
                                        <span class="input-group-text span_dia"><i class="icons fa-regular fa-calendar"></i></i></span>
                                        <select class="form-select w-5" id="dia" name="dia" aria-label="Default select example" required disabled></select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 ">
                                <button type="submit" id="aceptar_emepleado" name="aceptar" class="btn btn-success" disabled>
                                    <i class="fa-solid fa-plus me-2"></i>Aceptar
                                </button>
                                <button type="button" id="limpiar" name="submit" class="btn btn-warning" style="color: white;">
                                    <i class="fa-solid fa-rotate-right me-2"></i>Limpiar
                                </button>
                            </div>
                        </div>
                        <div style="background-color:#FE9001;" class="barra_naranja"></div>
                    </div>
                </form>
            </div>
        </main>
        <?php require_once App::URL_INC . "/footer.php"; ?>
    </div>
    <?php require_once App::URL_INC . "/scrips.php"; ?>
    <script src="./src/libs/select2/select2.min.js"></script>
    <script src="<?php echo App::URL_SCRIPS . "familiares.js" ?>" type="module"></script>
</body>

</html>