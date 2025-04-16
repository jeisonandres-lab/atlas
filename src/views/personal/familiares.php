<?php

use App\Atlas\config\App;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trabajadores | ATLAS</title>
    <!-- css -->
    <?php require_once App::URL_INC . "total_css.php"; ?>
    <!-- css de esta pagina -->
    <link rel="stylesheet" href="<?php echo App::URL_CSS . "trabajadores.css"; ?>">

</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <!-- load de carga de la pagina -->
    <?php require("./src/views/inc/load.php"); ?>
    <div class="app-wrapper conten-main" id="conten-main">
        <!-- MENU DEL SISTEMA -->
        <?php require_once App::URL_INC . "utils/menu.php"; ?>
        <!-- CUERPO DEL SISTEMA -->
        <main class=" app-main p-0 pb-4">
            <!-- NOMBRE DEL MODULO -->
            <div class="imagen-pages mb-3" style="height: 75px;">
                <div class="d-flex aling-items-center " style="position: absolute; ">
                    <span class="ms-4 fw-bold fs-4 mt-3 text-white">Registro De Familiares</span>
                </div>
                <img src="<?php echo App::URL_IMG . "top-header.webp"; ?>" alt="" class="w-100 h-100" style="object-fit: cover; object-position:center;">
            </div>

            <!-- SUB MENU DEL MODULO DEL SISTEMA-->
            <?php require_once App::URL_INC . "utils/menu_registro.php" ?>
            <!-- FORMULARIO DE ENVIOS DE DATOS DE EMPLEADO -->
            <div class="container-fluid px-3">
                <form action="#" style="font-size: 16px;" class="justify-content-center formulario_empleado contact-form form-validate justify-content-center" novalidate="novalidate" id="formulario_empleado">
                    <div class=" col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 ">
                        <div class="row col-sm-12 col-md-9 h-100 bg-white w-100 p-2 m-0 content">
                            <p class="mb-0 mt-2 titulo">Datos del Empleado</p>
                            <hr class="mb-3">

                            <!-- cedula del empledao a asignar familiar -->
                            <div class="col-sm-12 col-xl-3 col-xxl-3  mb-2">
                                <label class="form-label mb-0" for="cedula_trabajador">Cédula</label>
                                <div class="input-group">
                                    <span class="input-group-text span_cedula_empleado "><i class="icons fa-regular fa-address-card"></i></span>
                                    <input type="text" class="form-control " id="cedula_trabajador" name="cedulaEmpleado" placeholder="Cédula">
                                </div>
                            </div>

                            <!-- nombre del empleado -->
                            <div class="col-sm-12 col-md-3 col-xl-3 col-xxl-3  mb-2">
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <div class="input-group">
                                        <span class="input-group-text span_nombre"><i class="icons fa-regular fa-user"></i></span>
                                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Primer Nombre" required readonly>
                                    </div>
                                </div>
                            </div>

                            <!-- apellido del empleado -->
                            <div class="col-sm-12 col-md-3 col-xl-3 col-xxl-3 mb-2">
                                <div class="form-group">
                                    <label for="apellido">Apellido</label>
                                    <div class="input-group">
                                        <span class="input-group-text span_apellido"><i class="icons fa-regular fa-user"></i></span>
                                        <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Primer Nombre" required readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 col-xl-3 col-xxl-3 d-flex align-items-end mt-2 mb-2">
                                <button type="button" id="buttonPendiente" class="btn btn-warning btn-hover-amarillo text-white w-100 h-75 " data-bs-toggle="modal" data-bs-target="#modalPendiente"><i class="fa-regular fa-restroom fa-sm me-2"></i>Familiar Pendiente</button>
                            </div>

                            <p class="mb-0 mt-2 titulo">Datos Del Familiar</p>
                            <hr class="mb-3">

                            <!-- contenedor de checkbox de seleccion  -->
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
                                <div class="checkbox-wrapper-12 d-flex me-3">
                                    <div class="cbx ">
                                        <input id="disca" class="cumplidoNormal" type="checkbox" disabled />
                                        <label for="disca"></label>
                                        <i class="icons fa-solid fa-check fa-xs"></i>
                                    </div>
                                    <p>Discapacidad</p>
                                </div>

                                <!-- CHECK DE ESTADO DE DERECHO -->
                                <div class="checkbox-wrapper-12 d-flex me-3">
                                    <div class="cbx ">
                                        <input id="estadoDerecho" class="cumplidoNormal" type="checkbox" disabled />
                                        <label for="estadoDerecho"></label>
                                        <i class="icons fa-solid fa-check fa-xs"></i>
                                    </div>
                                    <p>Estado Derecho</p>
                                </div>

                                <!-- CHECK DE TRABAJADOR INCES -->
                                <div class="checkbox-wrapper-12 d-flex">
                                    <div class="cbx ">
                                        <input id="familiarInces" class="cumplidoNormal" type="checkbox" disabled />
                                        <label for="familiarInces"></label>
                                        <i class="icons fa-solid fa-check fa-xs"></i>
                                    </div>
                                    <p>Familiar INCES</p>
                                </div>
                            </div>

                            <!-- ALERTAs  -->
                            <div class="" id="alerta"></div>
                            <div class="noCedulada" id="alertaNoCedula"></div>

                            <!-- primer nombre del familiar -->
                            <div class="col-sm-6 col-md-4 col-xl-4 col-xxl-3 mb-3">
                                <div class="form-group">
                                    <label for="primerNombre">Primer Nombre</label>
                                    <div class="input-group">
                                        <span class="input-group-text span_nombre1"><i class="icons fa-regular fa-user"></i></span>
                                        <input type="text" class="form-control" id="primerNombre" name="primerNombre" placeholder="Primer Nombre" required disabled>
                                    </div>
                                </div>
                            </div>

                            <!-- segundo nombre del familiar -->
                            <div class="col-sm-6 col-md-4 col-xl-4 col-xxl-3 mb-3">
                                <div class="form-group">
                                    <label for="segundoNombre">Segundo Nombre</label>
                                    <div class="input-group ">
                                        <span class="input-group-text span_nombre2"><i class="icons fa-regular fa-user"></i></span>
                                        <input type="text" class="form-control" id="segundoNombre" name="segundoNombre" placeholder="Segundo Nombre" required disabled>
                                    </div>
                                </div>
                            </div>

                            <!-- primer apellido del familiar -->
                            <div class="col-sm-6 col-md-4 col-xl-4 col-xxl-3 mb-3">
                                <div class="form-group">
                                    <label for="primerApellido">Primer Apellido</label>
                                    <div class="input-group">
                                        <span class="input-group-text span_apellido1"><i class="icons fa-regular fa-user"></i></span>
                                        <input type="text" class="form-control" id="primerApellido" name="primerApellido" placeholder="Primer Apellido" required disabled>
                                    </div>
                                </div>
                            </div>

                            <!-- segundo apellido del familiar -->
                            <div class="col-sm-6 col-md-4 col-xl-4 col-xxl-3 mb-3" id="contenApellidoDos">
                                <div class="form-group">
                                    <label for="segundoApellido">Segundo Apellido</label>
                                    <div class="input-group">
                                        <span class="input-group-text span_apellido2"><i class="icons fa-regular fa-user"></i></span>
                                        <input type="text" class="form-control" id="segundoApellido" name="segundoApellido" placeholder="segundo Apellido" required disabled>
                                    </div>
                                </div>
                            </div>

                            <!-- cedula del familiar -->
                            <div class="col-sm-6 col-md-4 col-xl-4 col-xxl-3 mb-3" id="contenCedula">
                                <div class="form-group">
                                    <label for="cedula">Cédula</label>
                                    <div class="input-group">
                                        <span class="input-group-text span_cedula "><i class="icons fa-regular fa-address-card"></i></span>
                                        <input type="text" class="form-control " id="cedula" name="cedula" placeholder="Cédula de Identidad" required disabled>
                                    </div>
                                </div>
                            </div>

                            <!-- tomo de la aprtida de nacimiento del familiar -->
                            <div class="col-sm-6 col-md-4 col-xl-4 col-xxl-3 mb-3" id="contenTomo">
                                <div class="form-group">
                                    <label for="tomo">Tomo</label>
                                    <div class="input-group">
                                        <span class="input-group-text span_tomo"><i class="icons fa-regular fa-book"></i></span>
                                        <input type="text" class="form-control" id="tomo" name="tomo" placeholder="Numero de tomo" required disabled>
                                    </div>
                                </div>
                            </div>

                            <!-- folio de la partida de nacimiento -->
                            <div class="col-sm-6 col-md-4 col-xl-4 col-xxl-3 mb-3" id="contenFolio">
                                <div class="form-group">
                                    <label for="folio">Folio</label>
                                    <div class="input-group">
                                        <span class="input-group-text span_folio"><i class="icons fa-regular fa-book-open-cover"></i></span>
                                        <input type="text" class="form-control" id="folio" name="folio" placeholder="Número de folio" required disabled>
                                    </div>
                                </div>
                            </div>

                            <!-- parentesco con el familiar -->
                            <div class="col-sm-6 col-md-4 col-xl-4 col-xxl-3 mb-3 ">
                                <div class="form-group">
                                    <label for="parentesco">Parentesco</label>
                                    <div class="input-group">
                                        <span class="input-group-text span_parentesco"><i class="icons fa-regular fa-person-half-dress"></i></span>
                                        <select class="form-select form-select-md estado-parentesco" id="parentesco" name="parentesco" aria-label="Small select example" aria-placeholder="dasdas" required disabled>
                                            <option value="">Selecione un parentesco</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- sexo del familiar -->
                            <div class="col-sm-6 col-md-4 col-xl-4 col-xxl-3 mb-2 ">
                                <div class="form-group">
                                    <label for="sexo">Sexo</label>
                                    <div class="input-group">
                                        <span class="input-group-text span_sexo"><i class="icons fa-regular fa-person-half-dress"></i></span>
                                        <select class="form-select form-select-md sexo-sexo" id="sexo" name="sexo" aria-label="Small select example" aria-placeholder="dasdas" required disabled>
                                            <option value="">Selecione el sexo</option>
                                            <option value="Masculino">Masculino</option>
                                            <option value="Femenino">Femenino</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- edad del familiar -->
                            <div class="col-sm-6 col-md-4 col-xl-4 col-xxl-3 mb-2" id="contenEdad">
                                <div class="form-group">
                                    <label for="cedula">Edad</label>
                                    <div class="input-group">
                                        <span class="input-group-text span_edad"><i class="icons fa-regular fa-user-clock"></i></span>
                                        <input type="number" class="form-control" id="edad" name="edad" placeholder="Edad Del Familiar" readonly required disabled>
                                    </div>
                                    <p class="parrafo fs-6 fw-light mb-0">La edad del familiar se ingresa automáticamente con la fecha de nacimiento.</p>
                                </div>
                            </div>

                            <!-- partida de nacimiento del familiar -->
                            <div class="col-sm-6  col-xl-12 col-xxl-6 mb-2" id="contenDoc">
                                <div class="form-group">
                                    <label for="docArchivo">Partida De Nacimiento</label>
                                    <div class="input-group">
                                        <span class="input-group-text span_docArchivo"><i class="icons fa-regular fa-file-zipper"></i></span>
                                        <input type="file" class="form-control partidaNacimiento" name="docPartidaNacimiento" id="archivo" aria-describedby="inputGroupFileAddon04" aria-label="Upload" required disabled>
                                    </div>
                                </div>
                            </div>


                            <p class="mb-0 titulo">Fecha de nacimiento</p>
                            <hr class="mb-2">

                            <!-- año en que nacio el familiar -->
                            <div class="col-sm-4 mb-2">
                                <div class="form-group">
                                    <label class="required-field" for="message">Año</label>
                                    <div class="input-group">
                                        <span class="input-group-text span_ano "><i class="icons fa-regular fa-calendars"></i></span>
                                        <select class="form-select form-select-md" name="ano" id="ano" required disabled></select>
                                    </div>
                                </div>
                            </div>

                            <!-- mes en cuando nacio el familiar -->
                            <div class="col-sm-4 mb-2">
                                <div class="form-group">
                                    <label class="required-field" for="message">Mes</label>
                                    <div class="input-group">
                                        <span class="input-group-text span_mes"><i class="icons fa-regular fa-calendars"></i></span>
                                        <select class="form-select" id="meses" name="meses" aria-label="Default select example" required disabled></select>
                                    </div>
                                </div>
                            </div>

                            <!-- dia en que nacio el familiar -->
                            <div class="col-sm-4 mb-3">
                                <div class="form-group ">
                                    <label class="required-field" for="message">Día</label>
                                    <div class="input-group">
                                        <span class="input-group-text span_dia"><i class="icons fa-regular fa-calendars"></i></span>
                                        <select class="form-select w-5" id="dia" name="dia" aria-label="Default select example" required disabled></select>
                                    </div>
                                </div>
                            </div>

                            <!-- botones de acciones  -->
                            <div class="col-sm-12 ">
                                <button type="submit" id="aceptar_emepleado" name="aceptar" class="btn btn-primary btn-hover-azul" disabled>
                                    <i class="fa-solid fa-thumbs-up fa-sm me-2"></i>Aceptar
                                </button>
                                <button type="button" id="limpiar" name="submit" class="btn btn-warning btn-hover-amarillo text-white">
                                    <i class="fa-solid fa-rotate-right me-2"></i>Limpiar
                                </button>
                            </div>
                        </div>
                        <div style="background-color:#FE9001;" class="barra_naranja"></div>
                    </div>
                </form>
            </div>


            <!-- Modal Para buscar familiar es estado pendiente -->
            <div class="modal fade" id="modalPendiente" tabindex="-1" aria-labelledby="modalPendienteLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-primary ">
                            <h1 class="modal-title fs-5 text-white" id="modalPendienteLabel">Buscar familiar pendiente</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="" class="burcadorCedula" id="formularioPendiente">
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-sm-12 mb-3">
                                            <!-- cedula del familiar en estado pendiente -->
                                            <div class="form-group ">
                                                <label class="required-field" for="cedulaPendiente">Cédula</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_cedulaFamiliarPendiente"><i class="icons fa-regular fa-address-card"></i></span>
                                                    <input type="text" class="form-control " id="cedulaFamiliarPendiente" name="cedulaFamiliar" placeholder="Cédula">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- botones de acciones del modal de familiar pendiente -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-hover-gris btn-sm" data-bs-dismiss="modal"><i class="fa-regular fa-xmark-large fa-sm me-2"></i>Cerrar</button>
                                <button type="button" class="btn btn-primary btn-hover-azul btn-sm" id="buscarFamiliarPendiente"><i class="fa-regular fa-magnifying-glass fa-sm me-2"></i>Buscar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


        </main>

        <!-- footer de la pagina -->
        <?php require_once App::URL_INC . "/footer.php"; ?>
    </div>

    <!-- scrips de js -->
    <?php require_once App::URL_INC . "/scrips.php"; ?>
    <!-- scrip de la pantalla familiar -->
    <script src="<?php echo App::URL_SCRIPS . "familiares.js" ?>" type="module" defer></script>
</body>

</html>