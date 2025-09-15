<?php

use App\Atlas\config\App;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro | ATLAS</title>
    <!-- CSS DEL SISTEMA -->
    <?php require_once App::URL_INC . "total_css.php"; ?>
    <link rel="stylesheet" href="<?php echo App::URL_CSS . "registroPersonal.css"; ?>">
    <link rel="stylesheet" href="<?php echo App::URL_CSS . "Utils/checkbox.css"; ?>">
    <link rel="stylesheet" href="<?php echo App::URL_CSS . "Utils/formularios.css"; ?>">
    <link rel="stylesheet" href="<?php echo App::URL_CSS . "Utils/calendario.css"; ?>">
    <link rel="stylesheet" href="<?php echo App::URL_CSS . "Utils/botones.css"; ?>">
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
<?php require_once App::URL_INC . "load.php"; ?>
    <div class="app-wrapper conten-main" id="conten-main">
        <!-- MENUS DEL SISTEMA -->
        <?php require_once App::URL_INC . "utils/menu.php"; ?>
        <main class="app-main p-0 pb-4">
            <div class="imagen-pages mb-3" style="height: 75px;">
                <div class="d-flex aling-items-center " style="position: absolute; ">
                    <span class="ms-4 fw-bold fs-4 mt-3 text-white">Registro De Empleado</span>
                </div>
                <img loading="lazy" src="<?php echo App::URL_IMG . "top-header.webp"; ?>" alt="" class="w-100 h-100" style="object-fit: cover; object-position:center;">
            </div>
            <!-- SUB MENU DEL SISTEMA -->
            <!-- <?php require_once App::URL_INC . "utils/menu_registro.php" ?> -->
            <div class="container-fluid px-3">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-8 col-xxl-8 px-0 mb-2 form-validate " style="text-align: center;">
                        <!-- formulario de registro multi uso de los empleados -->
                        <form role="form " action="" method="post" class="f1 pt-5 px-4 formValidar content" id="formulario_registro" autocomplete="off">
                            <h3 class="title-form">Registrar Empleado</h3>
                            <div class="f1-steps pasos">
                                <div class="f1-progress">
                                    <div class="f1-progress-line" data-now-value="16.66" data-number-of-steps="3" style="width: 16.66%;"></div>
                                </div>
                                <div class="f1-step active">
                                    <div class="f1-step-icon"><i class="fa fa-user"></i></div>
                                    <p>Paso 1</p>
                                </div>
                                <div class="f1-step">
                                    <div class="f1-step-icon"><i class="fa-regular fa-location-dot"></i></div>
                                    <p>Paso 2</p>
                                </div>
                                <div class="f1-step">
                                    <div class="f1-step-icon"><i class="fa-regular fa-user-graduate"></i></div>
                                    <p>Fin</p>
                                </div>
                            </div>

                            <div class="alert p-0 m-0" id="alert">
                            </div>
                            <!--paso 1 -->
                            <fieldset>
                                <!-- DATOS PERSONALES -->
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                    <div class="row col-sm-12 col-md-7  h-100  w-100 p-2">
                                        <p class="mb-0 mt-1 titulo">Datos del Personal</p>
                                        <hr class="mb-3">

                                        <!-- primer nombre -->
                                        <div class="col-sm-6 col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="primerNombre">Primer Nombre</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_nombre"><i class="icons fa-regular fa-user"></i></span>
                                                    <input type="text" class="form-control" id="primerNombre" name="primerNombre" placeholder="Primer Nombre">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- segundo nombre -->
                                        <div class="col-sm-6 col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="segundoNombre">Segundo Nombre</label>
                                                <div class="input-group ">
                                                    <span class="input-group-text span_nombre2"><i class="icons fa-regular fa-user"></i></span>
                                                    <input type="text" class="form-control" id="segundoNombre" name="segundoNombre" placeholder="Segundo Nombre">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- primer Apellido -->
                                        <div class="col-sm-6 col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="primerApellido">Primer Apellido</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_apellido"><i class="icons fa-regular fa-user"></i></span>
                                                    <input type="text" class="form-control" id="primerApellido" name="primerApellido" placeholder="Primer Apellido">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- segundo Apellido -->
                                        <div class="col-sm-6 col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="segundoApellido">Segundo Apellido</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_apellido2"><i class="icons fa-regular fa-user"></i></span>
                                                    <input type="text" class="form-control" id="segundoApellido" name="segundoApellido" placeholder="segundo Apellido">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- cédula de identidad -->
                                        <div class="col-sm-6 col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="cedula">Cédula</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_cedula"><i class="icons fa-regular fa-address-card"></i></span>
                                                    <input type="text" class="form-control busquedaCedula" id="cedula" name="cedula" placeholder="Cédula de Identidad">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- estado civil del personal -->
                                        <div class="col-sm-6 col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="civil">Estado civil</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_civil"><i class="icons fa-regular fa-handshake"></i></span>
                                                    <select class="form-select form-select-md estado-civil" id="civil" name="civil" aria-label="Small select example" aria-placeholder="dasdas">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- sexo del personal -->
                                        <div class="col-sm-6 mb-2">
                                            <div class="form-group">
                                                <label for="sexo">Sexo</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_sexo"><i class="icons fa-regular fa-person-half-dress"></i></span>
                                                    <select class="form-select form-select-md sexo-sexo" id="sexo" name="sexo" aria-label="Small select example" aria-placeholder="dasdas">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- edad del personal -->
                                        <div class="col-sm-6 col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="edad">Edad</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_edad"><i class="icons fa-regular fa-user-clock"></i></span>
                                                    <input type="text" class="form-control" id="edad" name="edad" placeholder="Edad del personal" readonly>
                                                </div>
                                                <p class="parrafo fs-6 fw-light mb-0">La edad se autocompleta con la fecha de nacimiento</p>
                                            </div>
                                        </div>

                                        <!-- Tipo de discapacidad -->
                                        <div class="col-sm-6 col-md-6 col-xl-6 col-xxl-6 mb-3" id="contenTipoDiscapacidad">
                                            <div class="form-group">
                                                <label for="tpDiscapacidad">Tipo De Discapacidad</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_tpDiscapacidad"><i class="icons fa-solid fa-wheelchair-move"></i></span>
                                                    <select type="text" class="form-control ignore-validation cumplidoNormal" id="tpDiscapacidad" name="tpDiscapacidad" placeholder="Tipo de Discapacidad ">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-xl-12 col-xxl-6 mb-2" id="contentPartida">
                                            <div class="form-group">
                                                <label for="correo">Partida De Discapacidad</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_docArchivoDis"><i class="icons fa-regular fa-file-zipper"></i></span>
                                                    <input type="file" class="form-control ignore-validation cumplidoNormal" name="docArchivoDis" id="achivoDis" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- FECHA DE NACIMIENTO -->
                                        <p class="mb-0 mt-1 titulo">Fecha de nacimiento</p>
                                        <hr class="mb-2">

                                        <!-- año -->
                                        <div class="col-sm-12 col-md-4 col-xl-4 mb-2 ">
                                            <div class="form-group">
                                                <label class="-field" for="ano">Año</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_ano"><i class="icons fa-regular fa-calendars"></i></span>
                                                    <select class="form-select form-select-md" name="ano" id="ano"></select>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- mes -->
                                        <div class="col-sm-12 col-md-4 col-xl-4 mb-2">
                                            <div class="form-group">
                                                <label class="-field" for="meses">Mes</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_mes"><i class="icons fa-regular fa-calendars"></i></span>
                                                    <select class="form-select" id="meses" name="meses" aria-label="Default select example"></select>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- dia -->
                                        <div class="col-sm-12 col-md-4 col-xl-4 mb-2" id="contentDia">
                                            <div class="form-group ">
                                                <label class="-field" for="dia">Día</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_dia"><i class="icons fa-regular fa-calendars"></i></span>
                                                    <select class="form-select w-5" id="dia" name="dia" aria-label="Default select example">
                                                        <option value="">Seleccione un dia</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- MODAL DE ESTADO DE DERECHO DEL EMPLEADO -->
                                <div class="modal modal-lg fade" id="estadoDerecho" tabindex="-1" aria-labelledby="estadoDerechoLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary">
                                                <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">Modal Estado Civil</h1>
                                                <button type="button" class="btn-close text-white cerrarX" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- CEDULA DEL FAMILIAR -->
                                                <div class="d-flex alert alert-warning alert-dismissible m-0 contentAlerta" role="alert">
                                                    <div class="d-flex align-items-center alert-icon me-3">
                                                        <i class="fas fa-exclamation-triangle"></i>
                                                    </div>
                                                    <div class="alert-text">
                                                        <strong>Tras aceptar el registro,el familiar </strong> <strong class="text-primary">figurará como pendiente.</strong> Diríjase a <strong class="text-primary">Carga Familiar</strong> y haga click en <strong class="text-primary">Familiar Pendiente </strong> para finalizar el registro.
                                                    </div>
                                                </div>

                                                <div class="container-fluid">
                                                    <div class="row contendorEstadoDerecho">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" id="cerrarModalEstadoDerecho" class="btn btn-secondary btn-hover-gris" data-bs-dismiss="modal"><i class="fa-regular fa-xmark-large fa-sm me-2"></i>Cerrar</button>
                                                <button type="button" id="aceptarModalEstadoDerecho" class="btn btn-primary btn-hover-azul" data-bs-dismiss="modal"><i class="fa-regular fa-thumbs-up me-2"></i>listo</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- BOTONES DE INTECTIVOS DEL FORMULARIO MULTIPLE -->
                                <div class="f1-buttons px-3">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary" id="botonModalEstadoDerecho" data-bs-toggle="modal" data-bs-target="#estadoDerecho">
                                    <i class="fa-regular fa-eye me-2"></i>Ver estado de derecho
                                    </button>
                                    <button type="button" class="btn btn-primary btn-hover-azul buttonDisca" id="asignarDisca">
                                        <i class="fa-solid fa-plus me-2"></i>
                                        Asignar Discapacidad
                                    </button>
                                    <button type="button" class="btn btn-primary btn-hover-azul mostrar-boton-imagen" id="buttonModalImagen">
                                    <i class="fa-regular fa-images-user me-2"></i>
                                    Ver Imagen</button>
                                    <button type="button" class="btn btn-next btn-warning text-white btn-hover-amarillo"><i class="fa-solid fa-arrow-right me-2"></i>Siguiente</button>
                                </div>
                            </fieldset>
                            <!--fin del paso 1 -->

                            <!---paso 2 -->
                            <fieldset>
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                    <div class="row col-sm-12 col-md-7  h-100   w-100 p-2">
                                        <!-- DATOS DE UBICACION -->
                                        <p class="mb-0 mt-2 titulo">Ubicación</p>
                                        <hr class="mb-2">

                                        <!-- ESTADO -->
                                        <div class="col-sm-6 mb-2">
                                            <div class="form-group">
                                                <label for="estado">Estado</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_estado"><i class="icons fa-regular fa-location-dot"></i></span>
                                                    <select class="form-select form-select-md estado-estado" id="estado" name="estado" aria-label="Small select example" aria-placeholder="dasdas">
                                                        <option value="">Selecione un estado</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- municipio -->
                                        <div class="col-sm-6 mb-2">
                                            <div class="form-group">
                                                <label for="municipio">Municipio</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_municipio"><i class="icons fa-regular fa-location-dot"></i></span>
                                                    <select class="form-select form-select-md municipio-municipio" id="municipio" name="municipio" aria-label="Small select example" aria-placeholder="dasdas">
                                                        <option value="">Seleccione un municipio</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- parroquia -->
                                        <div class="col-sm-6 mb-2">
                                            <div class="form-group">
                                                <label for="parroquia">Parroquia</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_parroquia"><i class="icons fa-regular fa-location-dot"></i></span>
                                                    <select class="form-select form-select-md parroquia-parroquia" id="parroquia" name="parroquia" aria-label="Small select example" aria-placeholder="dasdas">
                                                        <option value="">Selecione un parroquia</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- vivienda -->
                                        <div class="col-sm-6 mb-2">
                                            <div class="form-group">
                                                <label for="vivienda">Vivienda</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_vivienda"><i class="icons fa-regular fa-house-building"></i></span>
                                                    <select class="form-select form-select-md vivienda-vivienda" id="vivienda" name="vivienda" aria-label="Small select example" aria-placeholder="dasdas">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- calle -->
                                        <div class="col-sm-6 col-md-6 mb-2" id="contenCalle">
                                            <div class="form-group">
                                                <label for="calle">Calle</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_calle"><i class="icons fa-regular fa-road"></i></span>
                                                    <input type="text" class="form-control" id="calle" name="calle" placeholder="Nombre de la Calle">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- BOTONES DE INTECTIVOS DEL FORMULARIO MULTIPLE -->
                                        <div class="f1-buttons px-3 mt-3">
                                            <button type="button" class="btn btn-previous btn-secondary btn-hover-gris"><i class="fa-solid fa-arrow-left me-2"></i>Atrás</button>
                                            <button type="button" class="btn btn-next btn-warning text-white btn-hover-amarillo"><i class="fa-solid fa-arrow-right me-2"></i>Siguiente</button>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <!--fin del paso 2 -->

                            <!--paso fin -->
                            <fieldset>
                                <!-- DATOS DEL TRABAJADOR -->
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                    <div class="row col-sm-12 col-md-7  h-100   w-100 p-2">
                                        <p class="mb-0 mt-2 titulo">Datos Del Trabajador</p>
                                        <hr class="mb-2">

                                        <!-- cargar contrato colectivo -->
                                        <div class="col-sm-12 mb-2">
                                            <div class="form-group">
                                                <label for="contrato">Contrato</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_contrato"><i class="icons fa-regular fa-file-zipper"></i></span>
                                                    <input type="file" class="form-control" name="contratoArchivo" id="contrato" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- cargar notificacion -->
                                        <div class="col-sm-12 mb-2">
                                            <div class="form-group">
                                                <label for="notificacion">Notificación</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_notificacion"><i class="icons fa-regular fa-file-zipper"></i></span>
                                                    <input type="file" name="notacionAchivo" class="form-control" id="notificacion" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- fecha de ingreso  -->
                                        <div class="col-sm-6 col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="fechaing">Fecha Ingreso</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_fechaing"><i class="icons fa-regular fa-user-tie"></i></span>
                                                    <input type="text" class="form-control" id="fechaing3" name="fechaing" placeholder="Fecha de Ingreso">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- número de telefono movil del trabajador -->
                                        <div class="col-sm-6 mb-2">
                                            <label class="form-label mb-0" for="telefono">N.Telefono</label>
                                            <div class="input-group">
                                                <span class="input-group-text span_telefono"><i class="icons fa-regular fa-mobile-notch"></i></span>
                                                <div class="col-sm-4">
                                                    <select class="form-select " name="linea" id="linea" style="border-radius: 0px; height: 39px;">
                                                        <option value="0412">0412</option>
                                                        <option value="0416">0416</option>
                                                        <option value="0424">0424</option>
                                                        <option value="0426">0426</option>
                                                    </select>
                                                </div>

                                                <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Telefono">
                                            </div>
                                        </div>

                                        <!-- estatus del trabajador -->
                                        <div class="col-sm-6 mb-2">
                                            <div class="form-group">
                                                <label for="estatus">Estatus</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_estatus"><i class="icons fa-regular fa-clipboard"></i></span>
                                                    <select class="form-select form-select-md estado-estatus" id="estatus" name="estatus" aria-label="Small select example" aria-placeholder="dasdas" style="border-radius: 5px">
                                                        <option value="">Selecione un estatus</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- cargo del trabajador -->
                                        <div class="col-sm-6 mb-2">
                                            <div class="form-group">
                                                <label for="cargo">Cargo</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_cargo"><i class="icons fa-duotone fa-regular fa-arrows-down-to-people"></i></span>
                                                    <select class="form-select form-select-md estado-cargo" id="cargo" name="cargo" aria-label="Small select example" aria-placeholder="dasdas">
                                                        <option value="">Selecione un cargo</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- cargar departamento -->
                                        <div class="col-sm-12 mb-2">
                                            <div class="form-group">
                                                <label for="departamento">Departamento</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_departamento"><i class="icons fa-regular fa-building-user"></i></span>
                                                    <select class="form-select form-select-md estado-departamento" id="departamento" name="departamento" aria-label="Small select example" aria-placeholder="dasdas">
                                                        <option value="">Selecione un departamento</option>d
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- cargar dependencia -->
                                        <div class="col-sm-12 mb-2">
                                            <div class="form-group">
                                                <label for="dependencia">Dependencia</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_dependencia"><i class="icons fa-regular fa-building-memo"></i></span>
                                                    <select class="form-select form-select-md estado-dependencia " id="dependencia" name="dependencia" aria-label="Small select example" aria-placeholder="dasdas">
                                                        <option value="">Selecione la dependencia</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- cargar nivel academico -->
                                        <div class="col-sm-12 mb-2">
                                            <div class="form-group">
                                                <label for="academico">Nivel Academico</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_academico"><i class="icons fa-regular fa-user-graduate"></i></span>
                                                    <select class="form-select form-select-md" id="academico" name="nivelAcademico">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- BOTONES DE INTECTIVOS DEL FORMULARIO MULTIPLE -->
                                <div class="f1-buttons px-3">
                                    <button type="button" class="btn btn-previous btn-secondary btn-hover-gris"><i class="fa-solid fa-arrow-left me-2"></i>Atrás</button>
                                    <button type="submit" class="btn btn-warning text-white btn-hover-amarillo" id="aceptar"><i class="fa-regular fa-thumbs-up me-2"></i>Guardar Información</button>
                                </div>
                            </fieldset>
                            <!--fin -->

                        </form>
                        <div style="background-color:#FE9001;" class="barra_naranja w-100"></div>
                    </div>
                    <div class="container col-sm-12 col-md-5 col-lg-5 col-xl-4 col-xxl-4 pe-0">
                        <div class="w-100 bg-white containerImg col-12 mb-3" style="height: 400px;">
                            <div class="content d-flex justify-content-center align-items-center h-100 w-100" id="img-contener">
                                <!-- Contenido aquí -->
                            </div>
                            <div style="background-color:#FE9001;" class="barra_naranja w-100" id="barra"></div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <!-- FOOTER DEL SISTEMA -->
        <?php require_once App::URL_INC . "/footer.php"; ?>
    </div>

<!-- SCRIPS DEL SISTEMA JS  -->
<?php require_once App::URL_INC . "/scrips.php"; ?>

<script src="<?php echo App::URL_SCRIPS . "empleado/registraEmpleado.js" ?>" type="module" defer></script>
</body>

</html>